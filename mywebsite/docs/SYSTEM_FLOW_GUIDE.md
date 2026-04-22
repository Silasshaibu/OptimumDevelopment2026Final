# 🎯 Product Management System - Visual Flow

## System Architecture

```
┌─────────────────────────────────────────────────────────────────┐
│                        ADMIN DASHBOARD                          │
│  http://localhost/mywebsite/_system/admin/                      │
└─────────────────────────────────────────────────────────────────┘
                               │
                               ├── Click "Ecommerce" Tab
                               │
                    ┌──────────┴──────────┐
                    │   SUBMENU OPENS     │
                    └──────────┬──────────┘
                               │
        ┌──────────────────────┼──────────────────────┐
        │                      │                      │
        ▼                      ▼                      ▼
    ┌───────┐          ┌──────────────┐       ┌───────────┐
    │ Shop  │          │Top Selling   │       │ Handheld  │
    │       │          │Products      │       │ Devices   │
    └───┬───┘          └──────┬───────┘       └─────┬─────┘
        │                     │                      │
        └──────────────┬──────┴──────────────────────┘
                       │                      ┌───────────┐
                       │                      │ Supplies  │
                       │                      └─────┬─────┘
                       ▼                            │
            ┌──────────────────┐                   │
            │   PRODUCT LIST   │◄──────────────────┘
            │  - View All      │
            │  - Add Button    │
            │  - Edit/Delete   │
            └────────┬─────────┘
                     │
        ┌────────────┴────────────┐
        │                         │
        ▼                         ▼
┌────────────┐            ┌──────────────┐
│  ADD/EDIT  │            │   DELETE     │
│  PRODUCT   │            │   PRODUCT    │
│            │            │              │
│ - Name     │            │ Confirmation │
│ - Desc     │            │ Required     │
│ - Price    │            └──────────────┘
│ - Image    │
│ - Affiliate│
│ - Active   │
└─────┬──────┘
      │
      ▼
┌────────────────┐
│   DATABASE     │
│   products     │
│   table        │
└────────┬───────┘
         │
         ▼
┌─────────────────────────────────────────────────────────────────┐
│                       FRONTEND DISPLAY                          │
│  http://localhost/mywebsite/main/                               │
│                                                                  │
│  - shop-products.php                                            │
│  - top-selling-products.php                                     │
│  - handheld-devices.php                                         │
│  - supplies-products.php                                        │
└─────────────────────────────────────────────────────────────────┘
```

## Data Flow

```
┌────────────┐
│   ADMIN    │
│  Uploads   │
│  Product   │
└──────┬─────┘
       │
       ▼
┌──────────────────┐
│  Product Form    │
│  - Validation    │
│  - Image Upload  │
│  - Sanitization  │
└────────┬─────────┘
         │
         ▼
┌──────────────────────────┐
│  Image Processing        │
│  - Save to disk          │
│  - /assets/images/       │
│    products/             │
│  OR                      │
│  - Store URL directly    │
└────────┬─────────────────┘
         │
         ▼
┌──────────────────────────┐
│  Database Insert/Update  │
│  - Prepared statement    │
│  - All fields saved      │
│  - Timestamps updated    │
└────────┬─────────────────┘
         │
         ▼
┌──────────────────────────┐
│  Frontend Query          │
│  WHERE category = ?      │
│  AND is_active = 1       │
│  ORDER BY display_order  │
└────────┬─────────────────┘
         │
         ▼
┌──────────────────────────┐
│  Product Card Display    │
│  - Image                 │
│  - Name & Description    │
│  - Price                 │
│  - Buy Button            │
│  - Affiliate Badge       │
└──────────────────────────┘
```

## User Journey

### ADMIN JOURNEY
```
1. Login → Admin Dashboard
   └─→ See sidebar menu

2. Click "Ecommerce" tab
   └─→ Submenu expands showing 4 options

3. Select category (e.g., "Shop")
   └─→ See list of products

4. Click "Add New Product"
   └─→ Fill out form
       ├─→ Enter product details
       ├─→ Upload/URL image
       ├─→ Set affiliate status & link
       └─→ Save

5. Product appears in list
   └─→ Can edit or delete anytime

6. Make product active
   └─→ Appears on frontend immediately
```

### CUSTOMER JOURNEY
```
1. Visit website
   └─→ Browse products page

2. See product grid
   ├─→ Product images
   ├─→ Names & descriptions
   ├─→ Prices
   └─→ "Buy Now" buttons

3. Click "Buy Now"
   └─→ If affiliate: Redirect to affiliate link
       └─→ Opens in new tab

4. Customer completes purchase
   └─→ You earn commission!
```

## Category Breakdown

```
┌─────────────────────────────────────────────────────────┐
│                    ECOMMERCE MENU                       │
└─────────────────────────────────────────────────────────┘
                         │
         ┌───────────────┼───────────────┐
         │               │               │
         ▼               ▼               ▼
    ┌────────┐     ┌──────────┐    ┌──────────┐
    │  SHOP  │     │   TOP    │    │ HANDHELD │
    │        │     │ SELLING  │    │ DEVICES  │
    └────────┘     └──────────┘    └──────────┘
         │               │               │
         │               │               ▼
         │               │          ┌──────────┐
         │               │          │ SUPPLIES │
         │               │          └──────────┘
         │               │               │
         ▼               ▼               ▼
    All affiliate   Featured         Portable
    products        best sellers     terminals
                                    & readers
```

## File Relationships

```
Admin Pages ──────────┐
shop.php              │
top_selling_products  ├──→ Includes ──→ admin-layout.php
handheld_devices.php  │                 (sidebar menu)
supplies.php ─────────┘

Product Forms ────────┐
product_add.php       ├──→ Uses ──→ db.php
product_edit.php ─────┘             (database)

Frontend Pages ───────┐
shop-products.php     │
top-selling-products  ├──→ Includes ──→ product_helpers.php
handheld-devices.php  │                 (display functions)
supplies-products.php─┘

Styles ───────────────┐
admin-style.css       ├──→ Imported by ──→ Admin pages
products.css ─────────┘                   Frontend pages
```

## Quick Reference

### Admin URLs
```
Dashboard:    /mywebsite/_system/admin/
Shop:         /mywebsite/_system/admin/shop.php
Top Selling:  /mywebsite/_system/admin/top_selling_products.php
Handheld:     /mywebsite/_system/admin/handheld_devices.php
Supplies:     /mywebsite/_system/admin/supplies.php
Add Product:  /mywebsite/_system/admin/product_add.php?category=shop
Edit Product: /mywebsite/_system/admin/product_edit.php?id=1
```

### Frontend URLs
```
Shop:         /mywebsite/main/shop-products.php
Top Selling:  /mywebsite/main/top-selling-products.php
Handheld:     /mywebsite/main/handheld-devices.php
Supplies:     /mywebsite/main/supplies-products.php
```

### Database
```
Table:     products
Columns:   id, name, description, price, category,
           is_affiliate, affiliate_link, image_url,
           stock_quantity, is_active, display_order,
           created_at, updated_at
```

### Image Storage
```
Upload Directory: /mywebsite/assets/images/products/
Placeholder:      /mywebsite/assets/images/placeholder-product.svg
Format:          product_[UNIQUE_ID].[extension]
Max Size:        5MB
Types:           JPG, JPEG, PNG, GIF, WEBP
```

## Success Metrics

Track these in your analytics:
- ✅ Products added
- ✅ Categories populated
- ✅ Affiliate links clicked
- ✅ Page views on product pages
- ✅ Time spent on product pages
- ✅ Conversion to affiliate sites

---

**Next Step**: Run http://localhost/mywebsite/_system/setup_products.php
