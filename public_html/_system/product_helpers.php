<?php
require_once __DIR__ . '/db_pdo.php';

// Fetch products by category
function getProductsByCategory($pdo, $category, $limit = null) {
    $sql = "SELECT * FROM products WHERE category = ? AND is_active = 1 ORDER BY display_order ASC, created_at DESC";
    if ($limit) {
        $sql .= " LIMIT " . intval($limit);
    }
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Display product card
function displayProductCard($product) {
    $image = $product['image_url'] ?: '/assets/images/placeholder-product.svg';
    $price = $product['price'] ? '$' . number_format($product['price'], 2) : 'Contact for Price';
    $link = $product['is_affiliate'] && $product['affiliate_link'] 
        ? $product['affiliate_link'] 
        : '#';
    $target = $product['is_affiliate'] ? 'target="_blank" rel="noopener"' : '';
    
    ob_start();
    ?>
    <div class="product-card">
        <div class="product-image">
            <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <?php if ($product['is_affiliate']): ?>
                <span class="affiliate-badge">Affiliate</span>
            <?php endif; ?>
        </div>
        <div class="product-content">
            <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
            <?php if ($product['description']): ?>
                <p class="product-description"><?php echo htmlspecialchars(substr($product['description'], 0, 100)) . (strlen($product['description']) > 100 ? '...' : ''); ?></p>
            <?php endif; ?>
            <div class="product-footer">
                <span class="product-price"><?php echo $price; ?></span>
                <?php if ($link !== '#'): ?>
                    <a href="<?php echo htmlspecialchars($link); ?>" <?php echo $target; ?> class="product-btn">
                        <?php echo $product['is_affiliate'] ? 'Buy Now' : 'View Details'; ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
