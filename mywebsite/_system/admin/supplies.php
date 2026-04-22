<?php
session_start();
require_once '../db_pdo.php';

$page_title = 'Supplies';
include 'admin-layout.php';

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$id])) {
        $success = "Item deleted successfully.";
    } else {
        $error = "Failed to delete item.";
    }
}

// Fetch carousel slides (featured)
$stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'supplies' AND is_featured = 1 ORDER BY display_order ASC, created_at DESC");
$stmt->execute();
$carouselSlides = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch regular products
$stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'supplies' AND is_featured = 0 ORDER BY display_order ASC, created_at DESC");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php if (isset($success)): ?>
    <div class="admin-notification success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div class="admin-notification error"><?php echo htmlspecialchars($error); ?></div>
<?php endif; ?>

<!-- CAROUSEL SLIDES SECTION -->
<div class="admin-card">
    <div class="admin-card-header">
        <h2>🎠 Carousel Slides</h2>
        <div class="admin-actions">
            <a href="product_add.php?category=supplies&type=carousel" class="btn btn-primary">
                <span class="dashicons">➕</span> Add New Slide
            </a>
        </div>
    </div>
    
    <p class="section-description" style="padding: 0 20px; color: #666; margin-bottom: 15px;">
        These are the hero banner slides that appear in the carousel at the top of the Supplies section.
    </p>
    
    <div class="admin-card-body">
        <?php if (empty($carouselSlides)): ?>
            <div class="empty-state">
                <p>No carousel slides found. <a href="product_add.php?category=supplies&type=carousel">Add your first slide</a></p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Preview</th>
                            <th>Title</th>
                            <th>Summary</th>
                            <th>Button Text</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($carouselSlides as $slide): ?>
                            <tr>
                                <td>
                                    <?php if ($slide['bg_desktop']): ?>
                                        <img src="/<?php echo htmlspecialchars($slide['bg_desktop']); ?>" alt="Slide" class="product-thumbnail" style="width: 120px; height: 60px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="product-thumbnail-placeholder">No Image</div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?php echo htmlspecialchars($slide['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars(substr($slide['summary'] ?? '', 0, 50)) . (strlen($slide['summary'] ?? '') > 50 ? '...' : ''); ?></td>
                                <td><?php echo htmlspecialchars($slide['button_text'] ?? 'Learn More'); ?></td>
                                <td>
                                    <?php if ($slide['is_active']): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $slide['display_order']; ?></td>
                                <td class="actions">
                                    <a href="product_edit.php?id=<?php echo $slide['id']; ?>" class="btn-icon" title="Edit">✏️</a>
                                    <a href="?action=delete&id=<?php echo $slide['id']; ?>" 
                                       class="btn-icon" 
                                       title="Delete"
                                       onclick="return confirm('Are you sure you want to delete this slide?')">🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- REGULAR PRODUCTS SECTION -->
<div class="admin-card" style="margin-top: 30px;">
    <div class="admin-card-header">
        <h2>📦 Products Grid</h2>
        <div class="admin-actions">
            <a href="product_add.php?category=supplies&type=product" class="btn btn-primary">
                <span class="dashicons">➕</span> Add New Product
            </a>
        </div>
    </div>
    
    <p class="section-description" style="padding: 0 20px; color: #666; margin-bottom: 15px;">
        These are the individual product cards displayed in the grid below the carousel.
    </p>
    
    <div class="admin-card-body">
        <?php if (empty($products)): ?>
            <div class="empty-state">
                <p>No products found. <a href="product_add.php?category=supplies&type=product">Add your first product</a></p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Summary</th>
                            <th>CSS Class</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <?php if ($product['image_url']): ?>
                                        <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="Product" class="product-thumbnail">
                                    <?php else: ?>
                                        <div class="product-thumbnail-placeholder">No Image</div>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?php echo htmlspecialchars($product['name']); ?></strong></td>
                                <td><?php echo htmlspecialchars(substr($product['summary'] ?? '', 0, 40)) . (strlen($product['summary'] ?? '') > 40 ? '...' : ''); ?></td>
                                <td><code><?php echo htmlspecialchars($product['css_class'] ?? ''); ?></code></td>
                                <td>
                                    <?php if ($product['is_active']): ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $product['display_order']; ?></td>
                                <td class="actions">
                                    <a href="product_edit.php?id=<?php echo $product['id']; ?>" class="btn-icon" title="Edit">✏️</a>
                                    <a href="?action=delete&id=<?php echo $product['id']; ?>" 
                                       class="btn-icon" 
                                       title="Delete"
                                       onclick="return confirm('Are you sure you want to delete this product?')">🗑️</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'admin-layout-footer.php'; ?>
