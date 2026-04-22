<?php
session_start();
require_once '../db_pdo.php';

$product_id = intval($_GET['id'] ?? 0);

// Fetch product details
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: shop.php");
    exit;
}

// Determine if this is a carousel slide or product based on is_featured flag
$isCarousel = ($product['is_featured'] == 1);

// Set page title based on type
if ($isCarousel) {
    $page_title = 'Edit Carousel Slide';
} else {
    $page_title = 'Edit Product';
}

include 'admin-layout.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $category = $_POST['category'] ?? $product['category'];
    $is_affiliate = isset($_POST['is_affiliate']) ? 1 : 0;
    $affiliate_link = trim($_POST['affiliate_link'] ?? '');
    $stock_quantity = intval($_POST['stock_quantity'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $display_order = intval($_POST['display_order'] ?? 0);
    $image_url = $product['image_url'];
    
    // New fields for homepage integration
    $url = trim($_POST['url'] ?? '');
    $summary = trim($_POST['summary'] ?? '');
    $css_class = trim($_POST['css_class'] ?? '');
    $bg_desktop = trim($_POST['bg_desktop'] ?? '');
    $bg_mobile = trim($_POST['bg_mobile'] ?? '');
    // Keep the is_featured value (carousel stays carousel, product stays product)
    $is_featured = isset($_POST['is_carousel']) ? 1 : $product['is_featured'];
    $button_text = trim($_POST['button_text'] ?? 'Learn More');
    
    // Handle image upload
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../assets/images/products/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES['product_image']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($file_extension, $allowed_extensions)) {
            $new_filename = uniqid('product_') . '.' . $file_extension;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_path)) {
                // Delete old image if exists
                if ($image_url && file_exists('../../' . parse_url($image_url, PHP_URL_PATH))) {
                    @unlink('../../' . parse_url($image_url, PHP_URL_PATH));
                }
                $image_url = '/assets/images/products/' . $new_filename;
            }
        }
    } elseif (!empty($_POST['image_url_manual'])) {
        $image_url = trim($_POST['image_url_manual']);
    }
    
    try {
        $stmt = $pdo->prepare("
            UPDATE products 
            SET name = ?, description = ?, price = ?, category = ?, is_affiliate = ?, 
                affiliate_link = ?, image_url = ?, stock_quantity = ?, is_active = ?, 
                display_order = ?, url = ?, summary = ?, css_class = ?, bg_desktop = ?, 
                bg_mobile = ?, is_featured = ?, button_text = ?
            WHERE id = ?
        ");
        
        $stmt->execute([
            $name, 
            $description, 
            $price, 
            $category, 
            $is_affiliate, 
            $affiliate_link, 
            $image_url, 
            $stock_quantity, 
            $is_active, 
            $display_order,
            $url,
            $summary,
            $css_class,
            $bg_desktop,
            $bg_mobile,
            $is_featured,
            $button_text,
            $product_id
        ]);
        
        // Redirect back to appropriate category page
        $redirect_map = [
            'shop' => 'shop.php',
            'top_selling' => 'top_selling_products.php',
            'handheld' => 'handheld_devices.php',
            'supplies' => 'supplies.php'
        ];
        
        header("Location: " . $redirect_map[$category] . "?success=updated");
        exit;
    } catch (PDOException $e) {
        $error = "Error updating product: " . $e->getMessage();
    }
}
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2><?php echo $isCarousel ? '🎠 Edit Carousel Slide' : '📦 Edit Product'; ?></h2>
    </div>
    
    <?php if (isset($error)): ?>
        <div class="admin-notification error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <div class="admin-card-body">
        <form method="POST" enctype="multipart/form-data" class="admin-form">
            <?php if ($isCarousel): ?>
                <input type="hidden" name="is_carousel" value="1">
            <?php endif; ?>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="name"><?php echo $isCarousel ? 'Slide Title' : 'Product Name'; ?> <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required class="form-control">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="summary"><?php echo $isCarousel ? 'Slide Summary' : 'Product Summary'; ?></label>
                    <textarea id="summary" name="summary" rows="3" class="form-control"><?php echo htmlspecialchars($product['summary'] ?? ''); ?></textarea>
                </div>
            </div>
            
            <?php if (!$isCarousel): ?>
            <div class="form-row">
                <div class="form-group">
                    <label for="description">Full Description</label>
                    <textarea id="description" name="description" rows="5" class="form-control"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" class="form-control">
                        <option value="shop" <?php echo $product['category'] === 'shop' ? 'selected' : ''; ?>>Shop (Affiliate)</option>
                        <option value="top_selling" <?php echo $product['category'] === 'top_selling' ? 'selected' : ''; ?>>Top Selling Products</option>
                        <option value="handheld" <?php echo $product['category'] === 'handheld' ? 'selected' : ''; ?>>Handheld Devices</option>
                        <option value="supplies" <?php echo $product['category'] === 'supplies' ? 'selected' : ''; ?>>Supplies</option>
                    </select>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="<?php echo $product['price']; ?>" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="stock_quantity">Stock Quantity</label>
                    <input type="number" id="stock_quantity" name="stock_quantity" min="0" value="<?php echo $product['stock_quantity']; ?>" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="display_order">Display Order</label>
                    <input type="number" id="display_order" name="display_order" value="<?php echo $product['display_order']; ?>" class="form-control">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="is_affiliate">
                        <input type="checkbox" name="is_affiliate" id="is_affiliate" <?php echo $product['is_affiliate'] ? 'checked' : ''; ?>>
                        This is an affiliate product
                    </label>
                </div>
            </div>
            
            <div class="form-row" id="affiliate_link_row" style="display: <?php echo $product['is_affiliate'] ? 'block' : 'none'; ?>;">
                <div class="form-group">
                    <label for="affiliate_link">Affiliate Link</label>
                    <input type="url" id="affiliate_link" name="affiliate_link" value="<?php echo htmlspecialchars($product['affiliate_link']); ?>" class="form-control">
                </div>
            </div>
            
            <?php if ($product['image_url']): ?>
                <div class="form-row">
                    <div class="form-group">
                        <p>Current Image</p>
                        <div class="current-image">
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product" style="max-width: 200px; height: auto;">
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product_image">Upload New Image</label>
                    <input type="file" id="product_image" name="product_image" accept="image/*" class="form-control">
                    <small class="form-text">Accepted formats: JPG, PNG, GIF, WEBP (Max 5MB)</small>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="image_url_manual">Or Enter Image URL</label>
                    <input type="url" id="image_url_manual" name="image_url_manual" class="form-control" placeholder="https://...">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="url">Product Page URL</label>
                    <input type="text" id="url" name="url" value="<?php echo htmlspecialchars($product['url'] ?? ''); ?>" class="form-control" placeholder="e.g., main/clover-flex.php">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="css_class">CSS Class</label>
                    <input type="text" id="css_class" name="css_class" value="<?php echo htmlspecialchars($product['css_class'] ?? ''); ?>" class="form-control" placeholder="e.g., cloverFlex">
                </div>
            </div>
            
            <?php else: ?>
            <!-- CAROUSEL SLIDE FIELDS -->
            <div class="form-row">
                <div class="form-group">
                    <label for="display_order">Slide Order</label>
                    <input type="number" id="display_order" name="display_order" value="<?php echo $product['display_order']; ?>" class="form-control">
                    <small class="form-text">Order in which slides appear (1 = first)</small>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="url">Button Link URL</label>
                    <input type="text" id="url" name="url" value="<?php echo htmlspecialchars($product['url'] ?? ''); ?>" class="form-control" placeholder="e.g., main/shop.php or #">
                </div>
                <div class="form-group">
                    <label for="button_text">Button Text</label>
                    <input type="text" id="button_text" name="button_text" value="<?php echo htmlspecialchars($product['button_text'] ?? 'Learn More'); ?>" class="form-control">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="css_class">CSS Class</label>
                    <input type="text" id="css_class" name="css_class" value="<?php echo htmlspecialchars($product['css_class'] ?? ''); ?>" class="form-control" placeholder="e.g., heroSlide1">
                </div>
            </div>
            
            <h4 style="margin-top: 20px; margin-bottom: 15px; color: #333; border-top: 1px solid #ddd; padding-top: 20px;">Background Images</h4>
            
            <?php if ($product['bg_desktop']): ?>
            <div class="form-row">
                <div class="form-group">
                    <p>Current Desktop Background</p>
                    <div class="current-image">
                        <img src="/<?php echo htmlspecialchars($product['bg_desktop']); ?>" alt="Desktop BG" style="max-width: 300px; height: auto;">
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="bg_desktop">Desktop Background Image</label>
                    <input type="text" id="bg_desktop" name="bg_desktop" value="<?php echo htmlspecialchars($product['bg_desktop'] ?? ''); ?>" class="form-control" placeholder="assets/images/supplies/supplies-slide1.webp">
                    <small class="form-text">Path or URL to desktop background (1200x600px recommended)</small>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="bg_mobile">Mobile Background Image</label>
                    <input type="text" id="bg_mobile" name="bg_mobile" value="<?php echo htmlspecialchars($product['bg_mobile'] ?? ''); ?>" class="form-control" placeholder="assets/images/supplies/supplies-slide1-mobile.webp">
                    <small class="form-text">Path or URL to mobile background (600x400px recommended)</small>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="is_active">
                        <input type="checkbox" name="is_active" id="is_active" <?php echo $product['is_active'] ? 'checked' : ''; ?>>
                        Active (visible on frontend)
                    </label>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><?php echo $isCarousel ? 'Update Slide' : 'Update Product'; ?></button>
                <a href="<?php 
                    echo $product['category'] === 'shop' ? 'shop.php' : 
                        ($product['category'] === 'top_selling' ? 'top_selling_products.php' : 
                        ($product['category'] === 'handheld' ? 'handheld_devices.php' : 'supplies.php')); 
                ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
<?php if (!$isCarousel): ?>
document.getElementById('is_affiliate').addEventListener('change', function() {
    document.getElementById('affiliate_link_row').style.display = this.checked ? 'block' : 'none';
});
<?php endif; ?>
</script>

<?php include 'admin-layout-footer.php'; ?>
