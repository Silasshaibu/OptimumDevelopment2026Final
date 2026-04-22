# E-commerce Product Management System

## Overview
Complete product management system for Optimum Payments with admin interface and frontend display.

## Features
- ✅ Add, Edit, Delete products
- ✅ Upload product images
- ✅ Set products as affiliate with links
- ✅ Categorize products (Shop, Top Selling, Handheld, Supplies)
- ✅ Frontend product display pages
- ✅ Active/Inactive product status
- ✅ Display order management
- ✅ Stock quantity tracking

## Installation

### 1. Create Database Table
Run the SQL script to create the products table:

```bash
mysql -u root -p optimum_payments < _system/create_products_table.sql
```

Or manually execute the SQL in phpMyAdmin:
- Open phpMyAdmin: http://localhost/phpmyadmin
- Select your database
- Go to SQL tab
- Copy and paste contents from `_system/create_products_table.sql`
- Click "Go"

### 2. Create Upload Directory
The system will auto-create the directory, but you can manually create it:

```
mywebsite/assets/images/products/
```

Make sure it has write permissions.

## Admin Access

### Admin Dashboard
Access: `http://localhost/mywebsite/_system/admin/`

### Product Management Pages
- **Shop (Affiliate)**: `http://localhost/mywebsite/_system/admin/shop.php`
- **Top Selling Products**: `http://localhost/mywebsite/_system/admin/top_selling_products.php`
- **Handheld Devices**: `http://localhost/mywebsite/_system/admin/handheld_devices.php`
- **Supplies**: `http://localhost/mywebsite/_system/admin/supplies.php`

### Add/Edit Products
1. Click on any category in the Ecommerce submenu
2. Click "Add New Product" button
3. Fill in product details:
   - **Name**: Required
   - **Description**: Optional
   - **Price**: Optional (use $0.00 for "Contact for Price")
   - **Stock Quantity**: For inventory tracking
   - **Display Order**: Lower numbers appear first
   - **Is Affiliate**: Check if it's an affiliate product
   - **Affiliate Link**: External link to product page
   - **Image**: Upload or provide URL
   - **Active**: Uncheck to hide from frontend

4. Click "Add Product" or "Update Product"

## Frontend Display

### Public Product Pages
- **Shop**: `http://localhost/mywebsite/main/shop-products.php`
- **Top Selling**: `http://localhost/mywebsite/main/top-selling-products.php`
- **Handheld Devices**: `http://localhost/mywebsite/main/handheld-devices.php`
- **Supplies**: `http://localhost/mywebsite/main/supplies-products.php`

## Image Upload

### Two Methods:
1. **File Upload**: Choose image file from your computer (JPG, PNG, GIF, WEBP)
2. **URL Input**: Paste image URL from external source

### Image Guidelines:
- Recommended size: 800x800px or larger
- Accepted formats: JPG, JPEG, PNG, GIF, WEBP
- Max file size: 5MB
- Images stored in: `/assets/images/products/`

## Affiliate Products

When marking a product as affiliate:
1. Check "This is an affiliate product"
2. Enter the affiliate link (must start with http:// or https://)
3. When customers click "Buy Now", they'll be redirected to your affiliate link
4. Affiliate badge will be displayed on product card

## Product Categories

### Shop (Affiliate)
General products available through affiliate partnerships

### Top Selling Products
Highlight your most popular items across all categories

### Handheld Devices
Mobile payment terminals, card readers, portable POS systems

### Supplies
Receipt paper, cases, accessories, consumables

## Customization

### Product Card Display
Edit: `_system/product_helpers.php` - `displayProductCard()` function

### Product Styles
Edit: `assets/css/products.css`

### Admin Styles
Edit: `_system/admin/admin-style.css`

## Database Structure

```sql
products (
    id - Auto increment primary key
    name - Product name (required)
    description - Product description
    price - Product price (decimal)
    category - shop, top_selling, handheld, supplies
    is_affiliate - Boolean (0 or 1)
    affiliate_link - External URL
    image_url - Image path or URL
    stock_quantity - Integer
    is_active - Boolean (0 or 1)
    display_order - Integer (for sorting)
    created_at - Timestamp
    updated_at - Timestamp
)
```

## Tips

1. **Display Order**: Use multiples of 10 (10, 20, 30) to easily insert items between existing products
2. **Inactive Products**: Set to inactive instead of deleting to preserve order history
3. **Categories**: Products can belong to multiple categories by duplicating them
4. **Affiliate Links**: Always include tracking parameters in your affiliate URLs
5. **Images**: Use consistent image dimensions for better display

## Troubleshooting

### Images Not Uploading
- Check folder permissions: `chmod 777 assets/images/products/`
- Verify file size is under 5MB
- Check PHP settings: `upload_max_filesize` and `post_max_size`

### Products Not Displaying
- Verify product is marked as "Active"
- Check category assignment
- Clear browser cache

### Database Errors
- Ensure table was created successfully
- Check database connection in `_system/db.php`
- Verify column names match code

## Next Steps

1. Add products to each category
2. Upload product images
3. Set affiliate links
4. Test frontend display
5. Adjust display order
6. Promote product pages on your site

## Support

For issues or questions, check:
- Database connection: `_system/db.php`
- Error logs: XAMPP Control Panel → Apache Logs
- PHP errors: Enable error reporting in php.ini
