<?php
/**
 * Plugin Name: UI - Task Plugin
 * Description: A plugin to display recent products, categories, and posts via shortcodes.
 * Version: 1.0
 * Author: Saniyaj Mallik
 *
 * @package Ui-Task-Plugin
 */

// Your code will go here.

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues scripts and styles for the UI Task plugin.
 *
 * This function registers and enqueues the plugin's custom JavaScript and CSS files.
 * The JavaScript file is loaded in the footer for better performance.
 *
 * @since 1.0.0
 */
function ui_task_enqueue_scripts() {
	wp_enqueue_script(
		'ui-task-script',
		plugins_url( 'assets/js/script.js', __FILE__ ),
		array( 'jquery' ),
		'1.0.0',
		true
	);

	wp_enqueue_style(
		'ui-task-style',
		plugins_url( 'assets/css/style.css', __FILE__ ),
		array(),
		'1.0.0'
	);
}
add_action( 'wp_enqueue_scripts', 'ui_task_enqueue_scripts' );



/**
 * Displays recent categories with optional images and links.
 *
 * This shortcode retrieves a specified number of recent categories and displays them with their names, links,
 * and optional images (if ACF field 'category_image' is set for the category).
 *
 * @since 1.0.0
 *
 * @param array $atts {
 *     Shortcode attributes.
 *
 *     @type int $number The number of categories to display. Default 5.
 * }
 * @return string HTML output for the recent categories.
 */
function recent_categories_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'number' => 5,
		),
		$atts,
		'recent_categories'
	);

	$categories = get_categories(
		array(
			'taxonomy'   => 'category',
			'number'     => $atts['number'],
			'orderby'    => 'id',
			'order'      => 'DESC',
			'hide_empty' => false,
		)
	);

	// Check if categories exist.
	if ( ! empty( $categories ) ) {
		$output = '<div class="recent-categories">';
		foreach ( $categories as $category ) {
			$category_id = $category->term_id;
			// Get the category image URL using ACF.
			$category_image = get_field( 'category_image', 'category_' . $category_id );

			$output .= '<div class="category">';
			if ( $category_image ) {
				$output .= '<img class="category-image" src="' . esc_url( $category_image ) . '" alt="' . esc_attr( get_cat_name( $category_id ) ) . '" />';
			}
			$output .= '<a href="' . esc_url( get_term_link( $category ) ) . '">' . esc_html( $category->name ) . '</a>';
			$output .= '</div>';
		}
		$output .= '</div>';
	} else {
		$output = '<p>No categories found.</p>';
	}

	return $output;
}
add_shortcode( 'recent_categories', 'recent_categories_shortcode' );

/**
 * Displays recent items (products or posts) based on the provided attributes.
 *
 * This shortcode allows you to display a list of recent products or posts with optional filtering by category.
 * For products, it also displays the price and featured image.
 *
 * @since 1.0.0
 *
 * @param array $atts {
 *     Shortcode attributes.
 *
 *     @type string $type     The type of items to display. Default 'products'. Accepts 'products' or 'posts'.
 *     @type int    $number   The number of items to display. Default 5.
 *     @type string $category The category slug to filter products by. Default empty.
 * }
 * @return string HTML output for the recent items.
 */
function recent_items_shortcode( $atts ) {
	// Shortcode attributes.
	$atts = shortcode_atts(
		array(
			'type'     => 'products',
			'number'   => 5,
			'category' => '',
		),
		$atts,
		'recent_items'
	);

	// Determine the post type.
	$post_type = ( 'posts' === $atts['type'] ) ? 'post' : 'product';

	// Query arguments.
	$args = array(
		'post_type'      => $post_type,
		'posts_per_page' => $atts['number'],
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	// Filter by category (only for WooCommerce products).
	if ( 'product' === $post_type && ! empty( $atts['category'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $atts['category'],
			),
		);
	}

	$items = new WP_Query( $args );

	if ( $items->have_posts() ) {
		$output = '<div class="recent-items">';
		while ( $items->have_posts() ) {
			$items->the_post();

			// Get the featured image.
			$image = get_the_post_thumbnail( get_the_ID(), 'medium' );
			$permalink = get_permalink();
			$title = get_the_title();

			// Get post excerpt (or WooCommerce short description).
			if ( 'product' === $post_type ) {
				$excerpt = get_the_excerpt();
				$product = wc_get_product( get_the_ID() );
				$price = $product->get_price_html();
			} else {
				$excerpt = wp_trim_words( get_the_excerpt(), 15, '...' ); // Limit words for posts.
			}

			$output .= '<div class="item">';
			if ( $image ) {
				$output .= '<a href="' . esc_url( $permalink ) . '">' . $image . '</a>';
			}
			$output .= '<h3>' . esc_html( $title ) . '</h3>';
			$output .= '<p>' . esc_html( $excerpt ) . '</p>'; // Display short description.

			if ( 'product' === $post_type ) {
				$output .= '<p> <span>' . $price . '</span> <a href="' . esc_url( $permalink ) . '" id="buy-button"> buy </a> </p>';
			} else {
				$output .= '<a href="' . esc_url( $permalink ) . '" class="post-learn-more" >Learn More</a>';
			}

			$output .= '</div>';
		}
		$output .= '</div>';
		wp_reset_postdata();
	} else {
		$output = '<p>No items found.</p>';
	}

	return $output;
}
add_shortcode( 'recent_items', 'recent_items_shortcode' );
