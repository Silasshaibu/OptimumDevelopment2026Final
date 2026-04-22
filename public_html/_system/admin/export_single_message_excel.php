<?php
/**
 * Export Single Contact Message to Excel
 */

session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

// Get message ID
$messageId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($messageId === 0) {
    die('Invalid message ID');
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

// Get message details
$stmt = $conn->prepare("SELECT * FROM contact_messages WHERE id = ?");
$stmt->bind_param("i", $messageId);
$stmt->execute();
$result = $stmt->get_result();
$msg = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$msg) {
    die('Message not found');
}

// Create new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Set document properties
$spreadsheet->getProperties()
    ->setCreator("Optimum Payments Admin")
    ->setTitle("Contact Message #" . $messageId)
    ->setSubject("Contact Message Details")
    ->setDescription("Details of contact message #" . $messageId);

// Title
$sheet->mergeCells('A1:B1');
$sheet->setCellValue('A1', 'Contact Message #' . $messageId);
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

// Contact fields
$contactFields = [
    'First Name' => $msg['first_name'],
    'Last Name' => $msg['last_name'],
    'Email' => $msg['email'],
    'Phone' => $msg['phone'] ?: 'Not provided',
    'Company' => $msg['company'] ?: 'Not provided',
    'How They Heard About Us' => ucfirst($msg['source'])
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

// Message Section
$sheet->mergeCells("A{$row}:B{$row}");
$sheet->setCellValue("A{$row}", 'MESSAGE');
$sheet->getStyle("A{$row}")->applyFromArray([
    'font' => ['bold' => true, 'size' => 12],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'E9ECEF']
    ]
]);
$row++;

$sheet->mergeCells("A{$row}:B{$row}");
$sheet->setCellValue("A{$row}", $msg['message']);
$sheet->getStyle("A{$row}")->getAlignment()->setWrapText(true);
$sheet->getStyle("A{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
$sheet->getRowDimension($row)->setRowHeight(80);
$row++;

// Empty row
$row++;

// Additional Details Section
$sheet->mergeCells("A{$row}:B{$row}");
$sheet->setCellValue("A{$row}", 'ADDITIONAL DETAILS');
$sheet->getStyle("A{$row}")->applyFromArray([
    'font' => ['bold' => true, 'size' => 12],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'E9ECEF']
    ]
]);
$row++;

// Additional fields
$additionalFields = [
    'Status' => ucfirst($msg['status']),
    'Submission Date' => date('F j, Y g:i A', strtotime($msg['created_at'])),
    'IP Address' => $msg['ip_address']
];

foreach ($additionalFields as $label => $value) {
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
$sheet->getColumnDimension('A')->setWidth(25);
$sheet->getColumnDimension('B')->setWidth(50);

// Set filename
$filename = 'contact_message_' . $messageId . '_' . date('Y-m-d_His') . '.xlsx';

// Output headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Write file to output
$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
