<?php
/**
* Plugin Name: Very First Plugin
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Marcian Carutasu
* Author URI: http://yourwebsiteurl.com/
**/

/**
 * gets the link for the current post
 * applies the anchor text “Click to Read!”
 **/
function dh_modify_read_more_link() {

    return '<a class="more-link" href="' . get_permalink() . '">Continue reading</a>';

}

/**
 * uses a filter to hook into a function called the_content_more_link, which represents the Read More link.
 * The filter instructs WordPress to call our new function instead, so the standard link will be replaced with our new version.
 */
add_filter( 'the_content_more_link', 'dh_modify_read_more_link' );