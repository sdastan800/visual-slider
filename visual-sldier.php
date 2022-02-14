<?php
/*
Plugin Name: Visual Slider
Description: Drag & Drop Slider anything at any in Visual Composer
Text Domain: visual-slider
Author: Dastan
Version: 1.0
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more dSTails.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin StreST, Fifth Floor, Boston, MA  02110-1301, USA.
 
*/


function visualslider_post_type() {
	$labels = array(
		'name' 					=> __('Slides','visualslider'),
		'singular_name'			=> __('Slide','visualslider'),
		'add_new'				=> __('Add New','visualslider'),
		'add_new_item'			=>__('Add New Slide','visualslider'),
		'edit_item'				=> __('Edit Slide','visualslider'),
		'new_item'				=> __('New Slide','visualslider'),
		'view_item'				=> __('View Slide','visualslider'),
 		'all_items'				=>__('All Slides','visualslider'),
 		'search_items'			=> __('Search Slides','visualslider'),
		'not_found'				=>  __('No slides found','visualslider'),
		'not_found_in_trash'	=>__('No slides found in trash','visualslider'),
		'parent_item_colon'		=> '',
		'menu_name'				=> __('Visual Slider','visualslider')
	);
	
	$args = array(
		'labels'				=> $labels,
		'public'				=> true,
		'publicly_queryable'	=> true,
		'show_ui'				=> true, 
		'show_in_menu'			=> true, 
		'query_var'				=> true,
		'rewrite'				=> true,
		'capability_type'		=> 'post',
		'has_archive'			=> false, 
		'hierarchical'			=> false,
		'menu_position'			=> null,
		'supports' => array( 'title','excerpt','thumbnail' )
	); 

	register_post_type( 'visualslider', $args );
}
add_action( 'init', 'visualslider_post_type' );
 
 
add_action( 'init', 'visualslider_cats_taxonomy', 0 );
function visualslider_cats_taxonomy() {
 
   $labels = array(
    'name'							=> __( 'Sliders','visualslider' ),
    'singular_name'					=> __( 'Slider','visualslider'  ),
    'search_items'					=> __( 'Search Sliders' ,'visualslider' ),
    'popular_items'					=> __( 'Popular Sliders','visualslider'  ),
    'all_items' 					=> __( 'All Sliders' ,'visualslider' ),
    'parent_item'					=> __( 'Parent Slider' ,'visualslider' ),
    'edit_item'						=> __( 'Edit Topic','visualslider' ), 
    'update_item' 					=> __( 'Update Slider','visualslider'  ),
    'add_new_item'					=> __( 'Add New Slider','visualslider'  ),
    'new_item_name'			 		=> __( 'New Topic Name' ,'visualslider' ),
    'separate_items_with_commas'	=> __( 'Separate Sliders with commas' ,'visualslider' ),
    'add_or_remove_items'			=> __( 'Add or remove Sliders','visualslider'  ),
    'choose_from_most_used' 		=> __( 'Choose from the most used Sliders','visualslider'  ),
    'menu_name' 					=> __( 'Sliders' ,'visualslider' ),
  ); 


// Now register the taxonomy

  register_taxonomy('visualslider_cats','visualslider', array(
    'hierarchical' 					=> true,
    'labels' 						=> $labels,
    'show_ui' 						=> true,
    'show_admin_column'				=> true,
    'query_var'						=> true,
    'rewrite' 						=> array( 'slug' => 'visualslider_cats' ),
  ));

}

class visualslider_class
{
	function __construct()
	{
		add_action( 'vc_before_init', array($this, 'vc_advanced_carousal_slider' ));
		add_action( 'wp_enqueue_scripts', array($this, 'adding_front_scripts' ));
		add_action( 'init', array( $this, 'check_if_vc_is_install' ) );
		// remove_filter( 'the_content', 'wpautop' );
	}

		
	function vc_advanced_carousal_slider() {
		include 'render/slide.php';
		include 'render/slide_grid.php';
	}

	function adding_front_scripts() {
		wp_enqueue_style( 'font-awesome', plugin_dir_url( __FILE__ ).'/css/css/font-awesome.min.css' );
	}


	function check_if_vc_is_install(){
        if ( ! defined( 'WPB_VC_VERSION' ) ) {
            // Display notice that Visual Compser is required
            add_action('admin_notices', array( $this, 'showVcVersionNotice' ));
            return;
        }			
	}
	 
}


$tdt_object = new visualslider_class;
  
	 

?>