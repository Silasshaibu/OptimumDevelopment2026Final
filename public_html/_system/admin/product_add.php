<?php
session_start();
require_once '../db_pdo.php';

$category = $_GET['category'] ?? 'shop';
$allowed_categories = ['shop', 'top_selling', 'handheld', 'supplies'];
if (!in_array($category, $allowed_categories)) {
    $category = 'shop';
}

// Determine if adding carousel slide or product
$type = $_GET['type'] ?? 'product';
$isCarousel = ($type === 'carousel');

// Set page title based on type
if ($isCarousel) {
    $page_title = 'Add New Carousel Slide';
} else {
    $page_title = 'Add New Product';
}

include 'admin-layout.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $is_affiliate = isset($_POST['is_affiliate']) ? 1 : 0;
    $affiliate_link = trim($_POST['affiliate_link'] ?? '');
    $stock_quantity = intval($_POST['stock_quantity'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $display_order = intval($_POST['display_order'] ?? 0);
    $image_url = '';
    
    // New fields for homepage integration
    $url = trim($_POST['url'] ?? '');
    $summary = trim($_POST['summary'] ?? '');
    $css_class = trim($_POST['css_class'] ?? '');
    $bg_desktop = trim($_POST['bg_desktop'] ?? '');
    $bg_mobile = trim($_POST['bg_mobile'] ?? '');
    // For carousel slides, is_featured is always 1; for products, it's from checkbox
    $is_featured = isset($_POST['is_carousel']) ? 1 : (isset($_POST['is_featured']) ? 1 : 0);
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
                $image_url = '/assets/images/products/' . $new_filename;
            }
        }
    } elseif (!empty($_POST['image_url_manual'])) {
        $image_url = trim($_POST['image_url_manual']);
    }
    
    try {
        $stmt = $pdo->prepare("
            INSERT INTO products (name, description, price, category, is_affiliate, affiliate_link, 
                                image_url, stock_quantity, is_active, display_order,
                                url, summary, css_class, bg_desktop, bg_mobile, is_featured, button_text) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
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
            $button_text
        ]);
        
        // Redirect back to appropriate category page
        $redirect_map = [
            'shop' => 'shop.php',
            'top_selling' => 'top_selling_products.php',
            'handheld' => 'handheld_devices.php',
            'supplies' => 'supplies.php'
        ];
        
        header("Location: " . $redirect_map[$category] . "?success=1");
        exit;
    } catch (PDOException $e) {
        $error = "Error adding product: " . $e->getMessage();
    }
}

$category_labels = [
    'shop' => 'Shop (Affiliate)',
    'top_selling' => 'Top Selling Products',
    'handheld' => 'Handheld Devices',
    'supplies' => 'Supplies'
];
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2><?php echo $isCarousel ? '🎠 Add New Carousel Slide' : '📦 Add New Product'; ?> - <?php echo $category_labels[$category]; ?></h2>
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
                    <input type="text" id="name" name="name" required class="form-control" placeholder="<?php echo $isCarousel ? 'e.g., Choose Once, Choose Right' : 'e.g., Clover Flex'; ?>">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="summary"><?php echo $isCarousel ? 'Slide Summary' : 'Product Summary'; ?> <span class="required">*</span></label>
                    <textarea id="summary" name="summary" rows="3" class="form-control" placeholder="<?php echo $isCarousel ? 'Short promotional text for the slide' : 'Brief product description'; ?>"></textarea>
                </div>
            </div>
            
            <?php if (!$isCarousel): ?>
            <div class="form-row">
                <div class="form-group">
                    <label for="description">Full Description</label>
                    <textarea id="description" name="description" rows="5" class="form-control"></textarea>
                </div>
            </div>
            <?php endif; ?>
            
            <?php if (!$isCarousel): ?>
            <!-- PRODUCT-ONLY FIELDS -->
            <div class="form-row">
                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" class="form-control" placeholder="0.00">
                </div>
                
                <div class="form-group">
                    <label for="stock_quantity">Stock Quantity</label>
                    <input type="number" id="stock_quantity" name="stock_quantity" min="0" value="0" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="display_order">Display Order</label>
                    <input type="number" id="display_order" name="display_order" value="0" class="form-control">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="is_affiliate">
                        <input type="checkbox" name="is_affiliate" id="is_affiliate">
                        This is an affiliate product
                    </label>
                </div>
            </div>
            
            <div class="form-row" id="affiliate_link_row" style="display: none;">
                <div class="form-group">
                    <label for="affiliate_link">Affiliate Link</label>
                    <input type="url" id="affiliate_link" name="affiliate_link" class="form-control" placeholder="https://...">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="product_image">Upload Product Image</label>
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
                    <input type="text" id="url" name="url" class="form-control" placeholder="e.g., main/clover-flex.php">
                    <small class="form-text">Link to the product details page</small>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="css_class">CSS Class</label>
                    <input type="text" id="css_class" name="css_class" class="form-control" placeholder="e.g., cloverFlex">
                    <small class="form-text">Used for styling the product card background</small>
                </div>
            </div>
            
            <?php else: ?>
            <!-- CAROUSEL SLIDE FIELDS -->
            <div class="form-row">
                <div class="form-group">
                    <label for="display_order">Slide Order</label>
                    <input type="number" id="display_order" name="display_order" value="1" class="form-control">
                    <small class="form-text">Order in which slides appear (1 = first)</small>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="url">Button Link URL</label>
                    <input type="text" id="url" name="url" class="form-control" placeholder="e.g., main/shop.php or #">
                    <small class="form-text">Where the button links to</small>
                </div>
                <div class="form-group">
                    <label for="button_text">Button Text</label>
                    <input type="text" id="button_text" name="button_text" class="form-control" value="Learn More" placeholder="e.g., Learn More, Buy Now">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="css_class">CSS Class</label>
                    <input type="text" id="css_class" name="css_class" class="form-control" placeholder="e.g., heroSlide1">
                    <small class="form-text">Used for custom slide styling</small>
                </div>
            </div>
            
            <h4 style="margin-top: 20px; margin-bottom: 15px; color: #333; border-top: 1px solid #ddd; padding-top: 20px;">Background Images</h4>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="bg_desktop">Desktop Background Image <span class="required">*</span></label>
                    <input type="text" id="bg_desktop" name="bg_desktop" class="form-control" placeholder="assets/images/supplies/supplies-slide1.webp" required>
                    <small class="form-text">Path or URL to desktop background (1200x600px recommended)</small>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="bg_mobile">Mobile Background Image <span class="required">*</span></label>
                    <input type="text" id="bg_mobile" name="bg_mobile" class="form-control" placeholder="assets/images/supplies/supplies-slide1-mobile.webp" required>
                    <small class="form-text">Path or URL to mobile background (600x400px recommended)</small>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="is_active">
                        <input type="checkbox" name="is_active" id="is_active" checked>
                        Active (visible on frontend)
                    </label>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary"><?php echo $isCarousel ? 'Add Slide' : 'Add Product'; ?></button>
                <a href="<?php 
                    echo $category === 'shop' ? 'shop.php' : 
                        ($category === 'top_selling' ? 'top_selling_products.php' : 
                        ($category === 'handheld' ? 'handheld_devices.php' : 'supplies.php')); 
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
