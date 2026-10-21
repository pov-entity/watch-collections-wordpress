# Watch Collections — WordPress + WooCommerce Theme

**Status:** Prototype v0.8.1. Not a live store. Uses the founder's DialByDay Collections identity. The Collection Studio supports **1, 3 or 6 watches**.

## Five-watch view and mobile box — v0.8.1

The full catalog shows a large centered watch and two previews on either side. Inner previews are smaller and faded; outer previews shrink and fade further. Catalogs with at least five matches wrap in both directions so the four previews stay present at the first and last watch. Shorter filtered lists show only their matching watches. Equivalent track copies preserve the native scrolling experience; only the centered watch enters the keyboard tab order and accessibility tree.

The add/replace button sits directly underneath the watch artwork, before the navigation controls and descriptive details. On mobile, a compact, interactive overhead box sits above the carousel and stays at the top while browsing. It shows the complete 1/3/6-slot tray, selection count, current price status and a View box action. This replaces the bottom selection bar. Adding updates the visible overhead tray and preserves the centered watch.

Validation: JavaScript syntax and PHP 7.4 template checks passed. Desktop and 390px mobile browser checks covered five visible watches, progressive fading, artwork centering, outer-preview clicks, wrapping in both directions, five-result loops, single/empty filters and adding through the repositioned action. The mobile page fits its viewport, the box appears before the carousel, and adding updates the six-slot tray immediately. Prices remain unchanged. Import theme **0.8.1** for this update.

[Mobile layout preview](docs/collection-studio-mobile.jpg) shows the overhead box, five-watch view and immediate add action, with the carousel's keyboard focus visible.

## Watch carousel — v0.8.0

The Studio catalog is a horizontal carousel with native touch/trackpad scrolling and center snapping. The centered watch appears at full size; neighboring watches appear smaller. A detail panel underneath follows the centered watch and shows its name, description, dial, finish, strap design, full-details link and add/replace action. Browsing alone does not change the box.

Customers can swipe, click a neighboring watch, use the previous/next controls, or use Left/Right and Home/End keys while focused on the carousel. There is no autoplay. The motion toggle and reduced-motion preference apply to centering and transitions. Filters preserve the featured watch when it still matches; one-result and empty states are handled. Adding or replacing a watch refreshes its selected state without rebuilding the carousel or losing its position. The existing overhead 1/3/6 trays and package prices are preserved.

Validation: JavaScript syntax, all ten collection-state tests and PHP 7.4 template checks passed. Browser checks covered desktop and a 390px mobile frame, centered-watch sizing, keyboard and arrow navigation, add/swap/targeted replacement, style/strap/search filters, single/empty results and mobile page fit. A physical-device touch check and a full WordPress integration check remain appropriate before launch. Import theme **0.8.0** to see this update.

## Overhead collection tray — v0.7.2

The live Studio tray and collection review use dedicated top-down 1/3/6 box visuals. Each asset has calibrated frame and compartment coordinates in the page configuration; watch overlays use a centered, upright view, with no card rotation or floor shadow. Six watches stay in a single row. The mobile box review includes the same overhead tray above the editable selection list. The angled product photographs remain in the package choices.

The generated visuals are stored as alpha-preserving WebP files and smaller responsive variants in `assets/boxes/`. The source images are not destructively cropped: the interface frames them in CSS and positions interactive compartments in the same coordinate system. Selection, replacement and reorder behavior continues to use the existing state model. Prices remain unchanged. Import theme **0.7.2** for this update.

Validation: JavaScript syntax and PHP 7.4 template checks passed. Browser QA verified all 1/3/6 tray images, upright watch placement, six centered watch faces fitting their compartments, and mobile review/reordering without horizontal overflow. Generation briefs and asset sizes: `assets/boxes/overhead-prompts.md`.

## Realistic box visuals — v0.7.1

The homepage package cards and Studio size selector now use a consistent set of generated product images in `assets/boxes/`. The three- and six-slot boxes follow the founder's supplied walnut-finish, brown-lined, glass-lid references; the single-slot image is an explicitly provisional adaptation. The six-slot box and selection tray use one row of six compartments. Images contain empty pillows rather than unverified watch models, and omit supplier-photo labels, measurements and background props.

Each visual has a 1448 × 1086 WebP and a 480 × 360 responsive variant. The interface identifies these as AI-generated visuals; they do not verify final dimensions, construction materials or fulfillment specifications. The original PNG generations remain separate. The prompts and provenance are recorded in `assets/boxes/README.md`. Package prices remain unchanged pending founder approval. Import theme **0.7.1** to see this update.

## Collection Studio — current version

Use **Build your collection** in the header or homepage hero, or choose a package on the homepage. The portable `/?collection-studio=1` route works without a database page or permalink reset. `&box=1`, `&box=3` and `&box=6` request a box size. A native WordPress page can also use the **Collection Studio** page template.

- Twelve original, clearly labeled vector concept watches in a swipeable center-focused carousel, with style, strap and text search filters.
- Watch details show visual design information separately from unverified movement, materials, dimensions, functions and water resistance.
- Persistent desktop presentation-box preview and a sticky overhead box above the mobile carousel.
- Add, replace, remove and reorder watches; confirm before a smaller box discards selections. Full boxes require choosing which watch to replace.
- Browser-local persistence with corrupt-data validation and an in-memory fallback when storage is unavailable.
- Native keyboard-accessible dialogs, reduced-motion support and a motion toggle.
- Review the exact selection without creating orders, reserving stock or accepting payments.

`inc/collection-studio.php` owns the shared package configuration and route. `assets/data/studio-catalog.json` contains public concept data; `watch_collections_studio_catalog` is the future catalog integration hook. `assets/js/collection-state.js` separates selection rules from the interface. This prototype must not be used to authorize commerce: real stock, package eligibility and prices need server-side validation in a separate commerce plugin.

**Pricing decision:** The last approved numeric plans remain 1/$160 and 3/$299. The newly requested 6-watch box deliberately has a null price, shown as **Price to be confirmed**. The proposed 1/$179, 3/$399, 6/$699 ladder is a recommendation awaiting founder approval and has not been applied. Historic four-size plans below are superseded by the current 1/3/6 structure; the seven-day hero remains a lifestyle sequence.

**Validation:** `node --test tests/collection-state.test.cjs` covers size eligibility, capacity, explicit replacement, downsizing confirmation, sparse selections, reordering, storage sanitization and null-price handling. PHP 7.4 parsing and rendered-template integration checks passed using WordPress function stubs. Browser QA verified desktop and a 390px mobile frame. A full WordPress/Playground integration test is still required after importing the theme.

**Preview update:** Import the latest repository into a new WordPress Playground instance and confirm theme version **0.8.1**. Refreshing an older saved Playground does not fetch new commits.

### Decision log — 2026-10-21

- Founder selected box sizes 1, 3 and 6; replaced the former 1/3/5/7 options on the current homepage.
- Kept price changes pending explicit approval. No order, payment, supplier outreach, spending or production deployment.
- Built the selector with concept data, preserving the current approved logo, palette, typography and hero imagery.

### Next three tasks

1. Confirm the 1/3/6 price ladder and cost assumptions, including the six-slot box, freight, duties, fees and returns.
2. Validate physical samples and replace concepts with approved SKU photography, measured fit, verified specifications and stock.
3. Connect a server-validated commerce backend for package eligibility, inventory reservations and checkout; test in Playground and staging before launch.

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

Production watch-box builder integration, cart rules, final packaging, approved pricing, supplier photography, verified product descriptions, legal pages, international shipping policies, operational payments, and real customer checkout. The homepage and Collection Studio clearly label conceptual visuals.

**Do not accept real customer payments before full testing and legal/commercial details.**

## Development roadmap

1. Validate the homepage and continue the Collection Studio prototype; the approved DialByDay logo and icons are installed.
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

## DialByDay brand integration (v0.4.1)

- Header and footer use the original vector horizontal logo from `dialbyday_brand_kit.zip`, included in `assets/brand/dialbyday-logo.svg`. The header is white over the homepage hero and black on light interior pages.
- The matching standalone mark supplies the SVG favicon, multi-size ICO, PNG browser icons and Apple touch icon. A navy tile keeps the white mark visible in both light and dark browser tabs.
- Native WordPress Site Icon filters supply the theme icons without requiring a media upload. Versioned asset URLs refresh browser caches with theme updates.
- This is a theme update: re-import the repository into WordPress Playground to load it. Refreshing an older Playground instance does not update its installed theme.

Decision log — 2026-10-21: apply the founder's existing refined DialByDay identity to the website and favicon; retain the supplied artwork. Next development priorities remain the Collection Studio, sample/QC validation and commerce backend selection.


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


## Current website palette — v0.5.0

The visual identity uses the founder-provided reference's colors only (not its law-firm emblem or typography).

| Role | HEX | Use |
| --- | --- | --- |
| Deep navy | `#102A4F` | Site structure, primary actions |
| Midnight navy | `#0B203D` | Dark sections and footer |
| Steel blue | `#90B1C2` | Secondary accents, focus and progress |
| Silver grey | `#CED3D9` | Dividers and understated surfaces |
| Cool white | `#F5F7F9` | Main background and light cards |
| Copper | `#B77B57` | Decorative highlights, never as fine print on light backgrounds |
| Dark copper | `#99603E` | Accessible accent text on cool white |
| Slate text | `#526577` | Supporting body text |

Implemented in `assets/css/site.css`, `assets/css/editorial-home.css`, `assets/css/week-hero.css`, and WordPress `theme.json`; version `0.5.0` refreshes stylesheet cache. The seven-day lifestyle pictures, builder economics, and page copy are unchanged.

**Preview:** Import the latest GitHub version into a *new* WordPress Playground installation or update the theme files in your saved one. A browser refresh does not import new commits. Verify mobile contrast and WooCommerce checkout styling before live launch.

## Typography and Playground refresh — v0.6.0

The founder's typography reference has been interpreted as a focused four-family system, rather than loading all the fonts in the reference:

- **Montserrat** for strong headings, titles and buttons.
- **Inter** for easy-to-read body text and shopping interfaces.
- **Lora** for selective editorial/italic headings and collection price figures.
- **Space Mono** for day counters, small metadata and feature labels.

Implemented via Google Fonts + `assets/css/typography.css`, queued last after homepage, hero and base CSS. Fallback system fonts remain available if a Playground device cannot connect to fonts.googleapis.com. These families are also selectable under the WordPress editor's typography presets.

The logo is not a text font: the header and footer already reference `assets/brand/dialbyday-logo.svg` (the transparent white founder mark), colored white on the homepage hero and navy on light pages. `assets/brand/favicon.svg` also uses the approved navy `#102A4F`. Existing PNG favicon variants may retain a slightly darker background; they should be regenerated from the approved original logo before launch.

**Seeing changes in WordPress Playground:** an existing *saved* Playground instance is not continuously connected to GitHub. Refreshing Safari or clicking Autosaved does not pull the new theme. Open **New → From GitHub**, import `https://github.com/pov-entity/watch-collections-wordpress`, select **Theme** and `/`, and activate it. Under **Appearance → Themes**, confirm Watch Collections **version 0.6.0**. Open the homepage in that *new* Playground. If fonts do not load, temporarily disable blockers and check connection to Google Fonts; fallback typography will still render. Back up any existing content before replacing an old Playground instance.
