<?php
include 'db.php';
include 'config.php';

header('Content-Type: application/json');

// Configuration
$searchProductsOnly = true; // Set to false to include pages in search results

$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

// Shop products (JavaScript-driven, stored here for search)
$shopProducts = [
    [
        'id' => 'clover-flex-paper',
        'name' => 'Clover Flex Paper',
        'image' => $base_url . '/assets/images/products/storeProducts/CloverFlexPaper.webp',
        'link' => 'https://www.amazon.com/dp/B07YJNK8WP?tag=optimumpay-20'
    ],
    [
        'id' => 'clover-mini-paper',
        'name' => 'Clover Mini Paper',
        'image' => $base_url . '/assets/images/products/storeProducts/CloverMini_Paper_1-1.webp',
        'link' => 'https://www.amazon.com/dp/B07YJNK8WP?tag=optimumpay-20'
    ],
    [
        'id' => 'clover-station-paper',
        'name' => 'Clover Station Paper',
        'image' => $base_url . '/assets/images/products/storeProducts/CloverStationPaper.webp',
        'link' => 'https://www.amazon.com/dp/B07YJNK8WP?tag=optimumpay-20'
    ],
    [
        'id' => 'clover-cash-drawer',
        'name' => 'Clover Cash Drawer',
        'image' => $base_url . '/assets/images/products/storeProducts/Clover_Cash_Drawer_1-1.webp',
        'link' => 'https://www.amazon.com/dp/B01LZWOK0J?tag=optimumpay-20'
    ],
    [
        'id' => '2d-clover-barcode-scanner',
        'name' => '2D Clover Barcode Scanner',
        'image' => $base_url . '/assets/images/products/storeProducts/2D_Clover_BarcodeScanner_1-1.webp',
        'link' => 'https://www.amazon.com/dp/B07D7411FQ?tag=optimumpay-20'
    ],
    [
        'id' => 'dejavoo-z8',
        'name' => 'Dejavoo Z8',
        'image' => $base_url . '/assets/images/products/storeProducts/DejavooZ8.webp',
        'link' => $base_url . '/shop-product?id=dejavoo-z8'
    ],
    [
        'id' => 'dejavoo-z9',
        'name' => 'Dejavoo Z9',
        'image' => $base_url . '/assets/images/products/storeProducts/DejavooZ9.webp',
        'link' => $base_url . '/shop-product?id=dejavoo-z9'
    ],
    [
        'id' => 'dejavoo-z11',
        'name' => 'Dejavoo Z11',
        'image' => $base_url . '/assets/images/products/storeProducts/DejavooZ11.webp',
        'link' => $base_url . '/shop-product?id=dejavoo-z11'
    ],
    [
        'id' => 'ink-ribbon-star-micronics',
        'name' => 'Ink Ribbon Star Micronics',
        'image' => $base_url . '/assets/images/products/storeProducts/InkRibbonStarMicronics.webp',
        'link' => 'https://www.amazon.com/dp/B00006ISCX?tag=optimumpay-20'
    ],
    [
        'id' => 'star-micronics-paper',
        'name' => 'Star Micronics Paper',
        'image' => $base_url . '/assets/images/products/storeProducts/StarMicronicsPaper.webp',
        'link' => 'https://www.amazon.com/dp/B07YJNK8WP?tag=optimumpay-20'
    ],
    [
        'id' => 'star-micronics-sp700',
        'name' => 'Star Micronics SP700',
        'image' => $base_url . '/assets/images/products/storeProducts/Star_Micronics_SP700_1-1.webp',
        'link' => 'https://www.amazon.com/dp/B0007KPPTS?tag=optimumpay-20'
    ]
];

// Define searchable pages
$pages = [
    ['name' => 'About Us', 'url' => '/about', 'keywords' => 'about company team history mission'],
    ['name' => 'Payment Processing Solutions', 'url' => '/processing-solutions', 'keywords' => 'payment processing solutions merchant services'],
    ['name' => 'Merchant Application', 'url' => '/merchant-application', 'keywords' => 'merchant application apply signup register'],
    ['name' => 'Business Financing', 'url' => '/business-financing', 'keywords' => 'business financing funding loans capital'],
    ['name' => 'Digital Services', 'url' => '/digital-services', 'keywords' => 'digital services web design development creative'],
    ['name' => 'Clover Station Duo', 'url' => '/clover-station-duo', 'keywords' => 'clover station duo pos system'],
    ['name' => 'Clover Station Solo', 'url' => '/clover-station-solo', 'keywords' => 'clover station solo pos system'],
    ['name' => 'Clover Mini', 'url' => '/clover-mini', 'keywords' => 'clover mini pos compact'],
    ['name' => 'Clover Flex', 'url' => '/clover-flex', 'keywords' => 'clover flex portable handheld'],
    ['name' => 'Clover Go', 'url' => '/clover-go', 'keywords' => 'clover go mobile reader'],
    ['name' => 'Valor VP100', 'url' => '/valor-vp100', 'keywords' => 'valor vp100 terminal'],
    ['name' => 'Valor VP550', 'url' => '/valor-vp550', 'keywords' => 'valor vp550 terminal'],
    ['name' => 'Valor VP800', 'url' => '/valor-vp800', 'keywords' => 'valor vp800 terminal'],
    ['name' => 'Valor VL100', 'url' => '/valor-vl100', 'keywords' => 'valor vl100 terminal'],
    ['name' => 'Valor VL110', 'url' => '/valor-vl110', 'keywords' => 'valor vl110 terminal'],
    ['name' => 'NMI Payment Gateway', 'url' => '/nmi', 'keywords' => 'nmi gateway payment processing'],
    ['name' => 'Hyfin Solutions', 'url' => '/hyfin', 'keywords' => 'hyfin cash discount surcharge'],
    ['name' => 'OctoPOS', 'url' => '/octopos', 'keywords' => 'octopos point of sale'],
    ['name' => 'TabIt', 'url' => '/tabit', 'keywords' => 'tabit restaurant ordering'],
    ['name' => 'Swipe Simple', 'url' => '/swipe-simple', 'keywords' => 'swipe simple payment'],
    ['name' => 'Contact Us', 'url' => '/contact-us', 'keywords' => 'contact support help'],
    ['name' => 'Shop', 'url' => '/shop', 'keywords' => 'shop store products buy'],
    ['name' => 'Customer Reviews', 'url' => '/customer-reviews', 'keywords' => 'reviews testimonials feedback'],
    ['name' => 'Our Partners', 'url' => '/our-partners', 'keywords' => 'partners affiliates collaborations'],
    ['name' => 'Promo Offers', 'url' => '/promo', 'keywords' => 'promo offers deals discounts'],
    ['name' => 'Micro Services', 'url' => '/micro-services', 'keywords' => 'micro services extra additional'],
    ['name' => 'Retail Businesses', 'url' => '/retail-businesses', 'keywords' => 'retail store shop'],
    ['name' => 'Restaurant - Counter Service', 'url' => '/counter-service-restaurants', 'keywords' => 'restaurant counter service fast food'],
    ['name' => 'Restaurant - Table Service', 'url' => '/table-service-restaurants', 'keywords' => 'restaurant table service dining'],
    ['name' => 'Service Businesses', 'url' => '/service-business', 'keywords' => 'service business professional'],
    ['name' => 'Ecommerce Businesses', 'url' => '/ecommerce-businesses', 'keywords' => 'ecommerce online shopping'],
];

$results = [];
$query_lower = strtolower($query);
$productCount = 0;
$pageCount = 0;

// Search shop products (from hardcoded array)
$limit = $searchProductsOnly ? 10 : 5;
foreach ($shopProducts as $product) {
    if (stripos($product['name'], $query) !== false) {
        $results[] = [
            'id' => 'product_' . $product['id'],
            'name' => htmlspecialchars($product['name']),
            'image' => $product['image'],
            'link' => $product['link'],
            'type' => 'product'
        ];
        $productCount++;
        
        if ($productCount >= $limit) break;
    }
}

// Search pages (only if searchProductsOnly is false)
if (!$searchProductsOnly) {
    foreach ($pages as $page) {
        $searchText = strtolower($page['name'] . ' ' . $page['keywords']);
        if (strpos($searchText, $query_lower) !== false) {
            $results[] = [
                'id' => 'page_' . $page['url'],
                'name' => $page['name'],
                'image' => $base_url . '/assets/images/logo/optimum-navLogo.webp',
                'link' => $base_url . $page['url'],
                'type' => 'page'
            ];
            $pageCount++;
        }
        
        // Limit total results
        if (count($results) >= 10) break;
    }
}

echo json_encode([
    'results' => $results,
    'counts' => [
        'products' => $productCount,
        'pages' => $pageCount,
        'total' => count($results)
    ]
]);
?>