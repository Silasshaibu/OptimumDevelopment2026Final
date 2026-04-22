<?php
// Connect to database and fetch handheld products
require_once __DIR__ . '/../db.php';

// Fetch active handheld products from database
$handheldFeatured = [];
$handheldProducts = [];

// Get featured handheld products (is_featured = 1)
$result = $conn->query("SELECT * FROM products WHERE category = 'handheld' AND is_active = 1 AND is_featured = 1 ORDER BY display_order ASC, created_at DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $handheldFeatured[] = [
            'title' => $row['name'],
            'intro' => $row['summary'] ?: $row['description'],
            'url' => $row['url'] ?: $base_url . '/' . strtolower(str_replace(' ', '-', $row['name'])),
            'cssClass' => $row['css_class'] ?: 'handheld__featured--default',
            'bgDesktop' => $row['bg_desktop'] ?: ($row['image_url'] ?: $base_url . '/assets/images/placeholder-product.svg'),
            'bgMobile' => $row['bg_mobile'] ?: ($row['image_url'] ?: $base_url . '/assets/images/placeholder-product.svg')
        ];
    }
}

// Get regular handheld products (is_featured = 0)
$result = $conn->query("SELECT * FROM products WHERE category = 'handheld' AND is_active = 1 AND is_featured = 0 ORDER BY display_order ASC, created_at DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $handheldProducts[] = [
            'title' => $row['name'],
            'summary' => $row['summary'] ?: $row['description'],
            'url' => $row['url'] ?: $base_url . '/' . strtolower(str_replace(' ', '-', $row['name'])),
            'cssClass' => $row['css_class'] ?: 'handheld-default'
        ];
    }
}

// Fallback to hardcoded products if database is empty
if (empty($handheldFeatured)) {
    $handheldFeatured = [
        [
            'title' => 'Valor VP 800',
            'intro' => 'The complete portable solution',
            'url' => $base_url . '/valor-vp800',
            'cssClass' => 'handheld__featured--vp800',
            'bgDesktop' => $base_url . '/assets/images/handheld/vp800-featured.webp',
            'bgMobile' => $base_url . '/assets/images/handheld/vp800-featured.webp'
        ],
        [
            'title' => 'Valor VP 550',
            'intro' => 'The complete portable solution',
            'url' => $base_url . '/valor-vp550',
            'cssClass' => 'handheld__featured--vp550',
            'bgDesktop' => $base_url . '/assets/images/handheld/vp550-featured.webp',
            'bgMobile' => $base_url . '/assets/images/handheld/vp550-featured.webp'
        ]
    ];
}

if (empty($handheldProducts)) {
    $handheldProducts = [
        [
            'title' => 'Valor VP800',
            'summary' => 'High‑performance portable device High‑performance portable deviceHigh‑performance portable device',
            'url' => $base_url . '/valor-vp800',
            'cssClass' => 'valorVP800'
        ],
        [
            'title' => 'Valor VP550',
            'summary' => 'Small footprint, big capability',
            'url' => $base_url . '/valor-vp550',
            'cssClass' => 'valorVP550'
        ],
        [
            'title' => 'Valor VL100',
            'summary' => 'Compact and reliable solution',
            'url' => $base_url . '/valor-vl100',
            'cssClass' => 'valorVL100'
        ],
        [
            'title' => 'Valor VL110',
            'summary' => 'Next‑gen portable accuracy',
            'url' => $base_url . '/valor-vl110',
            'cssClass' => 'valorVL110'
        ],
        [
            'title' => 'Clover Flex',
            'summary' => 'Light and flexible payment solution',
            'url' => $base_url . '/clover-flex',
            'cssClass' => 'cloverFlex'
        ],
        [
            'title' => 'Clover Go Plus',
            'summary' => 'Portable and versatile on‑the‑go system',
            'url' => $base_url . '/clover-go',
            'cssClass' => 'cloverGoPlus'
        ],
        [
            'title' => 'Union POS',
            'summary' => 'Portable and versatile on‑the‑go system',
            'url' => $base_url . '/union',
            'cssClass' => 'UnionPOS'
        ],
        [
            'title' => 'Swipe Simple',
            'summary' => 'Portable and versatile on‑the‑go system',
            'url' => $base_url . '/swipe-simple',
            'cssClass' => 'SwipeSimple'
        ]
    ];
}
?>

 <!-- HandHeld Devices Section Start -->
<section class="handheld js-handheld">
    <!-- Header with more Remote controls-->
        <div class="handheld__header withRemote">
        <div class="handHeldDevice-Header">
            <h1 class="producCategoryheading title">Handheld Devices</h1>
        </div>
        <div class="handheld__controls handheld remoteControl">
            <button  class="handheld__arrow js-handheld-prev" aria-pressed="false">
                <span>
                                    
                <!-- leftPrevArrow -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="handheld icon leftarrow">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>


            </button>

            <button class="handheld__arrow js-handheld-next" aria-pressed="false">
                <span>                  

                <!-- rightNextArrow -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="handheld icon rightarrow">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>

                </span>

            </button>


        </div>
        </div>    

    <!-- Banner Carousel -->
    <div class="handheld__carousel js-handheld-carousel" data-carousel>
        <div class="handheld__track js-handheld-track">

            <?php foreach($handheldFeatured as $featured): ?>
            <!-- SLIDE -->
            <div class="handheld__slide" data-bg-desktop="<?= htmlspecialchars($featured['bgDesktop']) ?>" data-bg-mobile="<?= htmlspecialchars($featured['bgMobile']) ?>" data-lazy="true">
                <div class="handheld__featured <?= htmlspecialchars($featured['cssClass']) ?>">

                    <h3 class="handheld product-title"><?= htmlspecialchars($featured['title']) ?>                        
                    </h3>
                
                    <p class="handheld product-intro"><?= htmlspecialchars($featured['intro']) ?></p>
                    <button class="handheld btn-featured-products" onclick="window.location.href='<?= htmlspecialchars($featured['url']) ?>'">Learn More <span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon rightArrowcaret">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                        </span>
                    </button>                       
                </div>
                
            </div>
            <?php endforeach; ?>
        </div> 
    </div>            

    <!-- Body Product Container -->
    <!-- Updated Product Grid with 6 items -->
    <div class="handheld__carousel handheld__grid">
    <?php foreach($handheldProducts as $product): ?>
    <!-- Product: <?= htmlspecialchars($product['title']) ?> -->
    <div class="handheld__item <?= htmlspecialchars($product['cssClass']) ?>">
        <div class="handheld-productInfo">
            <h3 class="handheld-productTitle"><?= htmlspecialchars($product['title']) ?></h3>
            <p class="handheld-productSummary"><?= htmlspecialchars($product['summary']) ?></p>
            <span style="padding: 1.5rem 0px;"><a class="handheld-productLink" href="<?= htmlspecialchars($product['url']) ?>"><span>View Product</span> <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon rightArrow"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg></span></a></span>
        </div>
    </div>
    <?php endforeach; ?>




    </div>
    
    <!-- Footer with Fewer Remote Controls -->
    <div class="handheld-carousel-footer withRemote">
        <div class="remoteControl">
            <button class="handheld__toggle js-handheld-toggle" aria-pressed="false">
            <span>View all</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden>
                <path d="M8.25 4.5L15.75 12L8.25 19.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            
            </button>
        </div>
    </div>       
</section>

<link rel="stylesheet" href="<?= $base_url ?>/assets/css/category-handheld.css">

<script src="<?= $base_url ?>/assets/js/handheldProductsCategory.js" defer></script>