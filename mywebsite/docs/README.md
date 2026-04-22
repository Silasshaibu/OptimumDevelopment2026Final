# Deployment notes


1. Upload all files to your `public_html` (or server document root).
2. Ensure `AllowOverride All` is enabled (Apache) so `.htaccess` works.
3. If your site is in a subfolder, add `RewriteBase /subfolder/` to `.htaccess`.
4. For security, keep any sensitive configuration (DB credentials) in a separate file outside webroot if possible.
5. Test 404 handling by visiting a non-existent URL.