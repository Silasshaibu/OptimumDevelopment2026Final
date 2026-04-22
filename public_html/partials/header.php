<?php require_once __DIR__ . '/../config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Home') ?> | Optimum Payment Solutions</title>
    <meta name="description" content="<?= htmlspecialchars($pageDescriptions[$page] ?? 'Discover top payment solutions and POS systems from Optimum Payment Solutions.') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($pageKeywords[$page] ?? 'payment solutions, POS systems, Clover, Valor') ?>">
    <meta name="robots" content="index, follow">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/SearchField_SearchResult.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/footer.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/testimonialForm.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/testimonial-review.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/ourpartners-section.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/supplies.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/billBoard-supplies.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/handHeldDevices.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/topSellingProd.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/billBoard-handhelddevices.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/powerfulCapabilies.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/megamenu.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/minimenu.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/mobileNavigationMenu.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/homeHero.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/topInfoBar.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/topAdvertBar.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/cookie-banner.css">
</head>
<body>
