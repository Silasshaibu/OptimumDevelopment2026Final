<?php
require_once 'config.php';

// Get the URI path
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

// If running on localhost, strip project folder
if (str_contains($_SERVER['HTTP_HOST'], 'localhost')) {
    $baseFolder = trim(dirname($_SERVER['SCRIPT_NAME']), '/');
    if ($baseFolder && str_starts_with($uri, $baseFolder)) {
        $uri = trim(substr($uri, strlen($baseFolder)), '/');
    }
}

// Default page
$page = $uri === '' ? 'home' : $uri;

// ✅ PAGE TITLES
$pageTitles = [
    '404' => 'Page Not Found',
    'about' => 'About Us',
    'business-financing' => 'Business Financing',
    'clover-flex' => 'Clover Flex',
    'clover-go' => 'Clover Go',
    'clover-mini' => 'Clover Mini',
    'clover-station-duo' => 'Clover Station Duo',
    'clover-station-solo' => 'Clover Station Solo',
    'contact-us' => 'Contact Us',
    'counter-service-restaurants' => 'Counter Service Restaurants',
    'customer-reviews' => 'Customer Reviews',
    'digital-services-brief-submit' => 'Digital Services Brief Submit',
    'digital-services' => 'Digital Services',
    'ecommerce-businesses' => 'Ecommerce Businesses',
    'home' => 'Home',
    'hyfin' => 'Hyfin',
    'merchant-application' => 'Merchant Application',
    'micro-services' => 'Micro Services',
    'nmi' => 'NMI',
    'octopos' => 'Octopos',
    'our-partners' => 'Our Partners',
    'privacy-policy' => 'Privacy Policy',
    'processing-solutions' => 'Processing Solutions',
    'promo' => 'Promo',
    'rectangle' => 'Rectangle',
    'retail-businesses' => 'Retail Businesses',
    'service-business' => 'Service Business',
    'shop' => 'Shop',
    'shop-product' => 'Product Details',
    'swipe-simple' => 'Swipe Simple',
    'tabit' => 'Tabit',
    'table-service-restaurants' => 'Table Service Restaurants',
    'terminal' => 'Terminal',
    'union' => 'Union',
    'valor-vl100' => 'Valor VL100',
    'valor-vl110' => 'Valor VL110',
    'valor-vp100' => 'Valor VP100',
    'valor-vp550' => 'Valor VP550',
    'valor-vp800' => 'Valor VP800',
];

// ✅ PAGE DESCRIPTIONS
$pageDescriptions = [
    '404' => 'Sorry, the page you are looking for could not be found. Explore our payment solutions and POS systems at Optimum Payment Solutions.',
    'about' => 'Learn about Optimum Payment Solutions, a leading provider of payment processing, POS systems, and business financing for merchants.',
    'business-financing' => 'Explore business financing options to grow your operations with flexible payment solutions from Optimum Payment Solutions.',
    'clover-flex' => 'Discover the Clover Flex POS system: a portable, all-in-one device for secure payments, inventory, and customer management.',
    'clover-go' => 'The Clover Go POS system offers wireless payment processing for small businesses, with easy setup and reliable performance.',
    'clover-mini' => 'Clover Mini POS system: compact, powerful, and ideal for countertop use in restaurants, retail, and service businesses.',
    'clover-station-duo' => 'Clover Station Duo: dual-screen POS for efficient order management, payments, and customer service in busy environments.',
    'clover-station-solo' => 'Clover Station Solo: single-screen POS system designed for quick transactions and seamless integration with apps.',
    'contact-us' => 'Get in touch with Optimum Payment Solutions for inquiries about POS systems, payment processing, and merchant services.',
    'counter-service-restaurants' => 'Optimize counter service in restaurants with our POS solutions, including Clover and Valor systems for fast, accurate orders.',
    'customer-reviews' => 'Read real customer reviews of Optimum Payment Solutions\' POS systems and payment services.',
    'digital-services-brief-submit' => 'Submit your digital services brief to get customized solutions for your business needs.',
    'digital-services' => 'Explore digital services including payment integration, e-commerce tools, and POS software from Optimum Payment Solutions.',
    'ecommerce-businesses' => 'Tailored POS and payment solutions for e-commerce businesses to streamline online and in-store transactions.',
    'home' => 'Welcome to Optimum Payment Solutions. Discover top POS systems like Clover, Valor, and more for your business payment needs.',
    'hyfin' => 'Hyfin payment solutions: secure, scalable options for businesses seeking reliable transaction processing.',
    'merchant-application' => 'Apply for merchant services with Optimum Payment Solutions and start accepting payments today.',
    'micro-services' => 'Micro-services for modular payment processing, allowing flexible integration with your existing systems.',
    'nmi' => 'NMI payment gateway: trusted for secure, PCI-compliant transactions and POS integrations.',
    'octopos' => 'Octopos POS system: advanced features for inventory, reporting, and customer loyalty programs.',
    'our-partners' => 'Meet our partners at Optimum Payment Solutions, including leading POS manufacturers and payment providers.',
    'privacy-policy' => 'Read our privacy policy to understand how Optimum Payment Solutions protects your data and ensures compliance.',
    'processing-solutions' => 'Comprehensive payment processing solutions for businesses, including gateways, POS, and financing options.',
    'promo' => 'Check out current promotions on POS systems and payment solutions from Optimum Payment Solutions.',
    'rectangle' => 'Rectangle POS system: sleek design with powerful features for modern businesses.',
    'retail-businesses' => 'POS solutions tailored for retail businesses, enhancing sales, inventory, and customer experiences.',
    'service-business' => 'Payment and POS solutions for service-based businesses, from salons to professional services.',
    'shop' => 'Shop our selection of POS systems, terminals, and accessories at Optimum Payment Solutions.',
    'shop-product' => 'View product details, features, and purchase options for POS supplies and accessories.',
    'swipe-simple' => 'Swipe Simple: easy-to-use payment terminals for quick, secure transactions.',
    'tabit' => 'Tabit POS for restaurants: table management, ordering, and payment integration in one platform.',
    'table-service-restaurants' => 'Enhance table service in restaurants with our POS systems, including order tracking and payment processing.',
    'terminal' => 'Explore payment terminals from Optimum Payment Solutions, compatible with various POS systems.',
    'union' => 'Union payment solutions: reliable tools for businesses needing robust transaction processing.',
    'valor-vl100' => 'Valor VL100 POS system: compact and efficient for small to medium businesses.',
    'valor-vl110' => 'Valor VL110: advanced POS with touchscreen interface for streamlined operations.',
    'valor-vp100' => 'Valor VP100: versatile POS terminal for payments, inventory, and reporting.',
    'valor-vp550' => 'Valor VP550: high-performance POS for demanding retail and restaurant environments.',
    'valor-vp800' => 'Valor VP800: premium POS system with extensive features for large-scale operations.',
];

// ✅ PAGE KEYWORDS
$pageKeywords = [
    '404' => 'page not found, error 404, payment solutions',
    'about' => 'about us, company, payment solutions, POS systems',
    'business-financing' => 'business financing, loans, payment processing',
    'clover-flex' => 'Clover Flex, POS system, portable POS, payment device',
    'clover-go' => 'Clover Go, wireless POS, small business POS',
    'clover-mini' => 'Clover Mini, countertop POS, restaurant POS',
    'clover-station-duo' => 'Clover Station Duo, dual screen POS, order management',
    'clover-station-solo' => 'Clover Station Solo, single screen POS, quick transactions',
    'contact-us' => 'contact, support, payment solutions, POS inquiry',
    'counter-service-restaurants' => 'counter service, restaurants, POS systems, Clover',
    'customer-reviews' => 'reviews, testimonials, customer feedback, POS systems',
    'digital-services-brief-submit' => 'digital services, brief submit, customization',
    'digital-services' => 'digital services, e-commerce, POS software',
    'ecommerce-businesses' => 'e-commerce, online payments, POS solutions',
    'home' => 'home, payment solutions, POS systems, Clover, Valor',
    'hyfin' => 'Hyfin, payment solutions, transaction processing',
    'merchant-application' => 'merchant application, sign up, payment services',
    'micro-services' => 'micro-services, modular payments, integration',
    'nmi' => 'NMI, payment gateway, PCI compliant',
    'octopos' => 'Octopos, POS system, inventory, reporting',
    'our-partners' => 'partners, collaborations, POS manufacturers',
    'privacy-policy' => 'privacy policy, data protection, compliance',
    'processing-solutions' => 'payment processing, gateways, POS',
    'promo' => 'promotions, discounts, POS deals',
    'rectangle' => 'Rectangle POS, sleek design, business tools',
    'retail-businesses' => 'retail POS, sales, inventory management',
    'service-business' => 'service business, POS solutions, payments',
    'shop' => 'shop, POS systems, terminals, accessories',
    'shop-product' => 'product details, POS supplies, accessories, buy now',
    'swipe-simple' => 'Swipe Simple, payment terminals, secure transactions',
    'tabit' => 'Tabit, restaurant POS, table management',
    'table-service-restaurants' => 'table service, restaurants, POS systems',
    'terminal' => 'payment terminals, POS hardware, Clover, Valor',
    'union' => 'Union, payment solutions, transaction tools',
    'valor-vl100' => 'Valor VL100, compact POS, small business',
    'valor-vl110' => 'Valor VL110, touchscreen POS, operations',
    'valor-vp100' => 'Valor VP100, versatile POS, payments, inventory',
    'valor-vp550' => 'Valor VP550, high-performance POS, retail',
    'valor-vp800' => 'Valor VP800, premium POS, large operations',
];


// Set title (fallback to formatted page name)
$title = $pageTitles[$page]
    ?? ucwords(str_replace('-', ' ', $page));

// Build content path
$content = __DIR__ . "/main/{$page}.php";

// 404 fallback
if (!file_exists($content)) {
    http_response_code(404);
    $page = '404';
    $title = 'Page Not Found';
    $content = __DIR__ . "/main/404.php";
    // Load 404 page directly without layout
    include $content;
    exit;
}

// Load layout (this loads header.php)
require __DIR__ . '/templates/layout.php';
