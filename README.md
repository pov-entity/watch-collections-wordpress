# Watch Collections — WordPress + WooCommerce Theme

**Status:** Prototype v0.1.0. Not a live store. Brand name is a working title.

A custom responsive WordPress classic theme for a multi-brand everyday watch collection store. The repository root is the installable theme, for direct use with the **WordPress Playground → From GitHub** importer.

## Open in WordPress Playground

1. Go to https://playground.wordpress.net/
2. Select New → From GitHub.
3. Paste https://github.com/pov-entity/watch-collections-wordpress (without .git).
4. Choose **Theme**, and the root directory **/** if requested.
5. Press Continue, then check the homepage. If not active, go to Appearance → Themes → Watch Collections → Activate.
6. Optional: install and activate WooCommerce from WordPress Admin → Plugins to test product pages.
7. Save your Playground using **Store permanently** and regularly **Export → Download as .zip**. Browser storage is not a reliable external backup.

**Playground is a sandbox**, not a live checkout host. WooCommerce payments, email, cron, taxes, security, and webhooks must be tested again after migrating to paid WordPress hosting.

## Code layout

- style.css: required WordPress theme metadata
- functions.php: setup, styles/scripts, menu locations, WooCommerce support
- header.php / footer.php: navigation and brand shell
- front-page.php: custom homepage with product integration when WooCommerce contains products
- index.php / page.php / single.php / archive.php / 404.php: WordPress templates
- woocommerce.php: WooCommerce wrapper
- theme.json: editorial colors and block design settings
- assets/css/site.css: responsive layouts and watch concept illustrations
- assets/js/site.js: accessible mobile navigation

## Built now

Original everyday-watch homepage, mobile responsive navigation, stylized concept watch illustrations, watch occasion sections, planned collection-building explanation, placeholder product area, WooCommerce support, pages and blog archive templates.

## Not built yet

Interactive watch-box builder, configurable collection sizes, cart rules, packaging options, prices, supplier photography, product descriptions, legal pages, international shipping policies, operational payments, and real customer checkout. The homepage clearly labels conceptual product visuals.

**Do not accept real customer payments before full testing and legal/commercial details.**

## Development roadmap

1. Finalize logo, naming, brand palette and homepage.
2. Add real WooCommerce watch SKUs with accurate specifications, variant data and stock.
3. Build the box builder as a **separate plugin** using WooCommerce server-side cart and price validation.
4. Add packaging, tested bundle prices and accurate shipping/returns/legal pages.
5. Stress-test on desktop/mobile; migrate theme + database/uploads to paid hosting.
6. Verify live payments, taxes, order emails, webhooks, backups and speed after migration.

## Install on paid/local WordPress

Copy the repository folder to wp-content/themes/watch-collections-wordpress/ and activate it under Appearance → Themes. The GitHub repository only stores the theme; WordPress page content, WooCommerce products, media, and settings live in the database and uploads and need separate backups.

## Security and credibility

This public repository must never include WordPress credentials, API keys, private supplier records, .env secrets, order records, customer information, or production database dumps. Do not invent reviews, delivery guarantees, endorsements, certifications, or policy terms. Pricing should be validated and configurable rather than coded into the theme.

License: GPL-2.0-or-later.

## Homepage update v0.2.0 (October 2026)

The homepage now leads with a clear collection-building proposition, black/ivory/walnut editorial direction, a conceptual 3-watch box illustration, five style categories, a true front-end **1 / 3 / 5 / 7 slot interactive box preview**, visible proposed prices ($160 / $299 / $499 / $639), and explicit preview-only / unverified-product disclosures. All page interactions are client-side demos; no cart, payments, or customer data are collected. The package selection and price display do not create WooCommerce products or orders. CSS/JS live in assets/css/home.css and assets/js/home.js, loaded only on the front page.

### Homepage QA before launch

- Test all four package selections and correct box slot counts and package totals.
- Test iPhone and desktop layouts, nav, tap targets, focus-visible, and reduced-motion preferences.
- Replace conceptual box/watch visuals with verified supplier photos before real product listings.
- Replace copy/promises when exact box dimensions, taxes, shipping and warranty terms are confirmed.
- Build the actual watch selector in a separate plugin with server-side cart validation.
