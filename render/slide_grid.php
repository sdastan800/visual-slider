<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

class visualslider_posts_grid extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'style'				=>		'mega-post-carousel1',
			'settings'			=>		'',
			'height'			=>		'200px',
			'img_padding'		=>		'15px',
			'grid'				=>		'3',
			'excerpt'			=>		'120',
			'comment'			=>		'block',
			'catg'				=>		'visible',
			'imgheight'			=>		'200px',
			'txtsize'			=>		'18px',
			'descsize'			=>		'14px',
			'themeclr'			=>		'#1D5B84',
			'txtclr'			=>		'#000',
			'dateclr'			=>		'#000',
			'descclr'			=>		'#888',
			'css'				=>		'',
		), $atts ) );
		if (isset($image_id) &&  $image_id != '') {
			$image_url = wp_get_attachment_url( $image_id );		
		}
		// var_dump($settings);
		$content = wpb_js_remove_wpautop($content);
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		wp_enqueue_style( 'post-design-css', plugins_url( '../css/post-design.css' , __FILE__ ));
		wp_enqueue_style( 'grid-css', plugins_url( '../css/simplegrid.css' , __FILE__ ));
		wp_enqueue_script( 'custom-height', plugins_url( '../js/jquery.matchHeight-min.js' , __FILE__ ), array('jquery'));
		ob_start();
		$args = array(
			'posts_per_page' => -1,
		);
		$seperate_settings = explode('|', $settings);

		foreach ($seperate_settings as $setting) {
			$key_val = explode(':', $setting);
			if ($key_val[0] == 'size') {
				$args['posts_per_page'] = $key_val[1];
			} elseif($key_val[0] == 'categories') {
				$args['category__in'] = explode(',', $key_val[1]);
			} else {
				$args[$key_val[0]] = $key_val[1];
			}
		}

		// The Query
		$the_query = new WP_Query( $args );

		// The Loop
		if ( $the_query->have_posts() ) { ?>
						<div class="na-prefix">
							<div class="grid grid-pad"> 
			<?php while ( $the_query->have_posts() ) { ?>
				<?php $the_query->the_post(); ?>

					<?php switch ($style) {
						case 'mega-post-carousel1':
							include 'includes/style1.php';
							break;
						case 'mega-post-carousel2':
							include 'includes/style2.php';
							break;
						case 'mega-post-carousel3':
							include 'includes/style3.php';
							break;
						case 'mega-post-carousel4':
							include 'includes/style4.php';
							break;
						case 'mega-post-carousel5':
							include 'includes/style5.php';
							break;
						case 'carousel-style19':
							include 'includes/style6.php';
							break;
						case 'carousel-style17':
							include 'includes/style7.php';
							break;
						
						default:
							include 'includes/style1.php';
							break;
					} ?>

			<?php } ?>

							</div>
						</div>
			<?php wp_reset_postdata();
		} else {
			// no posts found
		}

		return ob_get_clean();
	}
}


vc_map( array(
	"base" 			=> "na_posts_grid",
	"name" 			=> __( 'Post Grid', 'visualslider' ),
	"category" 		=> __('ADC Slider'),
	"description" 	=> __('show posts as grid layout', ''),
	"icon" => plugin_dir_url( __FILE__ ).'../icons/post-carousel.png',
	'params' => array(
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Choose Style', 'visualslider' ),
			"param_name" 	=> 	"style",
			"group" 		=> 'General',
			"value" 		=> 	array(
				"Style 1" 		=> 		"mega-post-carousel1",
				"Style 2" 		=> 		"mega-post-carousel2",
				"Style 3" 		=> 		"mega-post-carousel3",
				"Style 4" 		=> 		"mega-post-carousel4",
				"Style 5" 		=> 		"mega-post-carousel5",
				"Style 6" 		=> 		"carousel-style19",
				"Style 7" 		=> 		"carousel-style17",
			)
		),

		array(
			"type" 			=> 	"loop",
			"heading" 		=> 	__( 'Link To', 'visualslider' ),
			"param_name" 	=> 	"settings",
			"description"	=>	"Choose which post you want to show",
			"group" 		=> 'General',
		),

		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Image height', 'visualslider' ),
			"param_name" 	=> 	"height",
			"description"	=>	__('post images height, set in pixel', 'visualslider'),
			"group" 		=> 'Settings',
			"value"			=>	"200px",
		),

		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Padding', 'visualslider' ),
			"param_name" 	=> 	"img_padding",
			"description"	=>	__('padding between two post image from left and right side, set in pixel', 'visualslider'),
			"group" 		=> 'Settings',
			"value"			=>	"15px",
		),

		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Visible Posts/Row', 'visualslider' ),
			"param_name" 	=> 	"grid",
			"description"	=>	__('how many post show in one row', 'visualslider'),
			"group" 		=> 'Settings',
			"value" 		=> 	array(
				"2" 			=> 		"2",
				"3" 			=> 		"3",
				"4" 			=> 		"4",
				"5" 			=> 		"5",
				"6" 			=> 		"6",
			)
		),

		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Content Excerpt', 'visualslider' ),
			"param_name" 	=> 	"excerpt",
			"description"	=>	"visible content length, write only numbers default 120",
			"value"			=>	"120",
			"group" 		=> 'Settings',
		),
		 
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Comments', 'visualslider' ),
			"param_name" 	=> 	"comment",
			"description"	=>	__('show/hide comment icon', 'visualslider'),
			"group" 		=> 'Settings',
			"value" 		=> 	array(
				"Show" 		=> 		"block",
				"Hide" 	=> 		"none",
			)
		),
		array(
			"type" 			=> 	"dropdown",
			"heading" 		=> 	__( 'Category', 'visualslider' ),
			"param_name" 	=> 	"catg",
			"description"	=>	__('show/hide category name', 'visualslider'),
			"group" 		=> 'Settings',
			"value" 		=> 	array(
				"Show" 		=> 		"visible",
				"Hide" 	=> 		"none",
			)
		),

		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Title (Font Size)', 'visualslider' ),
			"param_name" 	=> 	"txtsize",
			"description"	=>	"font size of post title, default 18px",
			"value"			=>	"18px",
			"group" 		=> 'Design',
		),

		array(
			"type" 			=> 	"textfield",
			"heading" 		=> 	__( 'Description (Font Size)', 'visualslider' ),
			"param_name" 	=> 	"descsize",
			"description"	=>	"font size of post content, default 14px",
			"value"			=>	"14px",
			"group" 		=> 'Design',
		),

		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Theme Color', 'visualslider' ),
			"param_name" 	=> 	"themeclr",
			"description"	=>	"It will apply as default colors for post",
			"dependency" => array('element' => "style", 'value' => array('carousel-style8', 'carousel-style17', 'carousel-style19')),
			"value"			=>	"#1D5B84",
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Title Color', 'visualslider' ),
			"param_name" 	=> 	"txtclr",
			"description"	=>	"color of post title",
			"value"			=>	"#000",
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Author/Date Color', 'visualslider' ),
			"param_name" 	=> 	"dateclr",
			"description"	=>	"color of author/date",
			"value"			=>	"#000",
			"group" 		=> 'Color',
		),

		array(
			"type" 			=> 	"colorpicker",
			"heading" 		=> 	__( 'Description Color', 'visualslider' ),
			"param_name" 	=> 	"descclr",
			"description"	=>	"color of post content",
			"value"			=>	"#888",
			"group" 		=>  'Color',
		),

		array(
			"type" 			=> 	"css_editor",
			"heading" 		=> 	__( 'Display Design', 'visualslider' ),
			"param_name" 	=> 	"css",
			"description"	=>	"color of post content",
			"group" 		=>  'Design Options',
		),
	),
) );
