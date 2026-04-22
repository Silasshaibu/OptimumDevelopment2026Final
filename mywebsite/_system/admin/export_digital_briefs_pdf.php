<?php
/**
 * Export Digital Services Briefs to PDF
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

// Create PDF
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetCreator('Optimum Payments Admin');
$pdf->SetAuthor('Optimum Payments');
$pdf->SetTitle('Digital Services Briefs Export');
$pdf->SetSubject('Digital Services Briefs');

$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

$pdf->SetHeaderData('', 0, 'Digital Services Briefs', 'Generated on ' . date('F j, Y g:i A'));

$pdf->setHeaderFont(['helvetica', '', 10]);
$pdf->setFooterFont(['helvetica', '', 8]);

$pdf->SetDefaultMonospacedFont('courier');
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(true, 15);

$pdf->AddPage();

// Title
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'Digital Services Briefs Export', 0, 1, 'C');
$pdf->Ln(5);

// Summary info
$pdf->SetFont('helvetica', '', 10);
$filterText = 'Status: ' . ($statusFilter !== 'all' ? ucwords(str_replace('_', ' ', $statusFilter)) : 'All');
if (!empty($searchQuery)) {
    $filterText .= ' | Search: "' . htmlspecialchars($searchQuery) . '"';
}
$pdf->Cell(0, 6, $filterText, 0, 1, 'L');
$pdf->Cell(0, 6, 'Total Records: ' . count($briefs), 0, 1, 'L');
$pdf->Ln(5);

// Table headers
$pdf->SetFont('helvetica', 'B', 9);
$pdf->SetFillColor(68, 114, 196);
$pdf->SetTextColor(255, 255, 255);

$pdf->Cell(15, 8, 'ID', 1, 0, 'C', true);
$pdf->Cell(35, 8, 'Name', 1, 0, 'C', true);
$pdf->Cell(45, 8, 'Email', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Phone', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Budget Range', 1, 0, 'C', true);
$pdf->Cell(45, 8, 'Services', 1, 0, 'C', true);
$pdf->Cell(25, 8, 'Status', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Submitted', 1, 1, 'C', true);

// Reset text color
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('helvetica', '', 8);

// Table data
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
    if (strlen($servicesText) > 40) {
        $servicesText = substr($servicesText, 0, 37) . '...';
    }
    
    // Status color coding
    $statusColors = [
        'new' => [255, 243, 205],
        'contacted' => [209, 236, 241],
        'in_progress' => [204, 229, 255],
        'completed' => [212, 237, 218],
        'cancelled' => [248, 215, 218]
    ];
    
    $statusColor = $statusColors[$brief['status']] ?? [255, 255, 255];
    
    $pdf->Cell(15, 8, $brief['id'], 1, 0, 'C');
    $pdf->Cell(35, 8, substr($brief['name'], 0, 20), 1, 0, 'L');
    $pdf->Cell(45, 8, substr($brief['email'], 0, 28), 1, 0, 'L');
    $pdf->Cell(30, 8, $brief['phone'] ?: '—', 1, 0, 'L');
    $pdf->Cell(40, 8, '$' . number_format($brief['budget_min']) . ' - $' . number_format($brief['budget_max']), 1, 0, 'C');
    $pdf->Cell(45, 8, $servicesText, 1, 0, 'L');
    $pdf->SetFillColor($statusColor[0], $statusColor[1], $statusColor[2]);
    $pdf->Cell(25, 8, ucwords(str_replace('_', ' ', $brief['status'])), 1, 0, 'C', true);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(30, 8, date('M j, Y', strtotime($brief['created_at'])), 1, 1, 'C');
}

// Output PDF
$filename = 'Digital_Services_Briefs_' . date('Y-m-d_His') . '.pdf';
$pdf->Output($filename, 'D');
exit;
?>
