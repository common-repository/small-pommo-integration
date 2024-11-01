=== Small Pommo Integration ===
Contributors: Ulrich Kautz
Donate link: http://blog.foaa.de/
Tags: mail, newsletter, pommo
Requires at least: 2.7
Tested up to: 2.8.0
Stable tag: 0.5

A Wordress 2 Pommo Implementation

== Description ==

This Plugin brings Pommo and Wordpress togther. You can feed your Pommo newsletter with a subscription formular from your wordpress website.

* Subscription formular is build from wordpress fields.
* Supports an AJAX and a "normal" subscription formular
* Highligy customizable: Each and every label and message could be defined, all Pommo fields can be either shown, not shown (=Pommo defaults) or provided hidden with custom defaults.


== Installation ==

Either:
* Download .zip file and extract into your "wp-content/plugins" directory.
or 
* Use the Wordpress installer to install the plugin

Then
* Activate the plugin through the 'Plugins' menu in WordPress
* Go to Settings -> Pommo and configure your database connection to Pommo!
* To place the subscribe formular simply put the shortcode `[pommo-formular]` for the "regular" formular (or `[pommo-ajax-formular]` for the ajax driven) in the WordPress editor (there are two, you can use any of those) .. You could also call the formular creation directly in a template via `spi_print_pommo_form()` or `spi_print_pommo_ajax_form()`

= If you want to use the AJAX Form =

* Dont use any Success URL or Confirm URL in Pommo ( Setup -> Configure -> General ) !! This would throw a redirect which cant be handled! Leave it blank!


== Frequently Asked Questions ==

= The Message from the AJAX Form is always "Error.."! Why ? =
Probably because you have modified the Pommo success / error templates. This is not forbidden, but it's mandatory that there is the div with the id "alertmsg" ..

It looks like this : `<div id="alertmsg" class="error">Why there is an error</div>` or on success: `<div id="alertmsg">Welcome ..</div>`

This is required! Dont remove it! But you can hide it (style="display:none") if you want.. the "class=error" is also required!

= I've used a Site URL and removed it because i want the AJAX Formular - and it still doesnt work ! =
Also remove the "Confirm URL" in Setup -> Configure -> General

= I HAVE to have a Success and / or Confirm URL but i still want the AJAX Formular ! =
You could replace the process.php in "path-to/pommo/user/process.php" with the one provided in this plugin .. But no warranties! If the Pommo developers will make any changes or some!

= With which version of Pommo does this work ? =
I've tested 16.1, the current stable in 2009-04.

= I have a problem with pommo, it wont work =
Please go here: http://pommo.org and ask the developers.

= Why cant i setup new fields for Pommo from Wordpress ? =
Because the Pommo developers kindly provided this feature in Pommo.


== Screenshots ==

1. Basic Database Configuration
2. Basic Pommo and Wordpress Configuration
3. Pommo Fields.. these are setup in Pommo an read by this plugin. You can either show them, ignore them (Pommo defaults will propably be honored) or set some (hidden) default.
4. Usage Example

== Change Notes ==

= 0.5, 2009-09-16 =

* Sort order of the fields as in pommo preset and not alphabetic
