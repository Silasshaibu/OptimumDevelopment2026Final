<?php
require_once 'config.php';

// Get the URI path
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// Strip project folder prefix when running on localhost
if (str_contains($_SERVER['HTTP_HOST'], 'localhost')) {
    $baseFolder = trim(dirname($_SERVER['SCRIPT_NAME']), '/');
    if ($baseFolder && str_starts_with($uri, $baseFolder)) {
        $uri = trim(substr($uri, strlen($baseFolder)), '/');
    }
}

// Default to home
$page = $uri === '' ? 'home' : $uri;

// ✅ PAGE TITLES
$pageTitles = [
    '404'                          => 'Page Not Found',
    'about'                        => 'About Us',
    'business-financing'           => 'Business Financing',
    'clover-flex'                  => 'Clover Flex',
    'clover-go'                    => 'Clover Go',
    'clover-mini'                  => 'Clover Mini',
    'clover-station-duo'           => 'Clover Station Duo',
    'clover-station-solo'          => 'Clover Station Solo',
    'contact-us'                   => 'Contact Us',
    'counter-service-restaurants'  => 'Counter Service Restaurants',
    'customer-reviews'             => 'Customer Reviews',
    'digital-services-brief-submit'=> 'Digital Services Brief Submit',
    'digital-services'             => 'Digital Services',
    'ecommerce-businesses'         => 'Ecommerce Businesses',
    'home'                         => 'Home',
    'hyfin'                        => 'Hyfin',
    'merchant-application'         => 'Merchant Application',
    'micro-services'               => 'Micro Services',
    'nmi'                          => 'NMI',
    'octopos'                      => 'Octopos',
    'our-partners'                 => 'Our Partners',
    'privacy-policy'               => 'Privacy Policy',
    'processing-solutions'         => 'Processing Solutions',
    'promo'                        => 'Promo',
    'rectangle'                    => 'Rectangle',
    'retail-businesses'            => 'Retail Businesses',
    'service-business'             => 'Service Business',
    'shop'                         => 'Shop',
    'shop-product'                 => 'Product Details',
    'swipe-simple'                 => 'Swipe Simple',
    'tabit'                        => 'Tabit',
    'table-service-restaurants'    => 'Table Service Restaurants',
    'terminal'                     => 'Terminal',
    'union'                        => 'Union',
    'valor-vl100'                  => 'Valor VL100',
    'valor-vl110'                  => 'Valor VL110',
    'valor-vp100'                  => 'Valor VP100',
    'valor-vp550'                  => 'Valor VP550',
    'valor-vp800'                  => 'Valor VP800',
];

// ✅ PAGE DESCRIPTIONS
$pageDescriptions = [
    '404'                          => 'Sorry, the page you are looking for could not be found.',
    'about'                        => 'Learn about Optimum Payment Solutions, a leading provider of payment processing, POS systems, and business financing for merchants.',
    'business-financing'           => 'Explore business financing options to grow your operations with flexible payment solutions from Optimum Payment Solutions.',
    'clover-flex'                  => 'Discover the Clover Flex POS system: a portable, all-in-one device for secure payments, inventory, and customer management.',
    'clover-go'                    => 'The Clover Go POS system offers wireless payment processing for small businesses, with easy setup and reliable performance.',
    'clover-mini'                  => 'Clover Mini POS system: compact, powerful, and ideal for countertop use in restaurants, retail, and service businesses.',
    'clover-station-duo'           => 'Clover Station Duo: dual-screen POS for efficient order management, payments, and customer service in busy environments.',
    'clover-station-solo'          => 'Clover Station Solo: single-screen POS system designed for quick transactions and seamless integration with apps.',
    'contact-us'                   => 'Get in touch with Optimum Payment Solutions for inquiries about POS systems, payment processing, and merchant services.',
    'counter-service-restaurants'  => 'Optimize counter service in restaurants with our POS solutions.',
    'customer-reviews'             => 'Read real customer reviews of Optimum Payment Solutions POS systems and payment services.',
    'digital-services-brief-submit'=> 'Submit your digital services brief to get customized solutions for your business needs.',
    'digital-services'             => 'Explore digital services including payment integration, e-commerce tools, and POS software.',
    'ecommerce-businesses'         => 'Tailored POS and payment solutions for e-commerce businesses.',
    'home'                         => 'Welcome to Optimum Payment Solutions. Discover top POS systems like Clover, Valor, and more for your business payment needs.',
    'our-partners'                 => 'Meet our partners including leading POS manufacturers and payment providers.',
    'privacy-policy'               => 'Read our privacy policy to understand how Optimum Payment Solutions protects your data.',
    'processing-solutions'         => 'Comprehensive payment processing solutions for businesses.',
    'promo'                        => 'Check out current promotions on POS systems and payment solutions.',
    'shop'                         => 'Shop our selection of POS systems, terminals, and accessories.',
];

// ✅ PAGE KEYWORDS
$pageKeywords = [
    'home'        => 'home, payment solutions, POS systems, Clover, Valor',
    'about'       => 'about us, company, payment solutions, POS systems',
    'shop'        => 'shop, POS systems, terminals, accessories',
    'contact-us'  => 'contact, support, payment solutions, POS inquiry',
    'promo'       => 'promotions, discounts, POS deals',
    'our-partners'=> 'partners, collaborations, POS manufacturers',
];

// Set title (fallback to formatted page name)
$title = $pageTitles[$page] ?? ucwords(str_replace('-', ' ', $page));

// Build content path
$content = __DIR__ . "/main/{$page}.php";

// 404 fallback
if (!file_exists($content)) {
    http_response_code(404);
    $page    = '404';
    $title   = 'Page Not Found';
    $content = __DIR__ . '/main/404.php';
    if (!file_exists($content)) {
        echo '<!DOCTYPE html><html><body><h1>404 – Page Not Found</h1></body></html>';
        exit;
    }
}

// Load master layout
require __DIR__ . '/templates/layout.php';
