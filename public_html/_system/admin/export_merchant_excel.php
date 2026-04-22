<?php
/**
 * Export Merchant Applications to Excel
 * 
 * Requires PhpSpreadsheet library
 * Install: composer require phpoffice/phpspreadsheet
 */

session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

// Check if PhpSpreadsheet is available
if (!file_exists('../../vendor/autoload.php')) {
    die('PhpSpreadsheet not installed. Run: composer require phpoffice/phpspreadsheet');
}

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Get filter parameters (same as merchant_applications.php)
$statusFilter = $_GET['status'] ?? 'all';
$confirmedFilter = $_GET['confirmed'] ?? 'all';
$searchQuery = $_GET['search'] ?? '';

// Build query
$whereConditions = [];
$params = [];
$types = '';

if ($statusFilter !== 'all') {
    $whereConditions[] = "status = ?";
    $params[] = $statusFilter;
    $types .= 's';
}

if ($confirmedFilter === 'confirmed') {
    $whereConditions[] = "confirmed = 1";
} elseif ($confirmedFilter === 'unconfirmed') {
    $whereConditions[] = "confirmed = 0";
}

if (!empty($searchQuery)) {
    $whereConditions[] = "(company LIKE ? OR CONCAT(first_name, ' ', surname) LIKE ? OR email LIKE ?)";
    $searchParam = '%' . $searchQuery . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'sss';
}

$whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

$sql = "SELECT * FROM merchant_applications $whereClause ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$applications = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();

// Create new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()
    ->setCreator("Optimum Payments Admin")
    ->setTitle("Merchant Applications Export")
    ->setSubject("Merchant Applications")
    ->setDescription("Export of merchant applications from Optimum Payments");

// Set column headers
$headers = [
    'A' => 'ID',
    'B' => 'Company Name',
    'C' => 'First Name',
    'D' => 'Surname',
    'E' => 'Title',
    'F' => 'Email',
    'G' => 'Phone',
    'H' => 'Fax',
    'I' => 'Address Line 1',
    'J' => 'Address Line 2',
    'K' => 'City',
    'L' => 'State',
    'M' => 'Zip Code',
    'N' => 'Business Type',
    'O' => 'Accepts Cards',
    'P' => 'Previous Cards',
    'Q' => 'Monthly Volume ($$$)',
    'R' => 'Comments',
    'S' => 'Status',
    'T' => 'Confirmed',
    'U' => 'Submitted Date'
];

// Write headers
$row = 1;
foreach ($headers as $col => $header) {
    $sheet->setCellValue($col . $row, $header);
}

// Style header row
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
        'size' => 12
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '667EEA']
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000']
        ]
    ]
];

$sheet->getStyle('A1:U1')->applyFromArray($headerStyle);
$sheet->getRowDimension(1)->setRowHeight(25);

// Write data
$row = 2;
foreach ($applications as $app) {
    $sheet->setCellValue('A' . $row, $app['id']);
    $sheet->setCellValue('B' . $row, $app['company']);
    $sheet->setCellValue('C' . $row, $app['first_name']);
    $sheet->setCellValue('D' . $row, $app['surname']);
    $sheet->setCellValue('E' . $row, $app['title'] ?? '');
    $sheet->setCellValue('F' . $row, $app['email']);
    $sheet->setCellValue('G' . $row, $app['phone']);
    $sheet->setCellValue('H' . $row, $app['fax'] ?? '');
    $sheet->setCellValue('I' . $row, $app['address1'] ?? '');
    $sheet->setCellValue('J' . $row, $app['address2'] ?? '');
    $sheet->setCellValue('K' . $row, $app['city'] ?? '');
    $sheet->setCellValue('L' . $row, $app['state'] ?? '');
    $sheet->setCellValue('M' . $row, $app['zip'] ?? '');
    $sheet->setCellValue('N' . $row, $app['business_type'] ?? '');
    $sheet->setCellValue('O' . $row, strtoupper($app['accept_credit_cards'] ?? ''));
    $sheet->setCellValue('P' . $row, strtoupper($app['previous_credit_cards'] ?? ''));
    $sheet->setCellValue('Q' . $row, $app['monthly_volume']);
    $sheet->setCellValue('R' . $row, $app['comments'] ?? '');
    $sheet->setCellValue('S' . $row, ucfirst(str_replace('_', ' ', $app['status'])));
    $sheet->setCellValue('T' . $row, $app['confirmed'] ? 'Yes' : 'No');
    $sheet->setCellValue('U' . $row, date('Y-m-d H:i:s', strtotime($app['created_at'])));
    
    $row++;
}

// Auto-size columns
foreach (range('A', 'U') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Add borders to data
$dataStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => 'CCCCCC']
        ]
    ]
];

$lastRow = $row - 1;
if ($lastRow > 1) {
    $sheet->getStyle('A2:U' . $lastRow)->applyFromArray($dataStyle);
}

// Freeze header row
$sheet->freezePane('A2');

// Set filename
$filename = 'merchant_applications_' . date('Y-m-d_His') . '.xlsx';

// Output headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Write file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
