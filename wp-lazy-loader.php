<?php
/*
Plugin Name:  WP Lazy Loader
Plugin URI:   https://www.blasho.com/wp-lazy-loader-plugin/
Description:  Lazy load images and videos, reduce blog loading time by lazy loading all images and YouTube videos in blog posts, pages and also on homepage. You can also disable lazy loading on certain blog post, pages.
Version:      1.1
Author:       BlashO
Author URI:   https://www.blasho/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

add_action('admin_menu', 'WPLL_CreateMenu');
add_action('init', 'WPLL_Operations');
add_action('wp_enqueue_scripts', 'WPLL_EnqueueScripts');
add_filter('the_content', 'WPLL_LazyLoad');
add_filter('script_loader_tag', 'WPLL_ScriptLoaderTag', 10, 3);
add_filter('widget_text', 'WPLL_LazyLoad');
add_filter('get_avatar', 'WPLL_LazyLoad');
add_filter('post_thumbnail_html', 'WPLL_LazyLoad');

function WPLL_CreateMenu()
{
    add_options_page( 'WP Lazy Loader', 'WP Lazy Loader', 'manage_options', 'wplazyloader_option', 'WPLL_MainPage' );
}

function WPLL_MainPage()
{
    echo '<div class="wrap"><div id="icon-options-general" class="icon32"><br /></div>';
    echo '<h1>Settings - WP Lazy Loader</h1><br/>';

    echo '<form name="WPLL_MainPage" style="background:white;padding:20px;" method="post">';
    echo 'Setup how do you want WP Lazy Loader to work on your blog. You can individually control lazy loading on blog posts, blog pages as well as on homepage. Tick the corresponding box to enable lazy loading, untick to disable lazy loading.';
    echo '<table class="form-table">
	<tbody><tr class="user-rich-editing-wrap">
		<th scope="row">Allow Lazy Loader On:</th>';
		if (get_option("wpll_blogposts") == 1)
		    echo '<td><label for="rich_editing"><input name="wpll_blogposts" type="checkbox" id="wpll_blogposts" value=1 checked>Blog Posts</label></td>';
		else
		    echo '<td><label for="rich_editing"><input name="wpll_blogposts" type="checkbox" id="wpll_blogposts" value=1>Blog Posts</label></td>';
	echo '</tr>
    <tr class="user-rich-editing-wrap">
        <th scope="row"></th>';
		if (get_option("wpll_blogpages") == 1)
		    echo '<td><label for="rich_editing"><input name="wpll_blogpages" type="checkbox" id="wpll_blogpages" value=1 checked>Blog Pages</label></td>';
		else
		    echo '<td><label for="rich_editing"><input name="wpll_blogpages" type="checkbox" id="wpll_blogpages" value=1>Blog Pages</label></td>';
    echo '</tr>
    <tr class="user-rich-editing-wrap">
        <th scope="row"></th>';
		if (get_option("wpll_homepage") == 1)
		    echo '<td><label for="rich_editing"><input name="wpll_homepage" type="checkbox" id="wpll_homepage" value=1 checked>Homepage</label></td>';
		else
		    echo '<td><label for="rich_editing"><input name="wpll_homepage" type="checkbox" id="wpll_homepage" value=1>Homepage</label></td>';
    echo '</tr>
    <tr class="user-rich-editing-wrap">
        <th scope="row"></th>
        <td><label for="rich_editing"><input type="submit" name="wpll_submit" id="wpll_submit" class="button button-primary" value="Save Settings"></label></td>
    </tr>
    </table>';
    wp_nonce_field('WPLL_settings_save', 'WPLL_settings');
    echo '</form>';
    echo '<div class="update-nag"> <a href=" https://www.blasho.com/wp-lazy-loader-plugin/" target="_blank" style="text-decoration: underline">More information on plugin page</a></div>';
}

function WPLL_ScriptLoaderTag($tag, $handle, $src)
{
    if ('wplazyload.js' === $handle)
    {
        return str_replace(' src', ' async="async" src', $tag);
    }

    return $tag;
}

function WPLL_EnqueueScripts()
{
    wp_enqueue_script('lazy-load.min.js', plugins_url('js/wplazyload.js', __FILE__),array('jquery'),'1.0', true);
}

function WPLL_LazyLoad($content)
{
    if(empty($content))
    {
        return $content;
    }

    if ((false !== strpos($content, 'wp-lazy-loader')) || ( false !== strpos($content, 'disable-lazy-loader') ) || is_feed())
    {
        return $content;
    }

    if (is_home() && get_option('wpll_homepage') != 1)
    {
        return $content;
    }
    else if (get_post_type() =='post' && get_option('wpll_blogposts') != 1)
    {
        return $content;
    }
    else if (get_post_type() =='page' && get_option('wpll_blogpages') != 1)
    {
        return $content;
    }

    // look for img and update it
    if(false !== strpos($content,'<img ')){
        $content = preg_replace_callback(
            '#<img([^>]+?)src=[\'"]?([^\'">]+)[\'"]?([^>]*)>#',
            function ($txt)
            {
                $str = $txt[0];
                $str1 = $txt[1];
                $str2 = $txt[2];
                $str3 = $txt[3];
                if(false !== strpos($str, 'disable-lazy'))
                {
                    return $str;
                }
                if(0 === strpos($str2, 'data:image'))
                {
                    return $str;
                }
                return '<img'.$str1.' wp-lazy-loader="'.$str2.'"'.$str3.'><noscript><img '.$str1.'src="'.$str2.'"'.$str3.'></noscript>';
            },
            $content);
    }

    // look for iframe and update it
    if(false !== strpos($content,'<iframe '))
    {
        $content = preg_replace_callback(
            '#<iframe([^>]+?)src=[\'"]?([^\'">]+)[\'"]?([^>]*)>#',
            function($txt)
            {
                $str = $txt[0];
                $str1 = $txt[1];
                $str2 = $txt[2];
                $str3 = $txt[3];
                if(false !== strpos($str, 'disable-lazy'))
                {
                    return $str;
                }
                if(0 === strpos($str2, 'about:blank'))
                {
                    return $str;
                }
                return '<iframe'.$str1.'src="about:blank" wp-lazy-loader="'.$str2.'"'.$str3.'></iframe>';
            }, $content);
    }
    return $content;
}

register_activation_hook(__FILE__, 'WPLL_Install');

function WPLL_Install()
{
    // create fresh options with default values
    add_option('wpll_version', "1.0");
    add_option('wpll_blogposts', 1);
    add_option('wpll_blogpages', 1);
    add_option('wpll_homepage', 1);
}

function WPLL_Operations()
{
    //allow only the admin
    if ($_POST['wpll_submit'] != '')
    {
        // check for submit data
        if (current_user_can('administrator')) 
        {
            //nonce verification
            check_admin_referer('WPLL_settings_save', 'WPLL_settings');

            if (!wp_verify_nonce($_POST['WPLL_settings'], 'WPLL_settings_save'))
            {
                // verification fails
               echo 'Invalid access...';
               exit;
            }
            else
            {
                // all fine, update the new values
                if ($_POST['wpll_blogposts'] == 1)
                    update_option('wpll_blogposts', 1);
                else
                    update_option('wpll_blogposts', 0);

                if ($_POST['wpll_blogpages'] == 1)
                    update_option('wpll_blogpages', 1);
                else
                    update_option('wpll_blogpages', 0);

                if ($_POST['wpll_homepage'] == 1)
                    update_option('wpll_homepage', 1);
                else
                    update_option('wpll_homepage', 0);
            }
        }
    }
}
