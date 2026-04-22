<?php
require_once __DIR__ . "/../../config.php";

$q = $_GET['q'] ?? '';
$type = $_GET['type'] ?? 'all';

if (!$q) {
    echo "No search term.";
    exit;
}

$sql = "
SELECT *,
MATCH(title, summary, body) AGAINST (? IN NATURAL LANGUAGE MODE) AS relevance
FROM search_index
WHERE is_active = 1
";

$params = [$q];
$types = "s";

if ($type !== 'all') {
    $sql .= " AND content_type = ?";
    $params[] = $type;
    $types .= "s";
}

$sql .= "
AND MATCH(title, summary, body) AGAINST (? IN NATURAL LANGUAGE MODE)
ORDER BY priority DESC, relevance DESC
LIMIT 10
";

$params[] = $q;
$types .= "s";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

$result = $stmt->get_result();

$results = [];

while ($row = $result->fetch_assoc()) {
    $results[] = $row;
}

header('Content-Type: application/json');
echo json_encode($results);
