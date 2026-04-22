<?php
session_start();
require_once '../db_pdo.php';

$page_title = 'Top Selling Products';
include 'admin-layout.php';

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$id])) {
        $success = "Product deleted successfully.";
    } else {
        $error = "Failed to delete product.";
    }
}

// Fetch top selling products
$stmt = $pdo->prepare("SELECT * FROM products WHERE category = 'top_selling' ORDER BY display_order ASC, created_at DESC");
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>Top Selling Products</h2>
        <div class="admin-actions">
            <a href="product_add.php?category=top_selling" class="btn btn-primary">
                <span class="dashicons">➕</span> Add New Product
            </a>
        </div>
    </div>
    
    <?php if (isset($success)): ?>
        <div class="admin-notification success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <?php if (isset($error)): ?>
        <div class="admin-notification error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <div class="admin-card-body">
        <?php if (empty($products)): ?>
            <div class="empty-state">
                <p>No products found. <a href="product_add.php?category=top_selling">Add your first product</a></p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Affiliate</th>
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
                                <td><?php echo $product['price'] ? '$' . number_format($product['price'], 2) : 'N/A'; ?></td>
                                <td>
                                    <?php if ($product['is_affiliate']): ?>
                                        <span class="badge badge-success">Yes</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">No</span>
                                    <?php endif; ?>
                                </td>
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
