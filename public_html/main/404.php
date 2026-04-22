<?php
// main/404.php — Not Found page
http_response_code(404);
?>

<section class="error-page">
    <div class="error-page__inner">
        <div class="error-page__code">404</div>
        <h1 class="error-page__title">Page Not Found</h1>
        <p class="error-page__desc">The page you're looking for doesn't exist or has been moved.</p>
        <a href="<?= $base_url ?>/" class="error-page__cta">Back to Home</a>
    </div>
</section>
