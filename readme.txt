=== Ribbon Maker ===
Contributors: itscoolreally
Donate link: http://www.cafepress.com/SupportHypershock
Tags: ribbon,maker,creator,designer,decoration,corner
Requires at Least: 3.0.0
Tested Up To: 3.4.1
Stable tag: 1.6.2

Make your own ribbon now without waiting for a plugin designer to do it for you.

== Description ==

A ribbon creation/corner decorator plugin that will allow you to generate your own ribbons for each of the 4 corners or you can upload your own graphics. 

= Features =
* All of the features of the static corner ribbons
* Set the Message
* Set the Link
* Set the Title (hover message)
* Set the toolbar offset
* Set no toolbar offset
* Set horizontal offset for each corner
* Set the background and foreground color
* Control the visibility of the of ribbon via (de)activation
* Use custom images.
* Z positioning
* Our graphics can fade out via a timer control!

**Now with added JSColor color picker!**
***Our plugin now loads with JQuery No-Conflict mode!***

== Installation ==

1. Download the plugin zip archive.
1. Extract it in your `wp-content/plugins` folder or upload via admin panel.
1. Browse to your plugins section and activate the plugin.

- OR -

Install it via the plugin manager.
== Screenshots ==
1. Preview Section of configuration with 4 ribbons displayed.
1. The configuration page options.
1. An example of three of the ribbons on your site.

== Changelog ==
= 1.6.2 =
Added a donate link to further encourage me to develop for the community, you can actually purchase swag with my link! Yeah.
Tweaked our use of jscolor to not conflict with other plugins that use jscolor to fix compatibility issues with "colored vote polls".
Added banner link toggle.
 
= 1.6.1 =
removed check for image type.

= 1.6 =
Added JQuery No-Conflict mode wrappers to prevent collision with the wrong versions of JQuery both internally and externally.

= 1.5 =
Added the ability to fade out banners and graphics for any amount of time. Corrected last versioning snafu!

= 1.4 =
Discovered some typos in the language on the settings screen. Added Z positioning so you can ensure what Z layer your graphics will appear on.

= 1.31.1 =
Fixed a css problem with new horizontal offset in 1.31

= 1.31 =
Added horizontal offset to corners, great for custom graphics.

= 1.30 =
Added JSColor picker code to color selection boxes from the LGPL JSColor at JSColor.com.

= 1.22 =
Added ability to upload custom images.
Fixed refresh issue. Now when you make a change to the images, they update!
Added more of a visual cue to help realize which image you are editing.

= 1.21 =
Fixed z-index issue with ribbons overlaying fly down menus on the admin bar and possibly fly up menus on installed bottom bars.

= 1.2 =
Added the other 3 corners.

= 1.11 =
Ok, I'm going to make a checklist of stuff that must be double checked before I commit. This is like the 3rd time I've done this on accident. Get all committed and discover that something minor but crucial got left out. Grrrr.

= 1.1 =
Fix issue where Ribbon was not completely drawing out as I intended.

= 1.0 =
Cropping has been achieved. Also added a radio button to control the visibility of the ribbon. Ribbon generates only during the configuration and not constantly as in v0.1. Added a preview of the ribbon, so you can view it before you make it active.

= 0.1 =
Inspired by All of the static Ribbons in the Repository

== Frequently Asked Questions ==
= Why are you doing this? =
There are so many notable reasons for wanting a ribbon. Why wait for someone to make one for you when you can make it yourself whenever you want.
= I don't see anything on my blog pages? =
Make sure you have set all of your options and that your FGCOLOR & BGCOLOR settings are sufficiently different.
= All I see is a bar? =
Your FGCOLOR needs to be different enough from your BGCOLOR so as to allow the message to be descerned from the shape.
= I still don't see my message? =
Make sure you have actually set the message. Also make sure you have set the ribbon to be active.
= Clicking the ribbon doesn't lead me anywhere ... =
Make sure the LINK specifies a fully qualified URL.
= I don't get that hover message you were blathering on about. =
You have to make sure the LINK TITLE is set to something in order to enjoy the feature. :)
= Why is 0x000000 transparent or clear? =
Because I needed a transparent/alpha color and that is what php is forcing me to use. Grrrrr. So don't set your colors to that value else things will vanish on you. Use some other near black color like 010101 if you need black.
= Why are my color choices being ignored? =
You have to set the colors using hex values, but leave off the preceding # (hash). Example: you want black, that's normally #000000, so you enter 000000 in the color box of your choice.
= My custom image blocks out a pieces of my site! Why? =
That is because the parts of your image that are supposed to be transparent ... are not transparent. You will need to reedit your image and ensure that it is transparent in the areas that needs to be.
== Upgrade Notice ==
= 1.6.2 =
Patched incompatiblity issues with "colored vote polls".
Added support me links.
Added banner link and title disabling.

= 1.6.1 =
If everything is still working fine for you, then you don't need this. I've implemented an ugly hack to removes the check for filetype on custom image upload.
= 1.6 =
Are you having problems with JQuery conflicts? Then this upgrade ensures that we are not in that problem scenario.

= 1.5 =
Would you like to have your banners and custom graphics to automatically disappear after a set amount of time? Sure you do!

= 1.4 =
Tired of seeing the word "hover" written as "hove"? This will fix that, plus the help text for "Title" will be more meaningful. Also, you get a fabulous new Z control!

= 1.31.1 =
I had a problem with my css for 1.31, offset now works correctly.

= 1.31 =
If you don't need horizontal offset then you don't need this upgrade, wait for more features. :)

= 1.30 =
Now you don't have to imagine what the hex color code is, you can simply pick it from the JSColor picker!

= 1.22 =
Do this only if you need the ability to upload custom images in place of the ribbons.

= 1.21 =
Fixed Z index issue involving ribbons overlaying fly out menus.

= 1.2 =
Now you aren't limited to the one corner, get up to all 4 at once if you like! Also, your database is automatically updated in regards to the ribbon you've made now, but you will have to save again to make it convert over.

= 1.11 =
Not a critical update -- see changelog

= 1.1 =
Your corner ribbon will now look more beautiful.

= 1.0 =
Now with cropping, ribbon hiding on demand, and preview.

= 0.1 =
Considered to be an upgrade for anyone having a static ribbon created by another ribbon plugin.

== Additional Information ==
= Requirements =
PHP 5.x
GD image library
= Issues =
Godaddy 4GH has a strange cacheing problem, no matter what you set for cacheing over-ride, they cache things for upto a minute and typically longer so if you notice that your images don't immediately display then wait at least 2 minutes and refresh and they'll be there. However, if you know of a solution to this mess please let me know and I'll add you to contributors line. Turns that after you mash "regenerate images" if the graphics still have not updated, if you do a ctrl+f5 (forced refresh of your browser) then new graphics appear. That makes it sound like a browser issue. But it isn't. If anyone has some ideas. Please let me know so I can fix this or stop worry about fixing it in case it is a browser issue.

Site5 webhosting has a really old version of PHP and I believe the GD library. So if you aren't getting generated banners and you are somehow based off of Site5.com that is most likely the problem. However, I am told that they are switching to the latest version of PHP in the next few weeks, so we will soon see.

Implementing the planned CSS rendering engine will alleviate both issues.
== TODO ==
= REWRITE!!! =
Completely rewrite the plugin as it is hugely unmaintainable now. This must be done before anything else on the TODO list can be accomplished. I am currently looking for people to help with getting this done and for future development of the plugin. Benefits are new friends, additional promotion of your site and a warm fuzzy feeling!
* I am thinking of going with classes as well as segmenting the file into multiple parts.
= Cookies =
By using cookies I'll be able to add a banner/graphic skipping mechanism. Example of this would be that you would tell the banner to not show for 5 pageviews, or skip for 5 then show up. By using cookies, we can control this on the user and when the cookie count matches, we will display the graphic in question.
= Store for Future =
Add database routines to store everything you create or upload for future retrieval at any time. Also, needed for scheduling.
= CSS Functionality =
Switch to a completely CSS driven routine. Which will solve resolution issues and transparency issues. Because the GD library sucks. For some reason GD is forcing me to use the "black" color for the transparency. It is not agreeing with the code at PHP.net. Going CSS will solve this issue. I just have to wrap my mind around CSS now. :D
= Transparency =
Fix transparency issue. I checked with browsershots.org and it seems the images are drawing great. So if I can solve the issue where GD insists on black being the only transparent color for the background, things will be better. This will be a non-issue when the css rendering engine is implemented.
= Scheduling =
Allow the decorations to be scheduled to appear on any given time and day. This is great for the holidays, special events and more!
