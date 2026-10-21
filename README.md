# Watch Collections — WordPress + WooCommerce Theme

**Status:** Prototype v0.4.0. Not a live store. Brand name is a working title.

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


## Seven-day homepage hero (v0.3.0)

The homepage now opens with a cinematic seven-day visual sequence:
- Monday Classic; Tuesday Chronograph; Wednesday Minimal; Thursday Moonphase-inspired; Friday Dress; Saturday Sport; Sunday Skeleton-inspired.
- The same illustrated character, fixed camera perspective and wristwatch placement appear in all seven placeholder scenes.
- Crossfade transitions automatically every 3 seconds. Seven accessible day buttons, pause/play control, mobile swipe, arrow keys and reduced-motion support are included.
- Automatic playback pauses when the tab is hidden or hero is offscreen. Clicking a day pauses automatic cycling.
- All imagery currently consists of editorial **SVG concept illustrations**, NOT photos of real stock or products.

### Swap in your seven real campaign images

Export one image for each weekday as 16:9 WebP, ideally 2560 × 1440 or larger, with the same character in the same position and sufficient empty space on the left. Use the exact filenames:

- assets/hero-days/monday.webp
- assets/hero-days/tuesday.webp
- assets/hero-days/wednesday.webp
- assets/hero-days/thursday.webp
- assets/hero-days/friday.webp
- assets/hero-days/saturday.webp
- assets/hero-days/sunday.webp

Commit these images alongside the theme. The PHP template automatically prefers each WebP when the corresponding file exists, otherwise falling back to the SVG prototype. Do not delete the SVG fallback assets. The preview disclaimer disappears when all seven WebP files exist.

The text is live HTML for readability, accessibility and translation; don't bake it into photos. For mobile, test the portrait crop so the face, outfit and watch remain in view. Aim for compressed file sizes and consistent color grading. If product watches aren't based on approved real SKUs, avoid presenting them as exact purchasable product photos.

No checkout, payments, production deploy, inventory purchase or external image licensing has been performed.


## Editorial homepage redesign (v0.4.0)

Adapted the founder-provided editorial website reference into an original watch-focused layout. The nautical imagery, copy, brands, and specific visual content were **not** reused.

- Full-bleed seven-day cinematic hero with a translucent floating pill navigation and a curved ivory bottom edge.
- Two-column photographic/illustrative montage explaining the everyday collection concept.
- Deep-navy four-tile benefits panel about clarity, choice, order accuracy planning, and delivery information.
- Three tall visual style cards for weekday, occasion, and weekend use.
- Product-quality section explaining movements, materials, crystals, durability, fit, and functional complications.
- Three-step Collection Studio explanation (content only; interactive builder still separate).
- Four unmodified planned USD packages: 1/$160, 3/$299, 5/$499, 7/$639.
- Four-stage intended fulfillment journey and purchase-assurance section.

### Replace placeholder images
Hero photography replacement remains:
assets/hero-days/monday.webp ... sunday.webp.
The three-image montage and three visual occasion cards reuse these exact campaign frames. When real WebP campaign frames are added, they automatically appear throughout the homepage as well.

### Credibility constraints
No unverifiable product specs, warehouse QC proof, shipment times, carrier promises, fake testimonials, or live checkout are asserted. Fulfillment is described as a plan, and illustrative placeholders are labeled.

### Theme CSS scope
assets/css/editorial-home.css is only enqueued on the front page after week-hero.css. Other WP pages and WooCommerce views keep their original templates.

## Using the seven generated lifestyle images in the hero

The seven-day hero is already built into `front-page.php` and `assets/js/week-hero.js` with smooth fades, a day selector and a pause button. It automatically uses `assets/hero-days/monday.webp` through `sunday.webp` when those files exist, otherwise it shows SVG illustrations.

The founder-approved campaign image pack has been prepared outside this repository for upload. Unzip `watch-collections-seven-day-hero-assets.zip` and upload the seven WebP files to `assets/hero-days/` using GitHub **Add file → Upload files**; commit them to `main`. WordPress Playground needs a **new import** after GitHub updates; a normal browser refresh does not sync the source code.

The images are AI-generated lifestyle concepts, **not confirmed inventory or verified brand photography**. Product listings must use accurate, rights-cleared watch images and descriptions. 
