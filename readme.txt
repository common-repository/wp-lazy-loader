=== WP Lazy Loader for Images and Videos ===
Contributors: BlashO, ven4online
Donate link: https://blasho.com/
Tags: lazy load, BlashO, image, video, bandwidth, iframe, img, post, page, homepage, widget, gravatar, speed, youtube
Requires at least: 3.0.1
Tested up to: 4.9.1
Requires PHP: 5.2.4
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Short Description: It helps to lazy load images, YouTube videos and reduces blog loading time. Using this plugin, you can take control of where to lazy load on your blog.

== Description ==

WP Lazy Loader plugin helps to lazy load images, YouTube videos and reduce blog loading time. Using this plugin, you can take control of where to lazy load on your blog. For example, you can restrict lazy loading on the Homepage of your blog and allow it only on blog posts.

More information from the <a href="https://www.blasho.com/wp-lazy-loader-plugin/">plugin page</a>.

The plugin supports 3 different lazy loading options:

* **Lazy loading on Blog posts:** Enabling this option will lazy load all the images & YouTube videos on blog posts. It lazy loads images inside the blog posts, YouTube videos (when embedded using iframe tag) inside the blog posts, gravatar images in the comment section, images in the widget areas.
* **Lazy loading on Blog pages:** Enabling this option will lazy load all the images & YouTube videos on blog pages. It lazy loads images inside the blog page content, YouTube videos (when embedded using iframe tag) inside the blog page content, gravatar images in the comment section, images in the widget areas.
* **Lazy loading on Homepage:** Enabling this option will lazy load all the images & YouTube videos in the homepage. It lazy loads even if you have a static page set as homepage or a traditional blog style homepage.

You can enable or disable the above options in all combinations as per your requirement.

By lazy loading the images & YouTube videos, you can reduce the loading time of our blog. It also helps to reduce the bandwidth usage (because images, videos are loaded only when they come to the visibility of user).

**Manual configuration of lazy loading:**

Using this plugin, you can manually restrict a specific blog post/page from lazy loading. This can be done by adding the string <code><!-- disable-lazy-loader --></code> on the content of a blog post/page that you want to load normally.
 
== Installation ==

1. Upload the zip file to the wp-content/plugins/ folder
2. Go to Installed Plugins and click **Activate**.
3. For setup, go to **Settings - WP Lazy Loader**.

 
== Frequently Asked Questions ==
 
= How much blog loading time will be reduced? =
 
It is totally dependent on the number of images as well as the size of images used in your blog. This plugin may reduce loading time to a greater extent especially when your blog has a lot of high-quality images used.
 
= Do search engine like Google be able to index images? =
 
Nowadays, search engines are more intelligent and they can very well execute javascript to understand that the images are lazy loaded on the web page. 

In fact, this plugin also adds noscript tag that means even when javascript is disabled on the browser, your visitors can still see the images on your blog.

= Are there any changes to my blog posts, pages at the database level? =

No. There are no changes done to your blog post, pages in the database. Lazy loading is done dynamically without changing the contents of the blog post, pages in the database.
 
== Screenshots ==
 
1. The settings page of WP Lazy Loader plugin.
2. Shortcode to disable lazy loading

== Changelog ==
 
= 1.0 =
* Hurray! 
* Initial Version
  
== Upgrade Notice ==
= 1.1 =
Updated plugin tags .
= 1.0 =
Install WP Lazy Loader and improve the loading time of your blog + take more control on where to lazy load.
