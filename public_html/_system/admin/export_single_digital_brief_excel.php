<?php
/**
 * Export Single Digital Services Brief to Excel
 */

session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

$briefId = (int) ($_GET['id'] ?? 0);

if (!$briefId) {
    header("Location: digital_briefs.php");
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

// Fetch brief data
$stmt = $conn->prepare("SELECT * FROM digital_briefs WHERE id = ?");
$stmt->bind_param("i", $briefId);
$stmt->execute();
$result = $stmt->get_result();
$brief = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$brief) {
    die('Brief not found');
}

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
    ->setTitle("Digital Services Brief #" . $brief['id'])
    ->setSubject("Digital Services Brief")
    ->setDescription("Digital services brief submission details");

$sheet->setTitle('Brief #' . $brief['id']);

// Header style
$headerStyle = [
    'font' => ['bold' => true, 'size' => 12, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4472C4']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
];

$labelStyle = [
    'font' => ['bold' => true, 'size' => 11],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E7E6E6']]
];

// Title
$sheet->mergeCells('A1:B1');
$sheet->setCellValue('A1', 'DIGITAL SERVICES BRIEF #' . $brief['id']);
$sheet->getStyle('A1')->applyFromArray($headerStyle);
$sheet->getRowDimension(1)->setRowHeight(25);

$row = 3;

// Client Information
$sheet->mergeCells("A{$row}:B{$row}");
$sheet->setCellValue("A{$row}", 'CLIENT INFORMATION');
$sheet->getStyle("A{$row}")->applyFromArray($headerStyle);
$row++;

$clientFields = [
    'Name' => $brief['name'],
    'Email' => $brief['email'],
    'Phone' => $brief['phone'] ?: 'Not provided',
    'Website' => $brief['website'] ?: 'Not provided'
];

foreach ($clientFields as $label => $value) {
    $sheet->setCellValue("A{$row}", $label);
    $sheet->setCellValue("B{$row}", $value);
    $sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
    $row++;
}

$row++;

// Project Details
$sheet->mergeCells("A{$row}:B{$row}");
$sheet->setCellValue("A{$row}", 'PROJECT DETAILS');
$sheet->getStyle("A{$row}")->applyFromArray($headerStyle);
$row++;

$sheet->setCellValue("A{$row}", 'Budget Range');
$sheet->setCellValue("B{$row}", '$' . number_format($brief['budget_min']) . ' - $' . number_format($brief['budget_max']));
$sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
$row++;

$sheet->setCellValue("A{$row}", 'Referral Source');
$sheet->setCellValue("B{$row}", ucfirst($brief['referral_source']));
$sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
$row++;

// Services
$services = json_decode($brief['services'], true);
$servicesList = [];
if (is_array($services)) {
    foreach ($services as $service) {
        $servicesList[] = $serviceNames[$service] ?? $service;
    }
}

$sheet->setCellValue("A{$row}", 'Services Requested');
$sheet->setCellValue("B{$row}", implode(', ', $servicesList));
$sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
$sheet->getStyle("B{$row}")->getAlignment()->setWrapText(true);
$row++;

$row++;

// Comments
if (!empty($brief['comments'])) {
    $sheet->mergeCells("A{$row}:B{$row}");
    $sheet->setCellValue("A{$row}", 'ADDITIONAL COMMENTS');
    $sheet->getStyle("A{$row}")->applyFromArray($headerStyle);
    $row++;
    
    $sheet->mergeCells("A{$row}:B{$row}");
    $sheet->setCellValue("A{$row}", $brief['comments']);
    $sheet->getStyle("A{$row}")->getAlignment()->setWrapText(true);
    $sheet->getRowDimension($row)->setRowHeight(-1);
    $row++;
    $row++;
}

// Status
$sheet->mergeCells("A{$row}:B{$row}");
$sheet->setCellValue("A{$row}", 'STATUS & METADATA');
$sheet->getStyle("A{$row}")->applyFromArray($headerStyle);
$row++;

$sheet->setCellValue("A{$row}", 'Status');
$sheet->setCellValue("B{$row}", ucwords(str_replace('_', ' ', $brief['status'])));
$sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
$row++;

$sheet->setCellValue("A{$row}", 'Submitted Date');
$sheet->setCellValue("B{$row}", date('F j, Y \a\t g:i A', strtotime($brief['created_at'])));
$sheet->getStyle("A{$row}")->applyFromArray($labelStyle);
$row++;

// Auto-size columns
$sheet->getColumnDimension('A')->setWidth(25);
$sheet->getColumnDimension('B')->setWidth(60);

// Output to browser
$filename = 'Digital_Brief_' . $brief['id'] . '_' . date('Y-m-d') . '.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
