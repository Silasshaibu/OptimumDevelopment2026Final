<?php
/**
 * Export Merchant Applications to PDF
 * 
 * Requires TCPDF library
 * Install: composer require tecnickcom/tcpdf
 */

session_start();
require_once __DIR__ . '/../../db.php';

// Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /");
    exit;
}

// Check if TCPDF is available
if (!file_exists('../../vendor/autoload.php')) {
    die('TCPDF not installed. Run: composer require tecnickcom/tcpdf');
}

require '../../vendor/autoload.php';

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

// Create TCPDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Optimum Payments Admin');
$pdf->SetAuthor('Optimum Payments');
$pdf->SetTitle('Merchant Applications Export');
$pdf->SetSubject('Merchant Applications Report');

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set margins
$pdf->SetMargins(10, 10, 10);
$pdf->SetAutoPageBreak(TRUE, 10);

// Set font
$pdf->SetFont('helvetica', '', 9);

// Add a page
$pdf->AddPage('L'); // Landscape orientation

// Title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->SetTextColor(102, 126, 234);
$pdf->Cell(0, 10, 'Merchant Applications Report', 0, 1, 'C');
$pdf->Ln(2);

// Export info
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(100, 100, 100);
$exportInfo = 'Generated: ' . date('F j, Y g:i A');
if ($statusFilter !== 'all') {
    $exportInfo .= ' | Status: ' . ucfirst(str_replace('_', ' ', $statusFilter));
}
if ($confirmedFilter !== 'all') {
    $exportInfo .= ' | Confirmed: ' . ucfirst($confirmedFilter);
}
if (!empty($searchQuery)) {
    $exportInfo .= ' | Search: "' . htmlspecialchars($searchQuery) . '"';
}
$pdf->Cell(0, 8, $exportInfo, 0, 1, 'C');
$pdf->Ln(3);

// Reset text color
$pdf->SetTextColor(0, 0, 0);

// Check if there are applications
if (empty($applications)) {
    $pdf->SetFont('helvetica', 'I', 12);
    $pdf->Cell(0, 10, 'No applications found matching the criteria.', 0, 1, 'C');
} else {
    // Loop through applications
    foreach ($applications as $index => $app) {
        // Add page break after each application except the first
        if ($index > 0) {
            $pdf->AddPage('L');
        }
        
        // Application header
        $pdf->SetFillColor(102, 126, 234);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 8, 'Application #' . $app['id'] . ' - ' . $app['company'], 0, 1, 'L', true);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);
        
        // Status and confirmation badges
        $pdf->SetFont('helvetica', '', 9);
        $statusText = 'Status: ' . ucfirst(str_replace('_', ' ', $app['status']));
        $confirmedText = $app['confirmed'] ? 'Confirmed' : 'Unconfirmed';
        $dateText = 'Submitted: ' . date('M j, Y g:i A', strtotime($app['created_at']));
        
        $pdf->Cell(70, 6, $statusText, 0, 0, 'L');
        $pdf->Cell(70, 6, $confirmedText, 0, 0, 'L');
        $pdf->Cell(0, 6, $dateText, 0, 1, 'L');
        $pdf->Ln(3);
        
        // Contact Information Section
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 7, 'Contact Information', 0, 1, 'L', true);
        $pdf->SetFont('helvetica', '', 9);
        
        $contactHtml = '
        <table cellpadding="3" style="border: 1px solid #ddd;">
            <tr>
                <td width="25%" style="background-color: #f8f9fa; font-weight: bold;">Name:</td>
                <td width="75%">' . htmlspecialchars($app['first_name'] . ' ' . $app['surname']) . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">Title:</td>
                <td>' . htmlspecialchars($app['title'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">Email:</td>
                <td>' . htmlspecialchars($app['email']) . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">Phone:</td>
                <td>' . htmlspecialchars($app['phone']) . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">Fax:</td>
                <td>' . htmlspecialchars($app['fax'] ?? 'N/A') . '</td>
            </tr>
        </table>
        ';
        $pdf->writeHTML($contactHtml, true, false, true, false, '');
        $pdf->Ln(3);
        
        // Address Section
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 7, 'Address', 0, 1, 'L', true);
        $pdf->SetFont('helvetica', '', 9);
        
        $addressHtml = '
        <table cellpadding="3" style="border: 1px solid #ddd;">
            <tr>
                <td width="25%" style="background-color: #f8f9fa; font-weight: bold;">Address Line 1:</td>
                <td width="75%">' . htmlspecialchars($app['address1'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">Address Line 2:</td>
                <td>' . htmlspecialchars($app['address2'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">City:</td>
                <td>' . htmlspecialchars($app['city'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">State:</td>
                <td>' . htmlspecialchars($app['state'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">Zip Code:</td>
                <td>' . htmlspecialchars($app['zip'] ?? 'N/A') . '</td>
            </tr>
        </table>
        ';
        $pdf->writeHTML($addressHtml, true, false, true, false, '');
        $pdf->Ln(3);
        
        // Business Information Section
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 7, 'Business Information', 0, 1, 'L', true);
        $pdf->SetFont('helvetica', '', 9);
        
        $businessHtml = '
        <table cellpadding="3" style="border: 1px solid #ddd;">
            <tr>
                <td width="25%" style="background-color: #f8f9fa; font-weight: bold;">Business Type:</td>
                <td width="75%">' . htmlspecialchars($app['business_type'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">Accept Credit Cards:</td>
                <td>' . strtoupper($app['accept_credit_cards'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">Previous Cards:</td>
                <td>' . strtoupper($app['previous_credit_cards'] ?? 'N/A') . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">Monthly Volume:</td>
                <td>$' . htmlspecialchars($app['monthly_volume']) . '</td>
            </tr>
        </table>
        ';
        $pdf->writeHTML($businessHtml, true, false, true, false, '');
        $pdf->Ln(3);
        
        // Comments Section (if available)
        if (!empty($app['comments'])) {
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(0, 7, 'Additional Comments', 0, 1, 'L', true);
            $pdf->SetFont('helvetica', '', 9);
            
            $commentsHtml = '
            <table cellpadding="3" style="border: 1px solid #ddd;">
                <tr>
                    <td>' . nl2br(htmlspecialchars($app['comments'])) . '</td>
                </tr>
            </table>
            ';
            $pdf->writeHTML($commentsHtml, true, false, true, false, '');
        }
    }
}

// Set filename
$filename = 'merchant_applications_' . date('Y-m-d_His') . '.pdf';

// Output PDF
$pdf->Output($filename, 'D'); // 'D' forces download
exit;
?>
