<?php
/**
 * Export Single Merchant Application to PDF
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

// Check if TCPDF is available
if (!file_exists('../../vendor/autoload.php')) {
    die('TCPDF not installed. Run: composer require tecnickcom/tcpdf');
}

require '../../vendor/autoload.php';

use TCPDF;

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

// Create new PDF document
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Optimum Payments Admin');
$pdf->SetAuthor('Optimum Payments');
$pdf->SetTitle('Merchant Application #' . $appId);
$pdf->SetSubject('Merchant Application Details');

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set margins
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(true, 15);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

// Title
$pdf->SetFont('helvetica', 'B', 18);
$pdf->SetTextColor(102, 126, 234);
$pdf->Cell(0, 10, 'Merchant Application #' . $appId, 0, 1, 'C');
$pdf->SetFont('helvetica', 'B', 14);
$pdf->Cell(0, 8, $app['company'], 0, 1, 'C');
$pdf->Ln(5);

// Status and Date
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(0, 0, 0);
$statusText = 'Status: ' . ucfirst(str_replace('_', ' ', $app['status']));
$confirmedText = 'Confirmed: ' . ($app['confirmed'] ? 'Yes' : 'No');
$dateText = 'Date: ' . date('F j, Y g:i A', strtotime($app['created_at']));

$pdf->Cell(60, 6, $statusText, 0, 0, 'L');
$pdf->Cell(60, 6, $confirmedText, 0, 0, 'L');
$pdf->Cell(0, 6, $dateText, 0, 1, 'R');
$pdf->Ln(5);

// Contact Information Section
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(102, 126, 234);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(0, 8, 'CONTACT INFORMATION', 0, 1, 'L', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);

$contactHtml = '
<table cellpadding="5" border="1" style="border-collapse: collapse;">
    <tr>
        <td width="35%" style="background-color: #F8F9FA;"><b>Company Name</b></td>
        <td width="65%">' . htmlspecialchars($app['company']) . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>First Name</b></td>
        <td>' . htmlspecialchars($app['first_name']) . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>Surname</b></td>
        <td>' . htmlspecialchars($app['surname']) . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>Title</b></td>
        <td>' . htmlspecialchars($app['title'] ?: 'Not provided') . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>Email</b></td>
        <td>' . htmlspecialchars($app['email']) . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>Phone</b></td>
        <td>' . htmlspecialchars($app['phone']) . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>Fax</b></td>
        <td>' . htmlspecialchars($app['fax'] ?: 'Not provided') . '</td>
    </tr>
</table>';

$pdf->writeHTML($contactHtml, true, false, true, false, '');
$pdf->Ln(5);

// Address Section
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(102, 126, 234);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(0, 8, 'ADDRESS', 0, 1, 'L', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);

$addressHtml = '
<table cellpadding="5" border="1" style="border-collapse: collapse;">
    <tr>
        <td width="35%" style="background-color: #F8F9FA;"><b>Address Line 1</b></td>
        <td width="65%">' . htmlspecialchars($app['address1'] ?: 'Not provided') . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>Address Line 2</b></td>
        <td>' . htmlspecialchars($app['address2'] ?: 'Not provided') . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>City</b></td>
        <td>' . htmlspecialchars($app['city'] ?: 'Not provided') . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>State</b></td>
        <td>' . htmlspecialchars($app['state'] ?: 'Not provided') . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>Zip Code</b></td>
        <td>' . htmlspecialchars($app['zip'] ?: 'Not provided') . '</td>
    </tr>
</table>';

$pdf->writeHTML($addressHtml, true, false, true, false, '');
$pdf->Ln(5);

// Business Information Section
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(102, 126, 234);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(0, 8, 'BUSINESS INFORMATION', 0, 1, 'L', true);
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 10);

$businessHtml = '
<table cellpadding="5" border="1" style="border-collapse: collapse;">
    <tr>
        <td width="35%" style="background-color: #F8F9FA;"><b>Business Type</b></td>
        <td width="65%">' . htmlspecialchars($app['business_type'] ?: 'Not provided') . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>Accept Credit Cards</b></td>
        <td>' . strtoupper(htmlspecialchars($app['accept_credit_cards'] ?: 'N/A')) . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>Previous Credit Cards</b></td>
        <td>' . strtoupper(htmlspecialchars($app['previous_credit_cards'] ?: 'N/A')) . '</td>
    </tr>
    <tr>
        <td style="background-color: #F8F9FA;"><b>Monthly Volume ($$$)</b></td>
        <td>$' . htmlspecialchars($app['monthly_volume']) . '</td>
    </tr>
</table>';

$pdf->writeHTML($businessHtml, true, false, true, false, '');

// Comments Section (if provided)
if (!empty($app['comments'])) {
    $pdf->Ln(5);
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->SetFillColor(102, 126, 234);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(0, 8, 'ADDITIONAL COMMENTS', 0, 1, 'L', true);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('helvetica', '', 10);
    
    $commentsHtml = '
    <table cellpadding="5" border="1" style="border-collapse: collapse;">
        <tr>
            <td>' . nl2br(htmlspecialchars($app['comments'])) . '</td>
        </tr>
    </table>';
    
    $pdf->writeHTML($commentsHtml, true, false, true, false, '');
}

// Set filename
$filename = 'merchant_application_' . $appId . '_' . date('Y-m-d_His') . '.pdf';

// Output PDF
$pdf->Output($filename, 'D');
exit;
?>
