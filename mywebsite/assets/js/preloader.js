/**
 * PRELOADER SYSTEM
 * Handles first-visit preloader, skeleton loaders, asset prioritization, and predictive preloading
 */

(function() {
    'use strict';

    const PreloaderSystem = {
        config: {
            sessionKey: 'site_visited',
            preloaderDuration: 2000, // Minimum display time
            enablePredictivePreload: true,
            hoverDelay: 300 // ms before prefetching on hover
        },

        init() {
            this.checkFirstVisit();
            this.setupAssetPrioritization();
            this.setupPredictivePreloading();
        },

        /**
         * Check if this is the first visit and show appropriate loader
         */
        checkFirstVisit() {
            const hasVisited = sessionStorage.getItem(this.config.sessionKey);
            const preloader = document.querySelector('.page-preloader');

            if (!preloader) return;

            if (hasVisited) {
                // Subsequent visit - hide preloader immediately, show skeleton
                this.hidePreloader(true);
                this.showSkeletonLoaders();
            } else {
                // First visit - show full preloader
                document.body.classList.add('preloader-active');
                this.showFullPreloader();
                sessionStorage.setItem(this.config.sessionKey, 'true');
            }
        },

        /**
         * Show full-screen preloader with progress
         */
        showFullPreloader() {
            const progressBar = document.querySelector('.preloader-progress-bar');
            let progress = 0;
            const startTime = Date.now();

            // Simulate progress
            const progressInterval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress > 90) progress = 90; // Cap at 90% until fully loaded
                
                if (progressBar) {
                    progressBar.style.width = progress + '%';
                }
            }, 200);

            // Wait for page load
            window.addEventListener('load', () => {
                clearInterval(progressInterval);
                
                if (progressBar) {
                    progressBar.style.width = '100%';
                }

                const elapsedTime = Date.now() - startTime;
                const remainingTime = Math.max(0, this.config.preloaderDuration - elapsedTime);

                setTimeout(() => {
                    this.hidePreloader();
                }, remainingTime);
            });

            // Fallback - hide after max time even if not loaded
            setTimeout(() => {
                clearInterval(progressInterval);
                this.hidePreloader();
            }, 5000);
        },

        /**
         * Hide the preloader
         */
        hidePreloader(immediate = false) {
            const preloader = document.querySelector('.page-preloader');
            if (!preloader) return;

            if (immediate) {
                preloader.style.display = 'none';
            } else {
                preloader.classList.add('hidden');
                setTimeout(() => {
                    preloader.style.display = 'none';
                    document.body.classList.remove('preloader-active');
                }, 500);
            }
        },

        /**
         * Show skeleton loaders for subsequent visits
         */
        showSkeletonLoaders() {
            // This would be implemented in the page templates
            // For now, just hide them when content loads
            window.addEventListener('load', () => {
                setTimeout(() => {
                    document.body.classList.add('content-loaded');
                }, 300);
            });
        },

        /**
         * Setup asset prioritization - defer heavy assets
         */
        setupAssetPrioritization() {
            if ('requestIdleCallback' in window) {
                // Defer non-critical scripts
                requestIdleCallback(() => {
                    this.loadDeferredAssets();
                });
            } else {
                // Fallback for browsers without requestIdleCallback
                setTimeout(() => {
                    this.loadDeferredAssets();
                }, 1000);
            }
        },

        /**
         * Load deferred assets when browser is idle
         */
        loadDeferredAssets() {
            const deferredScripts = document.querySelectorAll('script[data-defer="true"]');
            const deferredStyles = document.querySelectorAll('link[data-defer="true"]');

            deferredScripts.forEach(script => {
                const newScript = document.createElement('script');
                newScript.src = script.getAttribute('data-src');
                newScript.async = true;
                document.body.appendChild(newScript);
            });

            deferredStyles.forEach(link => {
                link.rel = 'stylesheet';
                link.href = link.getAttribute('data-href');
            });
        },

        /**
         * Setup predictive preloading based on user behavior
         */
        setupPredictivePreloading() {
            if (!this.config.enablePredictivePreload) return;

            const links = document.querySelectorAll('a[href^="/"]:not([href*="mailto"]):not([href*="tel"])');
            const prefetchedUrls = new Set();
            let hoverTimeout;

            links.forEach(link => {
                // Prefetch on hover (with delay to avoid unnecessary prefetches)
                link.addEventListener('mouseenter', () => {
                    hoverTimeout = setTimeout(() => {
                        this.prefetchPage(link.href, prefetchedUrls);
                    }, this.config.hoverDelay);
                });

                link.addEventListener('mouseleave', () => {
                    clearTimeout(hoverTimeout);
                });

                // High priority prefetch on mousedown (before click completes)
                link.addEventListener('mousedown', () => {
                    this.prefetchPage(link.href, prefetchedUrls, true);
                });

                // Touch events for mobile
                link.addEventListener('touchstart', () => {
                    this.prefetchPage(link.href, prefetchedUrls, true);
                }, { passive: true });
            });
        },

        /**
         * Prefetch a page for faster navigation
         */
        prefetchPage(url, prefetchedUrls, highPriority = false) {
            // Skip if already prefetched or external link
            if (prefetchedUrls.has(url) || !url.startsWith(window.location.origin)) {
                return;
            }

            // Create prefetch link
            const link = document.createElement('link');
            link.rel = highPriority ? 'prerender' : 'prefetch';
            link.href = url;
            link.as = 'document';

            document.head.appendChild(link);
            prefetchedUrls.add(url);

            // Clean up after some time to avoid memory issues
            setTimeout(() => {
                link.remove();
            }, 30000);
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => PreloaderSystem.init());
    } else {
        PreloaderSystem.init();
    }

    // Expose to window for debugging
    window.PreloaderSystem = PreloaderSystem;

})();
