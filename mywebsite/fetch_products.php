<?php
include 'db.php';

// Get search and sort parameters
$search = isset($_GET['search']) ? $_GET['search'] : '';
$sort   = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';
$status_filter = isset($_GET['status_filter']) ? $_GET['status_filter'] : 'all';

// Base SQL - Only show shop category products
$sql = "SELECT * FROM products WHERE is_active = 1 AND category = 'shop'";

// Apply search
if ($search != '') {
    $search_safe = $conn->real_escape_string($search);
    $sql .= " AND product_name LIKE '%$search_safe%'";
}

// Apply status filter
if ($status_filter != 'all') {
    $status_safe = $conn->real_escape_string($status_filter);
    $sql .= " AND status = '$status_safe'";
}

// Apply sort as before
switch ($sort) {
    case 'name_desc': $sql .= " ORDER BY product_name DESC"; break;
    case 'newest': $sql .= " ORDER BY created_at DESC"; break;
    case 'oldest': $sql .= " ORDER BY created_at ASC"; break;
    default: $sql .= " ORDER BY product_name ASC";
}

$result = $conn->query($sql);

// Generate HTML for products dynamically
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="single-product-container">
            <span class="badge-Available"><?= htmlspecialchars($row['status']) ?></span>
            <img class="single-product-image" src="<?= htmlspecialchars($row['image_path']) ?>" alt="<?= htmlspecialchars($row['product_name']) ?>">
            <div class="single-product-data">
                <p class="single-product-title"><?= htmlspecialchars($row['product_name']) ?></p>
                <button class="cta-shop buy-now" onclick="window.open('<?= $row['affiliate_link'] ?>', '_blank')">
                    Buy Now
                </button>
            </div>
        </div>
        <?php
    }
} else {
    echo "<p>No products found.</p>";
}
