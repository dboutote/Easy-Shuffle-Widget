<?php

/**
 * Easy_Shuffle_Widget_Utils Class
 *
 * All methods are static, this is basically a namespacing class wrapper.
 *
 * @package The_Whichit_Widget
 * @subpackage Easy_Shuffle_Widget_Utils
 *
 * @since 1.0
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 * Easy_Shuffle_Widget_Utils Class
 *
 * Group of utility methods for use by Easy_Shuffle_Widget
 *
 * @since 1.0
 */
class Easy_Shuffle_Widget_Utils
{

	/**
	 * Plugin root file
	 *
	 * @since 1.0
	 *
	 * @var string
	 */
	public static $base_file = EASY_SHUFFLE_WIDGET_FILE;


	/**
	 * Generates path to plugin root
	 *
	 * @uses WordPress plugin_dir_path()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return string $path Path to plugin root.
	 */
	public static function get_plugin_path()
	{
		$path = plugin_dir_path( self::$base_file );
		return $path;
	}


	/**
	 * Generates path to subdirectory of plugin root
	 *
	 * @see Easy_Shuffle_Widget_Utils::get_plugin_path()
	 *
	 * @uses WordPress trailingslashit()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param string $directory The name of the requested subdirectory.
	 *
	 * @return string $sub_path Path to requested sub directory.
	 */
	public static function get_plugin_sub_path( $directory )
	{
		if( ! $directory ){
			return false;
		}

		$path = self::get_plugin_path();

		$sub_path = $path . trailingslashit( $directory );

		return $sub_path;
	}


	/**
	 * Generates url to plugin root
	 *
	 * @uses WordPress plugin_dir_url()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return string $url URL of plugin root.
	 */
	public static function get_plugin_url()
	{
		$url = plugin_dir_url( self::$base_file );
		return $url;
	}


	/**
	 * Generates url to subdirectory of plugin root
	 *
	 * @see Easy_Shuffle_Widget_Utils::get_plugin_url()
	 *
	 * @uses WordPress trailingslashit()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param string $directory The name of the requested subdirectory.
	 *
	 * @return string $sub_url URL of requested sub directory.
	 */
	public static function get_plugin_sub_url( $directory )
	{
		if( ! $directory ){
			return false;
		}

		$url = self::get_plugin_url();

		$sub_url = $url . trailingslashit( $directory );

		return $sub_url;
	}


	/**
	 * Generates basename to plugin root
	 *
	 * @uses WordPress plugin_basename()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return string $basename Filename of plugin root.
	 */
	public static function get_plugin_basename()
	{
		$basename = plugin_basename( self::$base_file );
		return $basename;
	}


	/**
	 * Sets default parameters
	 *
	 * Use 'eshuflw_instance_defaults' filter to modify accepted defaults.
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return array $defaults The default values for the widget.
	 */
	public static function instance_defaults()
	{
		$_defaults = array(
			'title'          => __( 'Shuffle', 'easy-shuffle-widget' ),
			'item_type'      => 'any',
			'show_thumb'     => 1,
			'thumb_size_w'   => 55,
			'thumb_size_h'   => 55,
			'excerpt_length' => 15,
			'css_default'    => 0,
		);

		$defaults = apply_filters( 'eshuflw_instance_defaults', $_defaults );

		return $defaults;
	}



	/**
	 * Builds a sample excerpt
	 *
	 * Use 'eshuflw_sample_excerpt' filter to modify excerpt text.
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return string $excerpt Excerpt text.
	 */
	public static function sample_excerpt()
	{
		$excerpt = __( 'The point of the foundation is to ensure free access, in perpetuity, to the software projects we support. People and businesses may come and go, so it is important to ensure that the source code for these projects will survive beyond the current contributor base, that we may create a stable platform for web publishing for generations to come. As part of this mission, the Foundation will be responsible for protecting the WordPress, WordCamp, and related trademarks. A 501(c)3 non-profit organization, the WordPress Foundation will also pursue a charter to educate the public about WordPress and related open source software.');
		return apply_filters( 'eshuflw_sample_excerpt', $excerpt );
	}


	/**
	 * Retrieves post types to use in widget
	 *
	 * Use 'eshuflw_get_post_type_args' to filter arguments for retrieving post types.
	 * Use 'eshuflw_allowed_post_types' to filter post types that can be selected in the widget.
	 *
	 * @see Easy_Shuffle_Widget_Utils::sanitize_select_array()
	 *
	 * @uses WordPress get_post_types()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return array $types Allowed post types.
	 */
	public static function get_allowed_post_types()
	{
		$args = apply_filters( 'eshuflw_get_post_type_args', array( 'public' => true) );
		$post_types = get_post_types( $args, 'objects' );

		if( empty( $post_types ) ){
			return false;
		}

		foreach( $post_types as $post_type ){
			$query_var = ( ! $post_type->query_var ) ? $post_type->name : $post_type->query_var ;
			$_ptypes[ $query_var ] = $post_type->labels->singular_name;
		}

		$types = apply_filters( 'eshuflw_allowed_post_types', $_ptypes );

		return $types;
	}


	/**
	 * Retrieves item types to use in widget
	 *
	 * Use 'eshuflw_allowed_item_types' to filter item types that can be selected in the widget.
	 *
	 * @see Easy_Shuffle_Widget_Utils::sanitize_select_array()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return array $types Allowed post types.
	 */
	public static function get_allowed_item_types()
	{
		$post_types = self::get_allowed_post_types();

		$_types = array();
		$_types['any']     = __( 'Any', 'easy-shuffle-widget' );
		$_types['comment'] = __( 'Comment', 'easy-shuffle-widget' );
		$_types['user']    = __( 'User Bio', 'easy-shuffle-widget' );
		#$_types['image']   = __( 'Image', 'easy-shuffle-widget' );

		$types = array_merge( $_types, (array) $post_types );
		$types = array_unique( $types );

		// unset the attachment type; we're only allowing images as of 1.0
		if( ! empty( $types['attachment'] ) ) {
			unset( $types['attachment'] );
		}

		// unset the page type; plugins can always add it back in
		if( ! empty( $types['page'] ) ) {
			unset( $types['page'] );
		}

		$types = apply_filters( 'eshuflw_allowed_item_types', $types );

		return $types;
	}



	/**
	 * Selects a random item type from the allowed items types
	 *
	 * @see Easy_Shuffle_Widget::widget()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Current widget settings.
	 * @param object $widget   Widget Object.
	 *
	 * @return string $type Slug of the item type to retrieve, e.g., 'comment', 'post', 'user'.
	 */
	public static function get_random_item_type( $instance, $widget )
	{
		$_types = Easy_Shuffle_Widget_Utils::get_allowed_item_types();
		$_types = Easy_Shuffle_Widget_Utils::sanitize_select_array( $_types );

		if( ! empty( $_types['any'] ) ){
			unset( $_types['any'] );
		}

		$_types = array_keys( $_types );

		shuffle( $_types );

		$_type = $_types[0];

		$type = apply_filters( 'eshuflw_random_item_type', $_type );

		return $type;
	}



	/**
	 * Retrieves a random item object for the current widget instance
	 *
	 * @see Easy_Shuffle_Widget::widget()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param string $item_type Slug of the item type to retrieve; e.g., 'comment', 'post', 'user'.
	 * @param array  $instance  Current widget settings.
	 * @param object $widget    Widget Object.
	 *
	 * @return object $item The retrieved object; e.g., post, comment, custom post type, user.
	 */
	public static function get_random_item_obj( $item_type, $instance, $widget )
	{
		$exclude_id = 0;

		$last_shown = self::get_last_shown_item( $instance, $widget );

		// if $last_shown is empty, it means nothing has been shown yet
		if( ! empty( $last_shown ) ) {
			$exclude_id = $last_shown['item_id'];
		}

		switch( $item_type ){

			case 'comment' :
				$item = self::get_random_comment( $exclude_id, $instance, $widget );
				break;
			case 'user' :
				$item = self::get_random_user( $exclude_id, $instance, $widget );
				break;
			default :
				$item = self::get_random_post( $exclude_id, $instance, $widget );
				break;
		}
		
		if( is_null( $item ) || ! $item || empty( $item ) ) {
			$item = array();
		}

		return $item;
	}



	/**
	 * Retrieves a random comment for the current widget instance
	 *
	 * @see Easy_Shuffle_Widget_Utils::get_random_item_obj()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param int    $exclude_id The id of the previously shown comment.
	 * @param array  $instance   Current widget settings.
	 * @param object $widget     Widget Object.
	 *
	 * @return object $item The retrieved object; e.g., post, comment, custom post type, user.
	 */
	public static function get_random_comment( $exclude_id, $instance, $widget )
	{
		$args = array(
			'number'          => '',
			'status'          => 'approve',
			'type'            => 'comment',
			'fields'          => 'ids',
		);

		$args = apply_filters( 'eshuflw_get_random_comment_args', $args );

		$ids = get_comments( $args );

		if( is_array( $ids ) ) {
			if( ( $key = array_search( $exclude_id, $ids ) ) !== false ) {
				unset( $ids[$key] );
			}		
			$id = $ids[mt_rand(0, count($ids) - 1)];
		}
	
		$item = get_comment( $id );

		return $item;
	}







	/**
	 * Retrieves the last shown item for the current widget instance
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Current widget settings.
	 * @param object $widget   Widget Object.
	 *
	 * @return array $shown_item The last shown item or an empty array.
	 */
	public static function get_last_shown_item( $instance, $widget )
	{
		$shown_items = get_option( 'eshuflw_shown_items' );

		if( ! $shown_items ) {
			return array();
		}

		$widget_id = $instance['widget_id'];

		if ( empty( $shown_items[ $widget_id ] ) ) {
			return array();
		}

		$shown_item = $shown_items[ $widget_id ];

		return $shown_item;
	}



	public static function stick_item( $widget_id, $shown_item = array() )
	{

		// have to store: widget id, item type, item id

		$widgets = get_option( 'eshuflw_shown_items' );

		if ( ! is_array( $widgets ) ) {
			$widgets = array();
		}

		$widgets[ $widget_id ] = $shown_item ;

		update_option('eshuflw_shown_items', $widgets);

	}


	public static function unstick_item( $widget_id )
	{
		$widgets = get_option( 'eshuflw_shown_items' );

		if ( ! is_array( $widgets ) ) {
			return;
		}

		if ( empty( $widgets[ $widget_id ] ) ) {
			return;
		}

		unset( $widgets[ $widget_id ] );

		update_option( 'eshuflw_shown_items', $widgets );
	}


	/**
	 * Adds a widget to the eshuflw_use_css option
	 *
	 * If css_default option is selected in the widget, this will add a reference to that
	 * widget instance in the eshuflw_use_css option.  The 'eshuflw_use_css' option determines if the
	 * default stylesheet is enqueued on the front end.
	 *
	 * @uses WordPress get_option()
	 * @uses WordPress update_option()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param string $widget_id Widget instance ID.
	 */
	public static function stick_css( $widget_id )
	{
		$widgets = get_option( 'eshuflw_use_css' );

		if ( ! is_array( $widgets ) ) {
			$widgets = array( $widget_id );
		}

		if ( ! in_array( $widget_id, $widgets ) ) {
			$widgets[] = $widget_id;
		}

		update_option('eshuflw_use_css', $widgets);
	}


	/**
	 * Removes a widget from the eshuflw_use_css option
	 *
	 * If css_default option is unselected in the widget, this will remove (if applicable) a
	 * reference to that widget instance in the eshuflw_use_css option. The 'eshuflw_use_css' option
	 * determines if the default stylesheet is enqueued on the front end.
	 *
	 * @uses WordPress get_option()
	 * @uses WordPress update_option()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param string $widget_id Widget instance ID.
	 */
	public static function unstick_css( $widget_id )
	{
		$widgets = get_option( 'eshuflw_use_css' );

		if ( ! is_array( $widgets ) ) {
			return;
		}

		if ( ! in_array( $widget_id, $widgets ) ) {
			return;
		}

		$offset = array_search($widget_id, $widgets);

		if ( false === $offset ) {
			return;
		}

		array_splice( $widgets, $offset, 1 );

		update_option( 'eshuflw_use_css', $widgets );
	}


	/**
	 * Prints link to default widget stylesheet
	 *
	 * Actual stylesheet is enqueued if the user selects to use default styles
	 *
	 * @see Easy_Shuffle_Widget::widget()
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance Current widget settings.
	 * @param object $widget   Widget Object.
	 * @param bool   $echo     Flag to echo|return output.
	 *
	 * @return string $css_url Stylesheet link.
	 */
	public static function css_preview( $instance, $widget, $echo = true )
	{
		$_css_url =  self::get_plugin_sub_url( 'css' ) . 'front.css' ;

		$css_url = sprintf('<link rel="stylesheet" href="%s" type="text/css" media="all" />',
			esc_url( $_css_url )
		);

		if( $echo ) {
			echo $css_url;
		} else {
			return $css_url;
		}
	}


	/**
	 * Generates unique list-item id based on widget instance
	 *
	 * Use 'eshuflw_item_id' filter to modify item ID before output.
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @param array  $instance Widget instance.
	 *
	 * @return string $item_id Filtered item ID.
	 */
	public static function get_item_id( $instance = array() )
	{
		$_item_id = $instance['widget_id'];

		$item_id = sanitize_html_class( $_item_id );

		return apply_filters( 'eshuflw_item_id', $item_id, $instance );
	}


	/**
	 * Generate item classes
	 *
	 * Use 'eshuflw_item_class' filter to modify item classes before output.
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @param array  $instance Widget instance.
	 *
	 * @return string $class_str CSS classes.
	 */
	public static function get_item_class( $instance = array() )
	{

		$_classes = array();
		$_classes[] = 'ectabw-item';
		$_classes[] = 'ectabw-banner';
		$_classes[] = 'easy-cta-banner';

		$classes = apply_filters( 'eshuflw_item_class', $_classes, $instance );
		$classes = ( ! is_array( $classes ) ) ? (array) $classes : $classes ;
		$classes = array_map( 'sanitize_html_class', $classes );

		$class_str = implode( ' ', $classes );

		return $class_str;
	}


	/**
	 * Generates unique item style widget instance
	 *
	 * Use 'eshuflw_item_style' filter to modify item ID before output.
	 *
	 * @access public
	 * @since 1.0
	 *
	 * @param array  $instance Widget instance.
	 *
	 * @return string $item_id Filtered item ID.
	 */
	public static function get_item_style( $instance = array() )
	{
		$banner_color = ( ! empty( $instance['banner_color'] ) ) ?  esc_attr( $instance['banner_color'] ) : '#ff0000' ;

		$_style = ' style="background-color:' . $banner_color . ';"';

		return apply_filters( 'eshuflw_item_style', $_style, $instance );
	}


	/**
	 * Cleans array of keys/values used in select drop downs
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array $options Values used for select options
	 * @param bool  $sort    Flag to sort the values alphabetically.
	 *
	 * @return array $options Sanitized values.
	 */
	public static function sanitize_select_array( $options, $sort = true )
	{
		$options = ( ! is_array( $options ) ) ? (array) $options : $options ;

		// Clean the values (since it can be filtered by other plugins)
		$options = array_map( 'esc_html', $options );

		// Flip to clean the keys (used as <option> values in <select> field on form)
		$options = array_flip( $options );
		$options = array_map( 'sanitize_key', $options );

		// Flip back
		$options = array_flip( $options );

		if( $sort ) {
			asort( $options );
		};

		return $options;
	}

}