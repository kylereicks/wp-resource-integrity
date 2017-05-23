<?php
/*
 * Plugin Name: Resource Integrity and Cross Origin
 * Plugin URI: https://github.com/kylereicks/resource-integrity-crossorigin
 * Description: Add integrity and crossorigin parameters to script and link resources when the values are set via wp_script_add_data or wp_style_add_data.
 * Version: 0.1.0
 * Author: Kyle Reicks
 * Author URI: https://github.com/kylereicks/
*/
namespace WordPress\Resource\Integrity_CrossOrigin;

add_filter( 'script_loader_tag', __NAMESPACE__ . '\add_integrity_crossorigin', 10, 3 );
add_filter( 'style_loader_tag', __NAMESPACE__ . '\add_integrity_crossorigin', 10, 4 );

/**
 * Add integrity and crossorigin parameters to resources.
 *
 * Add integrity and crossorigin parameters to script and link resources
 * when the values are set via wp_script_add_data or wp_style_add_data.
 *
 * wp_script_add_data( 'script-handle', 'integrity', 'sha384-sDc5PYnGGjKkmKOlkzS+YesGwz4SwiEm6fhX1vbXuVxeS6sSooIz0V3E7y8Gk2CB' );
 * wp_script_add_data( 'script-handle', 'crossorigin', 'anonymous' );
 *
 * wp_style_add_data( 'style-handle', 'integrity', 'sha384-5N3soZvYZ/q8LjWj8vDk5cHod041te75qnL+79nIM6NfuSK5ZJLu5CE6nRu6kefr' );
 * wp_style_add_data( 'style-handle', 'crossorigin', 'anonymous' );
 *
 * @since 0.1.0
 *
 * @global \WP_Scripts $wp_scripts The global WP_Scripts object, containing registered scripts.
 * @global \WP_Styles $wp_styles The global WP_Styles object, containing registered styles.
 *
 * @param string $tag The filtered HTML tag.
 * @param string $handle The handle for the registered script/style.
 * @param string $src The resource URL.
 * @param string $media Optional. The style media value. Equal to null when filtering the script tag.
 * @return string The filtered HTML tag.
 */
function add_integrity_crossorigin( $tag, $handle, $src, $media = null ) {
	global $wp_scripts, $wp_styles;

	if ( null === $media ) {
		$tag_name = 'script';
		$resource_object = $wp_scripts;
	} else {
		$tag_name = 'link';
		$resource_object = $wp_styles;
	}

	if ( ! empty( $resource_object->registered[$handle]->extra['integrity'] ) ) {
		if ( preg_match( '/integrity="[^"]*"/', $tag, $match ) ) {
			$tag = str_replace( $match[0], 'integrity="' . esc_attr( $resource_object->registered[$handle]->extra['integrity'] ) . '"', $tag );
		} else {
			$tag = str_replace( '<' . $tag_name . ' ', '<' . esc_attr( $tag_name ) . ' integrity="' . esc_attr( $resource_object->registered[$handle]->extra['integrity'] ) . '" ', $tag );
		}
	}

	if ( ! empty( $resource_object->registered[$handle]->extra['crossorigin'] ) ) {
		if ( preg_match( '/crossorigin="[^"]*"/', $tag, $match ) ) {
			$tag = str_replace( $match[0], 'crossorigin="' . esc_attr( $resource_object->registered[$handle]->extra['crossorigin'] ) . '"', $tag );
		} else {
			$tag = str_replace( '<' . $tag_name . ' ', '<' . esc_attr( $tag_name ) . ' crossorigin="' . esc_attr( $resource_object->registered[$handle]->extra['crossorigin'] ) . '" ', $tag );
		}
	}

	return $tag;
}
