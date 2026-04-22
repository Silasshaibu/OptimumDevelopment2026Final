<?php
/**
 * Export Single Merchant Application to Excel
 */

session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

// Get application ID
$appId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($appId === 0) {
    die('Invalid application ID');
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

// Get application details
$stmt = $conn->prepare("SELECT * FROM merchant_applications WHERE id = ?");
$stmt->bind_param("i", $appId);
$stmt->execute();
$result = $stmt->get_result();
$app = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$app) {
    die('Application not found');
}

// Create new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()
    ->setCreator("Optimum Payments Admin")
    ->setTitle("Merchant Application #" . $appId)
    ->setSubject("Merchant Application Details")
    ->setDescription("Details of merchant application #" . $appId);

// Title
$sheet->mergeCells('A1:B1');
$sheet->setCellValue('A1', 'Merchant Application #' . $appId . ' - ' . $app['company']);
$sheet->getStyle('A1')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 16,
        'color' => ['rgb' => '667EEA']
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER
    ]
]);
$sheet->getRowDimension(1)->setRowHeight(30);

// Add empty row
$row = 3;

// Contact Information Section
$sheet->mergeCells("A{$row}:B{$row}");
$sheet->setCellValue("A{$row}", 'CONTACT INFORMATION');
$sheet->getStyle("A{$row}")->applyFromArray([
    'font' => ['bold' => true, 'size' => 12],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'E9ECEF']
    ]
]);
$row++;

$contactFields = [
    'Company Name' => $app['company'],
    'First Name' => $app['first_name'],
    'Surname' => $app['surname'],
    'Title' => $app['title'] ?: 'Not provided',
    'Email' => $app['email'],
    'Phone' => $app['phone'],
    'Fax' => $app['fax'] ?: 'Not provided'
];

foreach ($contactFields as $label => $value) {
    $sheet->setCellValue("A{$row}", $label);
    $sheet->setCellValue("B{$row}", $value);
    $sheet->getStyle("A{$row}")->applyFromArray([
        'font' => ['bold' => true],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'F8F9FA']
        ]
    ]);
    $row++;
}

// Empty row
$row++;

// Address Section
$sheet->mergeCells("A{$row}:B{$row}");
$sheet->setCellValue("A{$row}", 'ADDRESS');
$sheet->getStyle("A{$row}")->applyFromArray([
    'font' => ['bold' => true, 'size' => 12],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'E9ECEF']
    ]
]);
$row++;

$addressFields = [
    'Address Line 1' => $app['address1'] ?: 'Not provided',
    'Address Line 2' => $app['address2'] ?: 'Not provided',
    'City' => $app['city'] ?: 'Not provided',
    'State' => $app['state'] ?: 'Not provided',
    'Zip Code' => $app['zip'] ?: 'Not provided'
];

foreach ($addressFields as $label => $value) {
    $sheet->setCellValue("A{$row}", $label);
    $sheet->setCellValue("B{$row}", $value);
    $sheet->getStyle("A{$row}")->applyFromArray([
        'font' => ['bold' => true],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'F8F9FA']
        ]
    ]);
    $row++;
}

// Empty row
$row++;

// Business Information Section
$sheet->mergeCells("A{$row}:B{$row}");
$sheet->setCellValue("A{$row}", 'BUSINESS INFORMATION');
$sheet->getStyle("A{$row}")->applyFromArray([
    'font' => ['bold' => true, 'size' => 12],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'E9ECEF']
    ]
]);
$row++;

$businessFields = [
    'Business Type' => $app['business_type'] ?: 'Not provided',
    'Accept Credit Cards' => strtoupper($app['accept_credit_cards'] ?: 'N/A'),
    'Previous Credit Cards' => strtoupper($app['previous_credit_cards'] ?: 'N/A'),
    'Monthly Volume ($$$)' => '$' . $app['monthly_volume']
];

foreach ($businessFields as $label => $value) {
    $sheet->setCellValue("A{$row}", $label);
    $sheet->setCellValue("B{$row}", $value);
    $sheet->getStyle("A{$row}")->applyFromArray([
        'font' => ['bold' => true],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'F8F9FA']
        ]
    ]);
    $row++;
}

// Empty row
$row++;

// Comments Section
if (!empty($app['comments'])) {
    $sheet->mergeCells("A{$row}:B{$row}");
    $sheet->setCellValue("A{$row}", 'ADDITIONAL COMMENTS');
    $sheet->getStyle("A{$row}")->applyFromArray([
        'font' => ['bold' => true, 'size' => 12],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'E9ECEF']
        ]
    ]);
    $row++;

    $sheet->mergeCells("A{$row}:B{$row}");
    $sheet->setCellValue("A{$row}", $app['comments']);
    $sheet->getStyle("A{$row}")->getAlignment()->setWrapText(true);
    $sheet->getStyle("A{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
    $sheet->getRowDimension($row)->setRowHeight(60);
    $row++;
    $row++;
}

// Application Status Section
$sheet->mergeCells("A{$row}:B{$row}");
$sheet->setCellValue("A{$row}", 'APPLICATION STATUS');
$sheet->getStyle("A{$row}")->applyFromArray([
    'font' => ['bold' => true, 'size' => 12],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'E9ECEF']
    ]
]);
$row++;

$statusFields = [
    'Status' => ucfirst(str_replace('_', ' ', $app['status'])),
    'Confirmed' => $app['confirmed'] ? 'Yes' : 'No',
    'Submission Date' => date('F j, Y g:i A', strtotime($app['created_at']))
];

foreach ($statusFields as $label => $value) {
    $sheet->setCellValue("A{$row}", $label);
    $sheet->setCellValue("B{$row}", $value);
    $sheet->getStyle("A{$row}")->applyFromArray([
        'font' => ['bold' => true],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'F8F9FA']
        ]
    ]);
    $row++;
}

// Add borders to all data
$sheet->getStyle('A3:B' . ($row - 1))->applyFromArray([
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => 'CCCCCC']
        ]
    ]
]);

// Set column widths
$sheet->getColumnDimension('A')->setWidth(30);
$sheet->getColumnDimension('B')->setWidth(50);

// Set filename
$filename = 'merchant_application_' . $appId . '_' . date('Y-m-d_His') . '.xlsx';

// Output headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Write file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
