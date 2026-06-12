=== Tony Club Circuit ===

Contributors: clubcircuit
Requires at least: 5.5
Tested up to: 6.5
Requires PHP: 7.2
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A modernised, dependency-free rebuild of the original Club Circuit theme.

== Description ==

This theme is a drop-in modern replacement for the original "clubcircuit" theme.
It keeps the same data layer so existing content keeps working:

* Custom post types: Club and Member
* The same Advanced Custom Fields (ACF) field names
* The same Options Framework option IDs (logo, social links, copyright,
  announcement settings, member-clubs intro)
* The same page templates (Homepage, About Us, Contact, Commitee, Marketplace,
  Insurance, Club Circuit Rules Page, JIM Lambert Medal Page, Links & Rules,
  Past Years Pennant Results, Blog) — file names and "Template Name" headers
  are unchanged, so pages keep their assigned template
* The same widget areas (Footer-1, fb-widget, newsletter, visitorcounter,
  sidebar-1) and menu locations (Primary, Footer)
* Plugin integrations: Breadcrumb NavXT, Contact Form 7, Easy Visitor Counter,
  Instagram Feed, Facebook Like Box, Yoast SEO

What was modernised:

* No Bootstrap, Owl Carousel or jQuery. Layout uses a small self-contained CSS
  grid (compatible with the original col-*/row classes); sliders and the mobile
  navigation are tiny vanilla JavaScript.
* All CSS/JS is properly enqueued (no hardcoded CDN tags).
* Responsive, accessible navigation with a real mobile menu, sticky header,
  skip link and focus styles.
* Social/contact icons are inline SVG (the original referenced Font Awesome,
  which was never actually loaded).
* Brand identity preserved (blue #336799, red #b20e16, gold #e3dd2a).

== Dependencies ==

Recommended/active plugins (already in use on the site):
Advanced Custom Fields (+ Repeater), Options Framework, Breadcrumb NavXT,
Contact Form 7, Easy Visitor Counter, Instagram Feed, Facebook Like Box Widget,
WP-PageNavi, Yoast SEO.

== After activating ==

A theme switch resets a couple of per-theme settings (this is normal WordPress
behaviour, not a bug):

1. Appearance > Menus: assign your menus to the "Primary" and "Footer" locations.
2. Appearance > Theme Options: re-enter the logo, social URLs, copyright text
   and announcement category (Options Framework stores these per theme).
3. Confirm footer widgets are still in place (the widget-area IDs are unchanged).

== Changelog ==

= 1.0.0 =
* Initial modernised release.
