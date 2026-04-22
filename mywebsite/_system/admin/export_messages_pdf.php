<?php
/**
 * Export Contact Messages to PDF
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

// Create TCPDF instance
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator('Optimum Payments Admin');
$pdf->SetAuthor('Optimum Payments');
$pdf->SetTitle('Contact Messages Export');
$pdf->SetSubject('Contact Messages Report');

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
$pdf->Cell(0, 10, 'Contact Messages Report', 0, 1, 'C');
$pdf->Ln(2);

// Export info
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(100, 100, 100);
$exportInfo = 'Generated: ' . date('F j, Y g:i A');
if ($statusFilter !== 'all') {
    $exportInfo .= ' | Status: ' . ucfirst($statusFilter);
}
if (!empty($searchQuery)) {
    $exportInfo .= ' | Search: "' . htmlspecialchars($searchQuery) . '"';
}
$pdf->Cell(0, 8, $exportInfo, 0, 1, 'C');
$pdf->Ln(3);

// Reset text color
$pdf->SetTextColor(0, 0, 0);

// Check if there are messages
if (empty($messages)) {
    $pdf->SetFont('helvetica', 'I', 12);
    $pdf->Cell(0, 10, 'No messages found matching the criteria.', 0, 1, 'C');
} else {
    // Loop through messages
    foreach ($messages as $index => $msg) {
        // Add page break after each message except the first
        if ($index > 0) {
            $pdf->AddPage('L');
        }
        
        // Message header
        $pdf->SetFillColor(102, 126, 234);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('helvetica', 'B', 12);
        $pdf->Cell(0, 8, 'Message #' . $msg['id'] . ' - ' . $msg['first_name'] . ' ' . $msg['last_name'], 0, 1, 'L', true);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Ln(2);
        
        // Status and date
        $pdf->SetFont('helvetica', '', 9);
        $statusText = 'Status: ' . ucfirst($msg['status']);
        $dateText = 'Submitted: ' . date('M j, Y g:i A', strtotime($msg['created_at']));
        
        $pdf->Cell(100, 6, $statusText, 0, 0, 'L');
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
                <td width="75%">' . htmlspecialchars($msg['first_name'] . ' ' . $msg['last_name']) . '</td>
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
                <td style="background-color: #f8f9fa; font-weight: bold;">Source:</td>
                <td>' . htmlspecialchars(ucfirst($msg['source'])) . '</td>
            </tr>
            <tr>
                <td style="background-color: #f8f9fa; font-weight: bold;">IP Address:</td>
                <td>' . htmlspecialchars($msg['ip_address']) . '</td>
            </tr>
        </table>
        ';
        $pdf->writeHTML($contactHtml, true, false, true, false, '');
        $pdf->Ln(3);
        
        // Message Section
        $pdf->SetFillColor(240, 240, 240);
        $pdf->SetFont('helvetica', 'B', 10);
        $pdf->Cell(0, 7, 'Message', 0, 1, 'L', true);
        $pdf->SetFont('helvetica', '', 9);
        
        $messageHtml = '
        <table cellpadding="5" style="border: 1px solid #ddd;">
            <tr>
                <td>' . nl2br(htmlspecialchars($msg['message'])) . '</td>
            </tr>
        </table>
        ';
        $pdf->writeHTML($messageHtml, true, false, true, false, '');
    }
}

// Set filename
$filename = 'contact_messages_' . date('Y-m-d_His') . '.pdf';

// Output PDF
$pdf->Output($filename, 'D'); // 'D' forces download
exit;
?>
