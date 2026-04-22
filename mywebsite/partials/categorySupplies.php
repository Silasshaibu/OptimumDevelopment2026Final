<?php
// Connect to database and fetch supplies products
require_once __DIR__ . '/../db.php';

// Fetch active supplies products from database
$suppliesFeatured = [];
$suppliesProducts = [];

// Get featured supplies products (is_featured = 1)
$result = $conn->query("SELECT * FROM products WHERE category = 'supplies' AND is_active = 1 AND is_featured = 1 ORDER BY display_order ASC, created_at DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suppliesFeatured[] = [
            'title' => $row['name'],
            'intro' => $row['summary'] ?: $row['description'],
            'url' => $row['url'] ?: ($row['is_affiliate'] && $row['affiliate_link'] ? $row['affiliate_link'] : './shop.html'),
            'buttonText' => $row['button_text'] ?: 'Learn More',
            'cssClass' => $row['css_class'] ?: 'heroSlide1',
            'buttonClass' => 'cta-shopforsupplies-buynow',
            'titleStyle' => '',
            'introStyle' => '',
            'bgDesktop' => $row['bg_desktop'] ?: ($row['image_url'] ?: $base_url . '/assets/images/placeholder-product.svg'),
            'bgMobile' => $row['bg_mobile'] ?: ($row['image_url'] ?: $base_url . '/assets/images/placeholder-product.svg')
        ];
    }
}

// Get regular supplies products (is_featured = 0)
$result = $conn->query("SELECT * FROM products WHERE category = 'supplies' AND is_active = 1 AND is_featured = 0 ORDER BY display_order ASC, created_at DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suppliesProducts[] = [
            'title' => $row['name'],
            'summary' => $row['summary'] ?: $row['description'],
            'cssClass' => $row['css_class'] ?: 'supplies-default'
        ];
    }
}

// Fallback to hardcoded products if database is empty
if (empty($suppliesFeatured)) {
    $suppliesFeatured = [
        [
            'title' => 'Choose Once, Choose Right',
            'intro' => 'POS Paper Supplies - For Clover Station Duo, Clover Handheld, Dejavoo and More.',
            'url' => './shop.html',
            'buttonText' => 'Buy now',
            'cssClass' => 'heroSlide1',
            'buttonClass' => 'cta-shopforsupplies-buynow',
            'titleStyle' => '',
            'introStyle' => '',
            'bgDesktop' => $base_url . '/assets/images/supplies/supplies-slide1.webp',
            'bgMobile' => $base_url . '/assets/images/supplies/supplies-slide1.webp'
        ],
        [
            'title' => 'Simplify Your POS Setup',
            'intro' => 'Experience the best with essential Supplies for a Smooth Checkout Experience.',
            'url' => '#',
            'buttonText' => 'Learn More',
            'cssClass' => 'heroSlide2',
            'buttonClass' => 'white-liner',
            'titleStyle' => 'color:#ccc',
            'introStyle' => 'color:#ccc;',
            'bgDesktop' => $base_url . '/assets/images/supplies/supplies-slide2.webp',
            'bgMobile' => $base_url . '/assets/images/supplies/supplies-slide2.webp'
        ]
    ];
}

if (empty($suppliesProducts)) {
    $suppliesProducts = [
        [
            'title' => 'Clover Barcode Scanner',
            'summary' => 'Reliable 1D/2D scanner for Clover POS checkout.',
            'cssClass' => 'cloverBarcodeScanner'
        ],
        [
            'title' => 'Ink Ribbon Star Micronics',
            'summary' => 'Long-lasting ribbon for Star SP700 printers.',
            'cssClass' => 'inkRibbonStarMicronics'
        ],
        [
            'title' => 'Star Micronics SP700',
            'summary' => 'Durable impact receipt printer for kitchens/POS.',
            'cssClass' => 'starMicronicsSP700'
        ],
        [
            'title' => 'Dejavoo Z8',
            'summary' => 'Touchscreen payment terminal with advanced features.',
            'cssClass' => 'dejavooZ8'
        ],
        [
            'title' => 'StarMicronics Paper',
            'summary' => 'High-quality receipt rolls for Star printers.',
            'cssClass' => 'starMicronicsPaper'
        ],
        [
            'title' => 'Clover Flex Paper',
            'summary' => 'Thermal paper rolls designed for the Clover Flex.',
            'cssClass' => 'cloverFlexPaper'
        ],
        [
            'title' => 'Clover Cash Drawer',
            'summary' => 'Durable and dependable cash management',
            'cssClass' => 'cloverCashDrawer'
        ],
        [
            'title' => 'Clover Station Paper',
            'summary' => 'Heavy-duty, secure cash drawer for Clover POS.',
            'cssClass' => 'cloverStationPaper'
        ]
    ];
}
?>

 <!-- Supplies section start-->
    <div class="section topProducts-carousel-header">

        <!-- Header with remote controls -->
        <div class="carousel-header withRemote">
            <div class="handHeldDevice-Header">
                <h1 class="producCategoryheading title">Supplies</h1>
            </div>

            <div class="remoteControl">
                <!-- Prev -->
                <button class="carousel-prev view-toggle directionCarousel handHeldDevice" aria-pressed="false">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="icon leftarrow">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </span>
                </button>

                <!-- Next -->
                <button class="carousel-next view-toggle directionCarousel handHeldDevice" aria-pressed="false">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="icon rightarrow">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                </button>
            </div>
        </div>

        <!-- Banner Carousel -->
        <div class="carousel-window supplies" data-carousel>
            <div class="carousel-wrapper supplies">

                <?php foreach($suppliesFeatured as $featured): ?>
                <!-- SLIDE -->
                <div class="slide supplies-product <?= htmlspecialchars($featured['cssClass']) ?>" data-bg-desktop="<?= htmlspecialchars($featured['bgDesktop']) ?>" data-bg-mobile="<?= htmlspecialchars($featured['bgMobile']) ?>" data-lazy="true">
                    <div class="supplies-product">
                        <h3 class="product-title" <?= !empty($featured['titleStyle']) ? 'style="' . htmlspecialchars($featured['titleStyle']) . '"' : '' ?>><?= htmlspecialchars($featured['title']) ?></h3>

                        <p class="product-intro" <?= !empty($featured['introStyle']) ? 'style="' . htmlspecialchars($featured['introStyle']) . '"' : '' ?>>
                            <?= htmlspecialchars($featured['intro']) ?>
                        </p>

                        <button class="btn-featured-products product-Btn-Desktop <?= htmlspecialchars($featured['buttonClass']) ?>" onclick="window.location.href='<?= htmlspecialchars($featured['url']) ?>'">
                            <span><?= htmlspecialchars($featured['buttonText']) ?></span>
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" 
                                     viewBox="0 0 24 24" stroke-width="1.5"
                                     stroke="currentColor" class="icon rightArrowcaret">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </span>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>

               
            </div>
        </div>

        <!-- Body Product Grid -->
        <div class="carousel-body productsGrid supplies-grid">

            <?php foreach($suppliesProducts as $product): ?>
            <!-- Product: <?= htmlspecialchars($product['title']) ?> -->
            <div class="product-grid-item <?= htmlspecialchars($product['cssClass']) ?>">
                <div class="productInfo">
                    <h3 class="productTitle"><?= htmlspecialchars($product['title']) ?></h3>
                    <p class="productSummary"><?= htmlspecialchars($product['summary']) ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>


         <!-- Footer -->
        <div class="carousel-footer withRemote">
                    <div class="remoteControl">
                        <a id="go-to-shop" class="view-toggle handHeldDevice" href="<?= $base_url ?>/shop">
                            <span>View all</span>
                            <span>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                                    <path d="M8.25 4.5L15.75 12L8.25 19.5"
                                        stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </a>
                    </div>
        </div>

    </div>

    
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/category-supplies.css">
    
    <script src="<?= $base_url ?>/assets/js/suppliesCategory.js" defer></script>