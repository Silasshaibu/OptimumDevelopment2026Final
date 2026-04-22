
    <!-- Singular Page Hero Banner -->
    <section class="singular-page-hero">
        <div class="singular-page-hero__inner">
            <div class="singular-page-hero__content">
                <h1 class="singular-page-hero__title"><?= htmlspecialchars($title ?? '') ?></h1>
                <?php if (!empty($pageDescriptions[$page])): ?>
                    <p class="singular-page-hero__desc"><?= htmlspecialchars($pageDescriptions[$page]) ?></p>
                <?php endif; ?>
                <nav class="singular-page-hero__breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= $base_url ?>/">Home</a>
                    <span class="singular-page-hero__breadcrumb-sep">&#8250;</span>
                    <span><?= htmlspecialchars($title ?? '') ?></span>
                </nav>
            </div>
        </div>
    </section>
