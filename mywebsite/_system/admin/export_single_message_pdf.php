<?php
/**
 * Export Single Contact Message to PDF
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

// Check if TCPDF is available
if (!file_exists('../../vendor/autoload.php')) {
    die('TCPDF not installed. Run: composer require tecnickcom/tcpdf');
}

require '../../vendor/autoload.php';

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

// Create TCPDF instance
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Optimum Payments Admin');
$pdf->SetAuthor('Optimum Payments');
$pdf->SetTitle('Contact Message #' . $messageId);
$pdf->SetSubject('Contact Message Details');

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set margins
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(TRUE, 15);

// Add a page
$pdf->AddPage();

// Title
$pdf->SetFont('helvetica', 'B', 18);
$pdf->SetTextColor(102, 126, 234);
$pdf->Cell(0, 12, 'Contact Message #' . $messageId, 0, 1, 'C');
$pdf->Ln(5);

// Status badge and date
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(100, 100, 100);
$statusText = 'Status: ' . ucfirst($msg['status']);
$dateText = 'Submitted: ' . date('F j, Y g:i A', strtotime($msg['created_at']));
$pdf->Cell(95, 6, $statusText, 0, 0, 'L');
$pdf->Cell(95, 6, $dateText, 0, 1, 'R');
$pdf->Ln(5);

// Reset text color
$pdf->SetTextColor(0, 0, 0);

// Contact Information Section
$pdf->SetFillColor(102, 126, 234);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 8, 'Contact Information', 0, 1, 'L', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);

$contactHtml = '
<table cellpadding="5" style="border: 1px solid #ddd;">
    <tr>
        <td width="35%" style="background-color: #f8f9fa; font-weight: bold;">First Name:</td>
        <td width="65%">' . htmlspecialchars($msg['first_name']) . '</td>
    </tr>
    <tr>
        <td style="background-color: #f8f9fa; font-weight: bold;">Last Name:</td>
        <td>' . htmlspecialchars($msg['last_name']) . '</td>
    </tr>
    <tr>
        <td style="background-color: #f8f9fa; font-weight: bold;">Email:</td>
        <td>' . htmlspecialchars($msg['email']) . '</td>
    </tr>
    <tr>
        <td style="background-color: #f8f9fa; font-weight: bold;">Phone:</td>
        <td>' . htmlspecialchars($msg['phone'] ?: 'Not provided') . '</td>
    </tr>
    <tr>
        <td style="background-color: #f8f9fa; font-weight: bold;">Company:</td>
        <td>' . htmlspecialchars($msg['company'] ?: 'Not provided') . '</td>
    </tr>
    <tr>
        <td style="background-color: #f8f9fa; font-weight: bold;">How They Heard About Us:</td>
        <td>' . htmlspecialchars(ucfirst($msg['source'])) . '</td>
    </tr>
</table>
';
$pdf->writeHTML($contactHtml, true, false, true, false, '');
$pdf->Ln(5);

// Message Section
$pdf->SetFillColor(102, 126, 234);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 8, 'Message', 0, 1, 'L', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);

$messageHtml = '
<table cellpadding="8" style="border: 1px solid #ddd; background-color: #f8f9fa;">
    <tr>
        <td>' . nl2br(htmlspecialchars($msg['message'])) . '</td>
    </tr>
</table>
';
$pdf->writeHTML($messageHtml, true, false, true, false, '');
$pdf->Ln(5);

// Additional Details Section
$pdf->SetFillColor(102, 126, 234);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 8, 'Additional Details', 0, 1, 'L', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);

$detailsHtml = '
<table cellpadding="5" style="border: 1px solid #ddd;">
    <tr>
        <td width="35%" style="background-color: #f8f9fa; font-weight: bold;">Status:</td>
        <td width="65%">' . htmlspecialchars(ucfirst($msg['status'])) . '</td>
    </tr>
    <tr>
        <td style="background-color: #f8f9fa; font-weight: bold;">Submission Date:</td>
        <td>' . date('F j, Y g:i A', strtotime($msg['created_at'])) . '</td>
    </tr>
    <tr>
        <td style="background-color: #f8f9fa; font-weight: bold;">IP Address:</td>
        <td>' . htmlspecialchars($msg['ip_address']) . '</td>
    </tr>
</table>
';
$pdf->writeHTML($detailsHtml, true, false, true, false, '');

// Set filename
$filename = 'contact_message_' . $messageId . '_' . date('Y-m-d_His') . '.pdf';

// Output PDF
$pdf->Output($filename, 'D'); // 'D' forces download
exit;
?>
