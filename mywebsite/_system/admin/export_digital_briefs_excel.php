<?php
/**
 * Export Digital Services Briefs to Excel
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
    $whereConditions[] = "(name LIKE ? OR email LIKE ? OR website LIKE ?)";
    $searchParam = '%' . $searchQuery . '%';
    $params[] = $searchParam;
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'sss';
}

$whereClause = !empty($whereConditions) ? 'WHERE ' . implode(' AND ', $whereConditions) : '';

$sql = "SELECT * FROM digital_briefs $whereClause ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$briefs = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();

// Service names mapping
$serviceNames = [
    'website_design_development' => 'Website Design + Development',
    'app_design_development' => 'App Design + Development',
    'copywriting' => 'Copywriting',
    'packaging_design' => 'Packaging Design',
    'branding' => 'Branding'
];

// Create new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()
    ->setCreator("Optimum Payments Admin")
    ->setTitle("Digital Services Briefs Export")
    ->setSubject("Digital Services Briefs")
    ->setDescription("Export of digital services brief submissions from Optimum Payments");

// Set column headers
$headers = [
    'A' => 'ID',
    'B' => 'Name',
    'C' => 'Email',
    'D' => 'Phone',
    'E' => 'Website',
    'F' => 'Budget Min',
    'G' => 'Budget Max',
    'H' => 'Referral Source',
    'I' => 'Services Requested',
    'J' => 'Comments',
    'K' => 'Status',
    'L' => 'Submitted Date'
];

$sheet->setTitle('Digital Briefs');

// Style header row
$headerStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => 'FFFFFF'],
        'size' => 12
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '4472C4']
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

// Write headers
foreach ($headers as $col => $header) {
    $sheet->setCellValue($col . '1', $header);
}
$sheet->getStyle('A1:L1')->applyFromArray($headerStyle);

// Auto-size columns
foreach (range('A', 'L') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Write data rows
$row = 2;
foreach ($briefs as $brief) {
    // Parse services
    $services = json_decode($brief['services'], true);
    $servicesList = [];
    if (is_array($services)) {
        foreach ($services as $service) {
            $servicesList[] = $serviceNames[$service] ?? $service;
        }
    }
    $servicesText = implode(', ', $servicesList);
    
    $sheet->setCellValue('A' . $row, $brief['id']);
    $sheet->setCellValue('B' . $row, $brief['name']);
    $sheet->setCellValue('C' . $row, $brief['email']);
    $sheet->setCellValue('D' . $row, $brief['phone'] ?: '—');
    $sheet->setCellValue('E' . $row, $brief['website'] ?: '—');
    $sheet->setCellValue('F' . $row, '$' . number_format($brief['budget_min']));
    $sheet->setCellValue('G' . $row, '$' . number_format($brief['budget_max']));
    $sheet->setCellValue('H' . $row, ucfirst($brief['referral_source']));
    $sheet->setCellValue('I' . $row, $servicesText);
    $sheet->setCellValue('J' . $row, $brief['comments'] ?: '—');
    $sheet->setCellValue('K' . $row, ucwords(str_replace('_', ' ', $brief['status'])));
    $sheet->setCellValue('L' . $row, date('Y-m-d H:i:s', strtotime($brief['created_at'])));
    
    // Apply row styling
    $rowStyle = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => Border::BORDER_THIN,
                'color' => ['rgb' => 'CCCCCC']
            ]
        ]
    ];
    $sheet->getStyle('A' . $row . ':L' . $row)->applyFromArray($rowStyle);
    
    // Status color coding
    $statusColors = [
        'new' => 'FFF3CD',
        'contacted' => 'D1ECF1',
        'in_progress' => 'CCE5FF',
        'completed' => 'D4EDDA',
        'cancelled' => 'F8D7DA'
    ];
    
    $statusColor = $statusColors[$brief['status']] ?? 'FFFFFF';
    $sheet->getStyle('K' . $row)->getFill()
        ->setFillType(Fill::FILL_SOLID)
        ->getStartColor()->setRGB($statusColor);
    
    $row++;
}

// Freeze header row
$sheet->freezePane('A2');

// Set page orientation and paper size
$sheet->getPageSetup()
    ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE)
    ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);

// Output to browser
$filename = 'Digital_Services_Briefs_' . date('Y-m-d_His') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
