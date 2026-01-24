# Aakaari WordPress Theme

Aakaari is a clean, premium WordPress theme built for WooCommerce issue-fix services and maintenance plans.

## Installation

1. Copy the theme folder into `wp-content/themes/aakaari`.
2. In WordPress admin, go to **Appearance → Themes**.
3. Activate **Aakaari**.
4. Optional: Set a static front page and assign the **Homepage** to show the custom hero layout.

## Create the “issues” WooCommerce category

1. Install and activate WooCommerce.
2. Go to **Products → Categories**.
3. Create a new category with the slug `issues`.
4. Add products that represent common fixes (checkout issues, payment issues, speed, etc.).
5. Mark products as **Featured** if you want them to appear when the category is empty.

## Theme Notes

- The home page pulls up to 4 products from the `issues` category.
- If no matching products exist, placeholder cards are shown.
- Front page template is defined in `front-page.php`.
- Main styling lives in `assets/css/main.css`.
