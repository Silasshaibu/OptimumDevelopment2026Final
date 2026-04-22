<?php
// Connect to database and fetch top selling products
require_once __DIR__ . '/../db.php';

// Fetch active top selling products from database
$topProducts = [];
$result = $conn->query("SELECT * FROM products WHERE category = 'top_selling' AND is_active = 1 ORDER BY display_order ASC, created_at DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $topProducts[] = [
            'title' => $row['name'],
            'url' => $row['url'] ?: $base_url . '/' . strtolower(str_replace(' ', '-', $row['name'])),
            'summary' => $row['summary'] ?: $row['description'],
            'bgDesktop' => $row['bg_desktop'] ?: ($row['image_url'] ?: $base_url . '/assets/images/placeholder-product.svg'),
            'bgMobile' => $row['bg_mobile'] ?: ($row['image_url'] ?: $base_url . '/assets/images/placeholder-product.svg')
        ];
    }
}

// Fallback to hardcoded products if database is empty
if (empty($topProducts)) {
    $topProducts = [
        [
            'title' => 'Valor VP 550',
            'url' => $base_url . '/valor-vp550',
            'summary' => 'The Smart Android Counterop that eliminates charge to the merchant',
            'bgDesktop' => $base_url . '/assets/images/products/topSellingProducts/topCategory-Desktop-valorVP550.webp',
            'bgMobile' => $base_url . '/assets/images/products/topSellingProducts/topCategory-Mobile_valorVP550.webp'
        ],
        [
            'title' => 'Clover Mini',
            'url' => $base_url . '/clover-mini',
            'summary' => 'The Smart Android Counterop that eliminates charge to the merchant',
            'bgDesktop' => $base_url . '/assets/images/products/topSellingProducts/topCategory-Desktop-cloverMini.webp',
            'bgMobile' => $base_url . '/assets/images/products/topSellingProducts/cloverMiniDevice-mobile.webp'
        ],
        [
            'title' => 'Clover Flex',
            'url' => $base_url . '/clover-flex',
            'summary' => 'The Smart Android Counterop that eliminates charge to the merchant',
            'bgDesktop' => $base_url . '/assets/images/products/topSellingProducts/topCategory-Desktop-cloverFlex.webp',
            'bgMobile' => $base_url . '/assets/images/products/topSellingProducts/topCategory-Mobile_CloverFlex.webp'
        ],
        [
            'title' => 'Valor VP800',
            'url' => $base_url . '/valor-vp800',
            'summary' => 'The Smart Android Counterop that eliminates charge to the merchant',
            'bgDesktop' => $base_url . '/assets/images/products/topSellingProducts/topCategory-Desktop-VP800.webp',
            'bgMobile' => $base_url . '/assets/images/products/topSellingProducts/topCategory-Mobile_valorVP800.webp'
        ]
    ];
}
?>

<!-- TopSellingProductSection Start -->
    <section class="topCategory-section">
        <div class="topCategory-HeadAndBodyContainer">
            <!-- Head -->
            <div class="topCategory-header">
                <h2 class="topCategory-title">Top Selling Products</h2>
                <div class="topCategory-controls">
                    <!--Left Caret Arrow-->
                    <span>                            
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon topCategory-leftArrow">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                    </span>

                    <!--Right Caret Arrow-->
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon topCategory-rightArrow">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </span>
                    
                </div>
            </div>
        
            <!-- Body -->
            <div class="topCategory-carousel">
                <div class="topCategory-wrapper">      
                    
                    <?php foreach($topProducts as $product): ?>
                    <!-- Product Item <?= htmlspecialchars($product['title']) ?> -->
                    <div class="topCategory-product" 
                         data-bg-desktop="<?= htmlspecialchars($product['bgDesktop']) ?>" 
                         data-bg-mobile="<?= htmlspecialchars($product['bgMobile']) ?>" 
                         data-lazy="true">

                        <h3 class="topCategory-productTitle"><?= htmlspecialchars($product['title']) ?><br class="topCategory-breakLineTitle">
                            <a class="topCategory-productLinkMobile" href="<?= htmlspecialchars($product['url']) ?>">Learn More
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon topCategory-rightArrowcaret">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </span>
                            </a>
                        </h3>
                    
                        <p class="topCategory-productSummary"><?= htmlspecialchars($product['summary']) ?></p>
                        <button class="btn-topCategory-products topCategory-productBtnDesktop" onclick="window.location.href='<?= htmlspecialchars($product['url']) ?>'">Learn More <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon topCategory-rightArrowcaret">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                            </span>
                        </button>                       
                    </div>
                    <?php endforeach; ?> 
                    
            </div>
            </div>

            <!-- Foot -->
            <div class="topCategory-footer">                     
                <!-- This should convert the carousel into a 1  by x grid system -->
                <div class="topCategory-bottomControls-foot">
                    <!--Mobile Right Caret Arrow--> 
                    <a id="topCategoryViewAll" class="topCategory-viewAllBtn" role="button" aria-expanded="false">
                        <span class="topCategory-viewAllLabel">View all</span>
                        <span class="topCategory-viewAllIcon">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="icon rightTopCategoryMobileArrow">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </span>
                    </a>
                        
                    
                </div>
            </div>
        </div>
    </section>

    
    
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/category-top-selling-product.css">

    <style>
        .topCategory-section{
            padding-top:4rem;
            padding-bottom:2rem;

        }

        @media (max-width:768px){        
            .topCategory-product{
                /* display:grid; */
                display: flex;
                flex-direction: column;
                align-content: space-between;
                justify-content: space-between;
            }
        }
    </style>

    
    
    <script src="<?= $base_url ?>/assets/js/topSellingProductsCategory.js" defer></script>