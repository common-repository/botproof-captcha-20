=== Plugin Name ===
Contributors: botproof
Donate link: http://www.botproof.com
Tags: captcha, comments, spam, bots, antispam, botproof
Requires at least: 2.1
Tested up to: 2.7.1
Stable tag: 0.9.6.8

The plugin provides the next generation in captcha, BotProof Captcha 2.0, to a WordPress blog comment form.  It is currently version 0.9.6.8 Beta.

== Description ==

We are proud to announce our NEW AdEmbed feature that enables you to make extra cash **$$$** with your blog!  

[BotProof](http://www.botproof.com "BotProof") Captcha is a free anti-spam and anti-bot solution which uses a new and unique type of [CAPTCHA](http://en.wikipedia.org/wiki/Captcha "CAPTCHA - Wikipedia").  We offer a service that will change the way you think about protection from spam and bots.  This is the next generation in captcha technology, Captcha 2.0.  No more distorted letters that annoy your users, and no more [OCR](http://en.wikipedia.org/wiki/Optical_character_recognition "Optical Character Recognition - Wikipedia") bots breaking through weak captcha implementations.  BotProof captchas use dynamic information to display hidden symbols in unique ways that are harder for bots to break through, yet easier for your users to read.
	
Our technologies are state-of-the art, with many customizable options.  For example, login to [BotProof.net](https://botproof.net "BotProof Account Configuration") using your BotProof Account ID and Password to customize the colors of your captcha.  We deliver our captchas over the Internet in real-time, so we can deliver a variety of implementations without the need to install new software.  We can react quickly and enhance the technologies, to always stay one step ahead of the bots.  Our software can also be used to protect your personal information and your identity.

For more information, please visit our [plugin page](http://www.botproof.com/wordpress.html "BotProof Captcha WordPress Plugin").

== Installation ==

To install the BotProof Captcha in WordPress:

1. Upload the `botproof_captcha2` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. Get free BotProof account [here](http://www.botproof.com/index.php?option=com_user&task=register#content "Free BotProof Account")
4. Enter your BotProof account information into the plugin settings in WordPress

== Requirements ==

* You need a free BotProof account [here](http://www.botproof.com/index.php?option=com_user&task=register#content "Free BotProof Account")
* Your users will currently need to have Javascript enabled in their web browsers to see and complete the BotProof Captcha form.  We will be releasing a version soon that supports browsers with Javascript disabled.
* Your theme must have a `do_action('comment_form', $post->ID);` call right before the end of your form (*Right before the closing form tag*). Most themes do.

== ChangeLog ==

= Version 0.9.6.8 =
* Moved user configuration options from external files to database tables to improve stability and security

= Version 0.9.6.7 =
* Captcha image files are now stored on Amazon Cloud infrastructure to improve loading speed

= Version 0.9.6.6 =
* Optimized loading of gifs using new customized color system

= Version 0.9.6.5 =
* Admin options page now synchronizes AdEmbed settings with BotProof.net server

= Version 0.9.6.4 =
* Added code to speedup AdEmbed program redirection to advertiser's website

= Version 0.9.6.3 =
* Server side improvements to optimize database queries

= Version 0.9.6.2 =
* Optimized server architecture so AdEmbed captchas will begin buffering and displaying faster

= Version 0.9.6.1 =
* NEW!  **$$$** BotProof AdEmbed, where you can MAKE MONEY from your blog's captcha.  You've seen advertising plug-ins to earn money from your blog's traffic.  Download this version and select the AdEmbed Opt-In on the plugin configuration page to START MAKING MONEY from our AdEmbed program, where an ad is integrated right into the captcha itself.  Not only does this bring revenue to you, it strengthens the captcha!  Now hackers and their bots will have to work even harder to filter out the advertisement from the captcha code.  See our plugin FAQ for more information.

= Version 0.9.5.7 =
* Optimized server download time with new gif encoding algorithm
* Added smaller version of rendering gif
* Added server changes to map captcha target location

= Version 0.9.5.6 =
* Added IP address geographical location code on server side

= Version 0.9.5.5 =
* Updated screenshots with versions formatted for display on WordPress.org

= Version 0.9.5.4 =
* Added image meta data to enhance search engine indexing
* Updated screenshot of plugin settings page

= Version 0.9.5.3 =
* Added timing code to record image load time for optimization purposes
* Updated screenshot of plugin to demonstrate dynamic nature of the technology

= Version 0.9.5.2 =
* Changed filetype of new screenshot

= Version 0.9.5.1 =
* New dynamic screenshot to preview upcoming AdEmbed opt-in feature

= Version 0.9.5 =
* Added more robust error handling

= Version 0.9.4.9 =
* Added opt-in checkbox for upcoming AdEmbed feature

= Version 0.9.4.5 =
* Timestamp is now sent to server in order to analyze database write time
* Language is now sent to server to gather data for upcoming multi-language feature

= Version 0.9.4.1 =
* BotProof Account ID and Password no longer deleted when plugin is deactivated

= Version 0.9.4 =
* New feature!  Customize your captcha colors by logging into BotProof.net.
* Fixed floating text error on plugin setttings page
* Added code to prevent browser session variable exploit

= Version 0.9.3.5 =
* Ampersands in script URL's are now encoded to conform to XHTML standards

= Version 0.9.3.2 =
* Added new script tags to facilitate search engine indexing

= Version 0.9.3 =
* Added new environment parameters to pass from server

= Version 0.9.2.7 =
* Fixed problem with options/parameters sometimes missing in WordPress v2.7.1

= Version 0.9.2 =
* IP Address is passed to server for enhanced security and statistical analysis

= Version 0.9.1 =
* Modified source code to conform to most of the WordPress plugin coding standards

= Version 0.9 =
* First Beta release of BotProof Captcha WordPress Plugin

== Frequently Asked Questions ==

= How much will I earn from the AdEmbed program? =
 
AdEmbed is a pay for performance program, meaning that you will earn a commission when one of your readers completes a qualifying transaction on the advertiser site.  Commissions vary from a flat fee to a percentage of the total sale.
 
= How can I track performance, commissions earned, etc. for the AdEmbed program? =
 
We are working on the back-end interface providing just such capabilities.  In the mean time, contact BotProof Marketing (marketing@BotProof.com) and we will provide you with a custom report.
 
= How and when will I be paid if I have opted-in to the AdEmbed program? =

We will notify you when commissions earned have reached $20; and make payments to your PayPal account within 90 days of the end of the month when commissions were earned (assuming no cancellations, returns, charge-backs, etc. on the commissionable event).  

= Why do you use random letters and numerals, instead of words from the English language? =

The captchas you see online who use words from the dictionary are doing so because their noise makes it too DIFFICULT for a human to read.  (Noise is the distortion or lines they add to a particular symbol.)  But using English words is less secure.  Once a bot can guess a few letters, it can search for words in the dictionary to solve the other unreadable letters.  Because BotProof Captcha does not need to distort the letters and can make them more readable, we can offer the added security of using random symbols.  Our captcha also therefore does not depend on the user speaking a particular language.

= Are captchas secure? I heard spammers are using other sites to solve them:  the captchas are sent to a different site, and the other site's users are asked to solve the captcha before being able to enter or access a valuable resource. =

Captchas offer great protection against abuse from automated programs. While it might be the case that some spammers have started using redirection sites to attack captchas (although there is no recorded evidence of this), the amount of damage this can inflict is small (so small that we haven't even seen this happen). Whereas it is easy to write a bot that attacks an unprotected site millions of times a day, redirecting captchas to be solved by humans would only allow spammers to abuse systems a few thousand times per day. The economics of this attack just don't make sense.  Every time a redirection site shows a captcha before giving access to a resource, they risk losing a customer to another site that doesn't do this.  We welcome references to any articles, evidence, or research in this area.



== Screenshots ==

1. BotProof Captcha in a WordPress blog
2. BotProof Captcha with AdEmbed example
3. BotProof Captcha Settings Page