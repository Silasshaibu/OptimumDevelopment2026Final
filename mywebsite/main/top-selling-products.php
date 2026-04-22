<?php
require_once __DIR__ . '/../_system/product_helpers.php';

$page_title = 'Top Selling Products';
$products = getProductsByCategory($pdo, 'top_selling');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> - Optimum Payments</title>
    <link rel="stylesheet" href="../assets/css/style-guide.css">
    <link rel="stylesheet" href="../assets/css/products.css">
</head>
<body>
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    
    <section class="products-section">
        <div class="products-container">
            <div class="products-header">
                <h1>Top Selling Products</h1>
                <p>Our most popular payment processing solutions</p>
            </div>
            
            <?php if (empty($products)): ?>
                <div class="empty-products">
                    <h3>No Products Available</h3>
                    <p>Check back soon for new products!</p>
                </div>
            <?php else: ?>
                <div class="products-grid">
                    <?php foreach ($products as $product): ?>
                        <?php echo displayProductCard($product); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html>
