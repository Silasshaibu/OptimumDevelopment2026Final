<?php
/**
 * Export Contact Messages to Excel
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

// Get filter parameters
$statusFilter = $_GET['status'] ?? 'all';
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

if (!empty($searchQuery)) {
    $whereConditions[] = "(CONCAT(first_name, ' ', last_name) LIKE ? OR email LIKE ? OR company LIKE ?)";
    $searchParam = '%' . $searchQuery . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'sss';
}

$whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

$sql = "SELECT * FROM contact_messages $whereClause ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();

// Create new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()
    ->setCreator("Optimum Payments Admin")
    ->setTitle("Contact Messages Export")
    ->setSubject("Contact Messages")
    ->setDescription("Export of contact form messages from Optimum Payments");

// Set column headers
$headers = [
    'A' => 'ID',
    'B' => 'First Name',
    'C' => 'Last Name',
    'D' => 'Email',
    'E' => 'Phone',
    'F' => 'Company',
    'G' => 'Source',
    'H' => 'Message',
    'I' => 'Status',
    'J' => 'IP Address',
    'K' => 'Submitted Date'
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

$sheet->getStyle('A1:K1')->applyFromArray($headerStyle);
$sheet->getRowDimension(1)->setRowHeight(25);

// Write data
$row = 2;
foreach ($messages as $msg) {
    $sheet->setCellValue('A' . $row, $msg['id']);
    $sheet->setCellValue('B' . $row, $msg['first_name']);
    $sheet->setCellValue('C' . $row, $msg['last_name']);
    $sheet->setCellValue('D' . $row, $msg['email']);
    $sheet->setCellValue('E' . $row, $msg['phone'] ?? '');
    $sheet->setCellValue('F' . $row, $msg['company'] ?? '');
    $sheet->setCellValue('G' . $row, ucfirst($msg['source']));
    $sheet->setCellValue('H' . $row, $msg['message']);
    $sheet->setCellValue('I' . $row, ucfirst($msg['status']));
    $sheet->setCellValue('J' . $row, $msg['ip_address']);
    $sheet->setCellValue('K' . $row, date('Y-m-d H:i:s', strtotime($msg['created_at'])));
    
    $row++;
}

// Auto-size columns
foreach (range('A', 'K') as $col) {
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
    $sheet->getStyle('A2:K' . $lastRow)->applyFromArray($dataStyle);
}

// Freeze header row
$sheet->freezePane('A2');

// Set filename
$filename = 'contact_messages_' . date('Y-m-d_His') . '.xlsx';

// Output headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Write file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
