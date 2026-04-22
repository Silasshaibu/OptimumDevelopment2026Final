<?php
/**
 * Export Single Digital Services Brief to PDF
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

// Check if TCPDF is available
if (!file_exists('../../vendor/autoload.php')) {
    die('TCPDF not installed. Run: composer require tecnickcom/tcpdf');
}

require '../../vendor/autoload.php';

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

// Create PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

$pdf->SetCreator('Optimum Payments Admin');
$pdf->SetAuthor('Optimum Payments');
$pdf->SetTitle('Digital Services Brief #' . $brief['id']);
$pdf->SetSubject('Digital Services Brief');

$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

$pdf->SetHeaderData('', 0, 'Digital Services Brief #' . $brief['id'], 'Optimum Payments');

$pdf->setHeaderFont(['helvetica', '', 10]);
$pdf->setFooterFont(['helvetica', '', 8]);

$pdf->SetDefaultMonospacedFont('courier');
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(true, 15);

$pdf->AddPage();

// Services
$services = json_decode($brief['services'], true);
$servicesList = [];
if (is_array($services)) {
    foreach ($services as $service) {
        $servicesList[] = $serviceNames[$service] ?? $service;
    }
}
$servicesHtml = '<ul>';
foreach ($servicesList as $service) {
    $servicesHtml .= '<li>' . htmlspecialchars($service) . '</li>';
}
$servicesHtml .= '</ul>';

// Build HTML content
$html = '
<style>
    h1 { color: #4472C4; font-size: 18pt; margin-bottom: 10px; }
    h2 { color: #4472C4; font-size: 14pt; margin-top: 15px; margin-bottom: 8px; border-bottom: 2px solid #4472C4; padding-bottom: 3px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    td { padding: 8px; border: 1px solid #ddd; }
    .label { background-color: #E7E6E6; font-weight: bold; width: 35%; }
    .value { background-color: #FFFFFF; }
    .status { background-color: #D1ECF1; padding: 5px 10px; border-radius: 3px; display: inline-block; }
    .comments { background-color: #F8F9FA; padding: 10px; border-left: 4px solid #4472C4; margin: 10px 0; }
</style>

<h1>DIGITAL SERVICES BRIEF</h1>

<h2>Client Information</h2>
<table>
    <tr>
        <td class="label">Name</td>
        <td class="value">' . htmlspecialchars($brief['name']) . '</td>
    </tr>
    <tr>
        <td class="label">Email</td>
        <td class="value">' . htmlspecialchars($brief['email']) . '</td>
    </tr>
    <tr>
        <td class="label">Phone</td>
        <td class="value">' . ($brief['phone'] ? htmlspecialchars($brief['phone']) : 'Not provided') . '</td>
    </tr>
    <tr>
        <td class="label">Website</td>
        <td class="value">' . ($brief['website'] ? htmlspecialchars($brief['website']) : 'Not provided') . '</td>
    </tr>
</table>

<h2>Project Details</h2>
<table>
    <tr>
        <td class="label">Budget Range</td>
        <td class="value">$' . number_format($brief['budget_min']) . ' - $' . number_format($brief['budget_max']) . '</td>
    </tr>
    <tr>
        <td class="label">How They Heard About Us</td>
        <td class="value">' . htmlspecialchars(ucfirst($brief['referral_source'])) . '</td>
    </tr>
    <tr>
        <td class="label">Services Requested</td>
        <td class="value">' . $servicesHtml . '</td>
    </tr>
</table>
';

if (!empty($brief['comments'])) {
    $html .= '
    <h2>Additional Comments</h2>
    <div class="comments">' . nl2br(htmlspecialchars($brief['comments'])) . '</div>
    ';
}

$html .= '
<h2>Status & Timeline</h2>
<table>
    <tr>
        <td class="label">Current Status</td>
        <td class="value"><span class="status">' . htmlspecialchars(ucwords(str_replace('_', ' ', $brief['status']))) . '</span></td>
    </tr>
    <tr>
        <td class="label">Submitted Date</td>
        <td class="value">' . date('F j, Y \a\t g:i A', strtotime($brief['created_at'])) . '</td>
    </tr>
</table>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF
$filename = 'Digital_Brief_' . $brief['id'] . '_' . date('Y-m-d') . '.pdf';
$pdf->Output($filename, 'D');
exit;
?>
