/**
 * WhiteLab 1.0 Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
( function( $ ) {
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title,  .site-description' ).css( {
					'clip': 'auto',
					'position': 'static'
				} );

				$( '.site-title a' ).css( {
					'color': to
				} );
			}
		} );
	} );
	jQuery(document).on('change', '[data-customize-setting-link="whitelab_custom_slider_status"]', function() {
		if ( jQuery(this).val() == 'none' ) {
			jQuery('#customize-control-whitelab_custom_slider_image, #customize-control-whitelab_custom_slider_text, #customize-control-whitelab_custom_slider_color, #customize-control-whitelab_custom_slider_delay, #customize-control-whitelab_custom_slider_alias').slideUp();
		} else if ( jQuery(this).val() == 'split' ) {
			jQuery('#customize-control-whitelab_custom_slider_alias').slideUp();
			jQuery('#customize-control-whitelab_custom_slider_image, #customize-control-whitelab_custom_slider_text, #customize-control-whitelab_custom_slider_color, #customize-control-whitelab_custom_slider_delay').slideDown();
		} else if ( jQuery(this).val() == 'revolution' ) {
			jQuery('#customize-control-whitelab_custom_slider_image, #customize-control-whitelab_custom_slider_text, #customize-control-whitelab_custom_slider_color, #customize-control-whitelab_custom_slider_delay').slideUp();
			jQuery('#customize-control-whitelab_custom_slider_alias').slideDown();
		}
	});
	jQuery(document).on('click', '#accordion-panel-whitelab_header_panel', function() {
		jQuery('[data-customize-setting-link="whitelab_custom_slider_status"]').trigger('change');
	});

	jQuery(document).on('change', '#customize-theme-controls select[data-customize-setting-link*="_fontfamily"]', function() {
		var fontfamilies = [];
		jQuery('#customize-theme-controls select[data-customize-setting-link*="_fontfamily"]').each(function() {
			fontfamilies.push(jQuery(this).find(":selected").val());
		});

		jQuery.ajax({
			type: 'POST',
			url: my_ajax.ajaxurl,
			data: {"action": "reload_gfonts_file", font_family: JSON.stringify(fontfamilies) },
			success: function(response) {
				// console.log(response);

				return false;
			}
		});
	});

	jQuery(document).on('click', '.reset-fonts a', function() {
		jQuery(this).attr('disabled', true);
		jQuery.ajax({
			type: 'POST',
			url: my_ajax.ajaxurl,
			data: {"action": "reset_customizer_fonts" },
			success: function(response) {
				jQuery('.reset-fonts a').attr('disabled', false);
				location.reload();

				return false;
			}
		});
	});
	
} )( jQuery );