=== Contact Coldform ===

Plugin Name: Contact Coldform
Plugin URI: https://perishablepress.com/contact-coldform/
Description: Secure, lightweight and flexible contact form with plenty of options and squeaky clean markup.
Tags: captcha, contact, contact form, email, form, mail
Author: Jeff Starr
Author URI: https://plugin-planet.com/
Donate link: http://m0n.co/donate
Contributors: specialk
Requires at least: 4.1
Tested up to: 4.7
Stable tag: 20161114
Version: 20161114
Text Domain: contact-coldform
Domain Path: /languages
License: GPL v2 or later

Contact Coldform is a secure, lightweight and flexible contact form with plenty of options and squeaky clean markup.



== Description ==

[Contact Coldform](https://perishablepress.com/contact-coldform/) is a secure, lightweight, flexible contact form with plenty of options and squeaky clean markup. Coldform blocks spam while making it easy for your visitors to contact you from your WordPress-powered website. The comprehensive Settings Page makes it easy to take full control with plenty of options and several built-in themes for styling the form. Coldform delivers everything you need and nothing you don&rsquo;t &mdash; no frills, no gimmicks, just pure contact-form satisfaction.

**Overview**

* Plug-n-play: use shortcode or template tag to display Coldform anywhere
* Sweet emails: Coldform sends descriptive, well-formatted messages in plain-text
* Safe and secure: Coldform blocks spam and filters malicious content
* Ultra-clean code: lightweight, standards-compliant, semantic, valid HTML markup
* Fully customizable: easy to configure and style from the Coldform Settings page

**Features**

* Slick, toggling-panel Settings Page makes it easy to customize and style Coldform
* Style Coldform using built-in "coldskins" or upload some custom CSS
* Provides template tag to display Coldform anywhere in your theme
* Provides shortcode to display Coldform on any post or page
* Displays customizable confirmation message to the sender

**Anti-spam &amp; Security**

* Captcha: Coldform includes challenge question/answer (w/ option to disable)
* Bot trap: hidden input field further reduces automated spam
* Firewall: secure form processing protects against bad bots and malicious input
* User-friendly: same-page error messages to help users complete required fields

**Customize Everything**

* Includes option to enable users to receive carbon copies
* Coldform message includes IP, host, agent, and other user details
* Customizable form-field captions, error messages, and success message
* Includes three built-in themes "coldskins" to style, or
* Style the Coldform with your own custom CSS
* Option to add a custom prefix to the subject line
* Option to disable the captcha for registered users

**Clean Codes**

Coldform brings delicious code on every front:

* Squeaky-clean PHP: every line like a fine wine
* Crispy-clean markup: valid, semantic source code with proper formatting
* Shiny-clean emails: Coldform emails deliver descriptive, well-formatted content
* Better performance: conditional loading of styles only when Coldform is displayed

**More Features**

* Works perfectly without JavaScript.
* Option to load CSS and custom styles only when/where Coldform is displayed
* Option to reset default settings
* Options to customize many aspects of the form
* Options to customize success, error, and spam messages
* Option to enable and disable CSS styles



== Installation ==

**Installation**

1. Install and activate via the Plugins screen
2. Visit the plugin settings to configure options

[More info on installing WP plugins](http://codex.wordpress.org/Managing_Plugins#Installing_Plugins)

**Usage**

To display Coldform on any Post or Page, add the Shortcode: 

	
	[coldform]
	

To display Coldform anywhere in your theme, add the Template Tag:

	
	<?php if (function_exists('contact_coldform_public')) contact_coldform_public(); ?>
	

**Advanced**

To customize Coldform, visit the plugin settings. For advanced customization, check out [CSS hooks for Contact Coldform](http://m0n.co/b). For more information, visit the [Coldform Homepage](https://perishablepress.com/contact-coldform/).



== Upgrade Notice ==

To upgrade Contact Coldform, remove the old version and replace with the new version. Or just click "Update" from the Plugins screen and let WordPress do it for you automatically.

__Note:__ uninstalling the plugin from the WP Plugins screen results in the removal of all settings from the WP database.



== Screenshots ==

1. Contact Coldform: Contact form displayed via Twenty Sixteen theme
2. Contact Coldform: Settings page showing default options (each panel toggles open/closed)

More screenshots available at the [Coldform Homepage](https://perishablepress.com/contact-coldform/#screenshots).



== Frequently Asked Questions ==

__Question:__ "Where does the shortcode go? Where does the template tag go?"

__Answer:__ The shortcode may be used on any Post or Page. For example, if you log in to the Admin Area and view a Page named "Contact", you can add the shortcode anywhere in the Page content to display the form. To use the template tag, add it to the desired location in your theme template. For example, if you have a custom page template named `page-contact.php`, you could add the template tag directly after `<?php the_content(); ?>` to display the form.

__Question:__ "Where does the CSS go? How do I change the CSS for the form?"

__Answer:__ Visit the "Appearance and Styles" panel in the plugin settings. There you may configure appearance and add custom CSS for the form.

__Question:__ "Can I add multiple Coldforms to my site?"

__Answer:__ Yes, you can add multiple instances of the shortcode and/or template tag.


**Questions &amp; Comments**

I try to keep an eye on the WordPress forums, but it's best to [contact me](https://perishablepress.com/contact/) directly with questions or concerns. Thanks.



== Support development of this plugin ==

I develop and maintain this free plugin with love for the WordPress community. To show support, you can [make a cash donation](http://m0n.co/donate), [bitcoin donation](http://m0n.co/bitcoin), or purchase one of my books: 

* [The Tao of WordPress](https://wp-tao.com/)
* [Digging into WordPress](https://digwp.com/)
* [.htaccess made easy](https://htaccessbook.com/)
* [WordPress Themes In Depth](https://wp-tao.com/wordpress-themes-book/)

And/or purchase one of my premium WordPress plugins:

* [BBQ Pro](https://plugin-planet.com/bbq-pro/) - Pro version of Block Bad Queries
* [SES Pro](https://plugin-planet.com/ses-pro/) - Super-simple &amp; flexible email signup forms
* [USP Pro](https://plugin-planet.com/usp-pro/) - Pro version of User Submitted Posts

Links, tweets and likes also appreciated. Thanks! :)



== Changelog ==

**Version 20161114**

* Fixed various PHP Notices
* Refactored and refreshed entire codebase
* Improved sanitization of submitted form content
* Improved sanitization of `contact_coldform_validate_options()`
* Improved logic of `contact_coldform_register_style()`
* Improved logic of `contact_coldform()`
* Beefed up abbr styles on settings page
* Defined color for form error messages
* Defined padding on fieldset elements
* Changed Twitter URL to https
* Updated plugin author site URL
* Updated URL for rate this plugin links
* Changed stable tag from trunk to latest version
* Refined default settings (single quotes to double quotes)
* Double quotes now allowed in success and error messages
* Added German translation
* Regenerated default translation template
* Tested on WordPress version 4.7 (beta)

**Version 20160810**

* Improved translation support
* Replaced `_e()` with `esc_html_e()` or `esc_attr_e()`
* Replaced `__()` with `esc_html__()` or `esc_attr__()`
* Removed support for Intranet Plus plugin
* Refined some styles on the settings page
* Tested on WordPress 4.6

**Version 20160329**

* Added Reply-To header
* Removed quotes from Content-Type header
* Added screenshots to assets (repo)
* Added 1544x500 banner to assets (repo)
* Replaced Coldform icon with retina version
* Added UTF-8 default to blog_charset option
* Added support for Intranet Plus plugin
* Tested on WordPress 4.5 beta

**Version 20151109**

* Updated minimum version requirement
* Update heading hierarchy on settings page
* Fixed incorrect escaping for quotes
* Refined contact_coldform() function
* Added coldform_sanitize_text() function
* Removed word wrap for message content
* Updated whois lookup link in emails
* Added support for HTTPS
* Tested on WordPress 4.4

**Version 20150808**

* Tested on WordPress 4.3
* Updated minimum version requirement

**Version 20150507**

* Tested with WP 4.2 + 4.3 (alpha)
* Changed a few "http" links to "https"

**Version 20150314**

* Tested with latest version of WP (4.1)
* Increased minimum version to WP 3.8
* Removed deprecated screen_icon()
* Removed redundant htmlentities()
* Replaced htmlentities() with sanitize_text_field()
* Added $contact_coldform_wp_vers
* Streamline/fine-tune plugin code
* Added Reply-To and Return-Path to email headers
* Added Text Domain and Domain Path to file header
* Replaced default .mo/.po templates with .pot template

**Version 20140922**

* Tested with latest version of WP (4.0)
* Added option to show/hide the website field
* Increased minimum version to WP 3.7
* Added conditional check for minimum version function
* Updated mo/po translation files

**Version 20140305**

* Improved localization support
* Generated new mo/po templates
* Bugfix: undefined index: coldform_carbon 
* Bugfix: replaced 'gmt_offset' with 'coldform_offset'
* Update: changed the description and default option for GMT setting

**Version 20140123**

* Tested with latest version of WordPress (3.8)
* Added option to display or not display the anti-spam/captcha field
* Added trailing slash to URL for load_plugin_textdomain()

**Version 20131107**

* Added uninstall.php file
* Added "rate this plugin" links
* Added support for i18n

**Version 20131103**

* Edited readme.txt install steps for clarity
* Removed "&Delta;" from die() for better security
* Tested plugin with current version of WordPress (3.7) 

**Version 20130725**

* Tightened form security
* Tightened plugin security

**Version 20130704**

* Added localization support
* Cleaned/updated/optimize code
* Overview and Updates admin panels now open by default
* Resolve PHP Notices for "Undefined variable" and "Undefined Index"
* Changed the placeholder attribute of the antispam field

**Version 20130103**

* Added margins to buttons (now required due to CSS changes in WP 3.5)

**Version 20121119**

* Now supports both shortcodes: `[coldform]` and `[contact_coldform]`
* Renamed `register_my_style()` to `contact_coldform_register_style()`
* Removed border on all fieldsets via CSS
* Added padding to input and textareas via CSS
* Replaced answer with question in anti-spam placeholder
* Added placeholder attributes to error fields
* Fixed styles to load on success page

**Version 20121031**

* rebuilt with cleaner, smarter code
* restructured markup, cleaner hooks
* revamped settings page with toggling
* includes three "coldskins" for styling
* enable user to upload custom CSS styles
* toggle on/off the built-in coldskins
* conditional load of styles only on Coldform
* improved markup for required, error, success output
* option to disable the captcha for registered users
* now use admin email, name, site title by default
* now using built-in wp_mail for email
* removed the credit link and option
* add option for subject line prefix
* add HTML5 placeholder attributes
* add hidden anti-spam field

**Version 0.88.1**

* Compatibility with WordPress version 2.8.1 by setting `admin_menu`.

**Version 0.88.0**

* Initial release.


