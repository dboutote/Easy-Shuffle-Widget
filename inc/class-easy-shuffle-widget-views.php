<?php

/**
 * Easy_Shuffle_Widget_Views Class
 *
 * Handles generation of all front-facing html.
 * All methods are static, this is basically a namespacing class wrapper.
 *
 * @package Easy_Shuffle_Widget
 * @subpackage Easy_Shuffle_Widget_Views
 *
 * @since 1.0
 */


class Easy_Shuffle_Widget_Views
{

	private function __construct(){}


	/**
	 * Builds each list item for the current widget instance.
	 *
	 * Use 'ectabw_banner_html' filter to filter $html before output.
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @param array  $instance   Settings for the current widget instance.
	 * @param bool   $echo       Flag to echo or return the method's output.
	 *
	 * @return string $html Closing tag element for the list item.
	 */
	public static function item( $instance, $echo = true )
	{

		_debug( $instance );

		$banner_text  = ( ! empty( $instance['banner_text'] ) ) ? $instance['banner_text'] : '' ;

		$banner_color = ( ! empty( $instance['banner_color'] ) ) ?  esc_attr( $instance['banner_color'] ) : '#ff0000' ;
		$text_color = ( ! empty( $instance['text_color'] ) ) ?  esc_attr( $instance['text_color'] ) : '#fff' ;

		$banner_url   = ( ! empty( $instance['banner_url'] ) ) ?  esc_url( $instance['banner_url'] ) : '' ;
		$banner_linked = ( ! empty( $instance['banner_linked'] ) && ! empty( $instance['banner_url'] ) ) ? true : false ;

		$item_id    = Easy_Shuffle_Widget_Utils::get_item_id( $instance );
		$item_class = Easy_Shuffle_Widget_Utils::get_item_class( $instance );
		$item_style = Easy_Shuffle_Widget_Utils::get_item_style( $instance );


		ob_start();

		do_action( 'ectabw_item_before', $instance );
		?>
			<div id="banner-<?php echo $item_id ;?>" class="<?php echo $item_class ;?>" <?php echo $item_style; ?>>

				<?php if( $banner_linked ) { ?><a class="ectabw-link" href="<?php echo $banner_url; ?>"> <?php }; ?>

					<?php do_action( 'ectabw_item_top', $instance ); ?>

					<div class="easy-cta-banner-inside">
						<div class="easy-cta-banner-text" style="color:<?php echo $text_color;?>;">
							<?php
							$text = sprintf( __( '%s', 'advanced-categories-widget'), $banner_text );
							echo wpautop( $text )
							?>
						</div>
					</div>

					<?php do_action( 'ectabw_item_bottom', $instance ); ?>

				<?php if( $banner_linked ) { ?> </a> <?php }; ?>

			</div><!-- #banner-## -->
		<?php
		do_action( 'ectabw_item_after', $instance );

		$_html = ob_get_clean();

		$html = apply_filters( 'ectabw_banner_html', $_html, $instance );

		if( $echo ) {
			echo $html;
		} else {
			return $html;
		}
	}


	/**
	 * Outputs plugin attribution
	 *
	 * @access public
	 *
	 * @since 1.0
	 *
	 * @return string Plugin attribution.
	 */
	public static function colophon( $echo = true )
	{
		$attribution = '<!-- Easy Shuffle Widget generated by http://darrinb.com/plugins/easy-shuffle-widget -->';

		if ( $echo ) {
			echo $attribution;
		} else {
			return $attribution;
		}
	}

}