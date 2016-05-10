/**
 * Plugin js file.
 *
 * @package Easy_Shuffle_Widget
 * @since 1.0.0
 */

/* global widgin, jQuery */

if ( "undefined" === typeof widgin ) { throw new Error( "Easy Shuffle Widget requires Widgins JS" ); }

( function ( $ ) {

    'use strict';


	/**
	 * Accordion functions
	 *
	 * @since 1.0.0
	 */
	$( document ).on( 'widget-added widget-updated', widgin.accordion_form_update );	

	$( '#widgets-right .widget:has( .widgin-widget-form )' ).each( function () {
		widgin.close_accordions( $( this ) );
	} );

	$( '#widgets-right, #accordion-panel-widgets' ).on( 'click', '.widgin-section-top', function( e ) {
		var header = $( this );
		var section = header.closest( '.widgin-section' );
		var fieldset_id = header.data( 'fieldset' );
		var target_fieldset = $( 'fieldset[data-fieldset-id="' + fieldset_id + '"]', section );
		var content = section.find( '.widgin-settings' );

		header.toggleClass( 'widgin-active' );
		target_fieldset.addClass( 'targeted');
		content.slideToggle( 300, function () {
			section.toggleClass( 'expanded' );
		});
	});


	/**
	 * Preview thumbnail size
	 *
	 * @since 1.0.0
	 */

	$( document ).on( 'widget-added widget-updated', widgin.thumbnail_form_update );

	// Change thumb size when form field changes
	$( '#customize-controls, #wpcontent' ).on( 'change', '.widgin-thumb-size', function ( e ) {
		var widget = $(this).closest('.widget');
		widgin.update_thumbnail_preview( widget );
		return;
	});

	// Change thumb size as user types
	$( '#customize-controls, #wpcontent' ).on( 'keyup', '.widgin-thumb-size', function ( e ) {
		var widget = $(this).closest('.widget');
		setTimeout( function(){
			widgin.update_thumbnail_preview( widget );
		}, 300 );
		return;
	});

	$( '#widgets-right .widget:has( .widgin-thumbnail-preview )' ).each( function () {
		widgin.update_thumbnail_preview( $(this) );
	});


	/**
	 * Preview excerpt size
	 *
	 * @since 1.0.0
	 */

	$( document ).on( 'widget-added widget-updated', widgin.excerpt_form_update );

	// Change excerpt size when form field changes
	$( '#customize-controls, #wpcontent' ).on( 'change', '.widgin-excerpt-length', function ( e ) {
		var widget = $(this).closest('.widget');
		widgin.update_excerpt_preview( widget );
		return;
	});

	// Change excerpt size as user types
	$( '#customize-controls, #wpcontent' ).on( 'keyup', '.widgin-excerpt-length', function ( e ) {
		var widget = $(this).closest('.widget');
		setTimeout( function(){
			widgin.update_excerpt_preview( widget );
		}, 300 );
		return;
	});

	$( '#widgets-right .widget:has( .widgin-excerpt-preview )' ).each( function () {
		widgin.update_excerpt_preview( $(this) );
	});


}( jQuery ) );