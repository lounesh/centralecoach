(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */

})( jQuery );

jQuery(document).ready(function($) {
	jQuery(document).on('click', '.db-image-upload', function() {
		if ( !jQuery(this).parent().find('.db-settings-default_listing_image').length ) {
			var $wpimageupload = jQuery(this).parent().find('.upload-field-value');
		} else {
			var $wpimageupload = jQuery(this).parent().find('.db-settings-default_listing_image');
		}

		if ( jQuery(this).parent().find('.db-create-package_img').length ) {
			var $wpimageupload = jQuery(this).parent().find('.db-create-package_img');
		}

		if ( jQuery(this).parent().find('.db-create-field_img').length ) {
			var $wpimageupload = jQuery(this).parent().find('.db-create-field_img');
		}

		if ( jQuery(this).parent().find('.db-settings-invoice_logo').length ) {
			var $wpimageupload = jQuery(this).parent().find('.db-settings-invoice_logo');
		}
		
		var $wpimagedelete = jQuery(this).parent().find('.db-image-delete');
		var $wpimagecontainer = jQuery(this).parent().find('.db-image-container');
		
		var image = wp.media({ 
			title: 'Upload Image',
			multiple: false
		}).open().on('select', function(e){
			var uploaded_image = image.state().get('selection').first();
			var image_url = uploaded_image.toJSON().url;
			$wpimageupload.val(image_url);
			$wpimagedelete.show();
			if ( !$wpimagecontainer.find('img').length ) {
				$wpimagecontainer.append('<img src="'+image_url+'" alt="">');
			} else {
				$wpimagecontainer.find('img').attr('src', image_url);
			}
		});
	});
	jQuery(document).on('click', '.db-image-delete', function() {
		jQuery(this).parent().find('.db-image-container').html('');
		if ( jQuery(this).parent().find('.upload-field-value').length ) {
			jQuery(this).parent().find('.upload-field-value').val('');
		} else if ( jQuery(this).parent().find('.db-settings-default_listing_image').length ) {
			jQuery(this).parent().find('.db-settings-default_listing_image').val('');
		} else if ( jQuery(this).parent().find('.db-create-package_img').length ) {
			jQuery(this).parent().find('.db-create-package_img').val('');
		} else if ( jQuery(this).parent().find('.db-create-field_img').length ) {
			jQuery(this).parent().find('.db-create-field_img').val('');
		} else if ( jQuery(this).parent().find('.db-settings-invoice_logo').length ) {
			jQuery(this).parent().find('.db-settings-invoice_logo').val('');
		}
		jQuery(this).hide();
	});

	jQuery(document).on('input', '.db-create-field-name', function(event) {
		// Allow only a-z characters
		var re = /[a-z]+/g; 
		var str = jQuery(this).val();
		var m;
		var new_str = '';
		 
		while ((m = re.exec(str)) !== null) {
			if (m.index === re.lastIndex) {
				re.lastIndex++;
			}
			new_str += m['0'];
		}
		jQuery(this).val(new_str);
	});

	jQuery(document).on('click', '.db-proceed-field', function() {
		window.location.href = window.location.href + '&field_type='+jQuery('.db-field-type').val();
	});

	jQuery(document).on('click', '.db-add-new-field', function() {
		jQuery('.db-custom-field-dialog, .db-dialog-overlay').show();
	});

	jQuery(document).on('click', '.db-save-field', function() {
		var all_field_values = {};
		var invalid_count = 0;
		jQuery('[class^="db-create-"]').parent().parent().removeClass('invalid');
		jQuery('[class^="db-create-"]').each(function() {
			if ( jQuery(this).attr('data-required') == 'true' && jQuery(this).val() == '' ) {
				jQuery(this).parent().parent().addClass('invalid');
				invalid_count++;
			}

			var field_name = jQuery(this).attr('class').replace('db-create-', '').replace('-', '_');
			all_field_values[field_name] = jQuery(this).val();
		});

		if ( invalid_count > 0 ) {
			jQuery("html, body").animate({ scrollTop: 0 }, "slow");
			return;
		}

		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_save_field',
				'field_settings': JSON.stringify(all_field_values),
				'save_type': jQuery(this).attr('data-save'),
				'field_id': jQuery(this).attr('data-id')
			},
			success: function(data) {
				if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
					window.location = jQuery.parseJSON(data).redirect;
				}
			}
		});
	});

	jQuery(document).on('click', '.db-save-reg-field', function() {
		var all_field_values = {};
		var invalid_count = 0;
		jQuery('[class^="db-create-"]').parent().parent().removeClass('invalid');
		jQuery('[class^="db-create-"]').each(function() {
			if ( jQuery(this).attr('data-required') == 'true' && jQuery(this).val() == '' ) {
				jQuery(this).parent().parent().addClass('invalid');
				invalid_count++;
			}

			var field_name = jQuery(this).attr('class').replace('db-create-', '').replace('-', '_');
			all_field_values[field_name] = jQuery(this).val();
		});

		if ( invalid_count > 0 ) {
			jQuery("html, body").animate({ scrollTop: 0 }, "slow");
			return;
		}

		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_save_reg_field',
				'field_settings': JSON.stringify(all_field_values),
				'save_type': jQuery(this).attr('data-save'),
				'field_id': jQuery(this).attr('data-id')
			},
			success: function(data) {
				if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
					window.location = jQuery.parseJSON(data).redirect;
				}
			}
		});
	});

	jQuery(document).on('click', '.db-save-package', function() {
		var all_package_values = {};
		jQuery('[class^="db-create-"]').each(function() {
			var package_name = jQuery(this).attr('class').replace('db-create-', '');
			if ( jQuery(this).attr('type') != 'checkbox' ) {
				all_package_values[package_name] = jQuery(this).val();
			} else {
				all_package_values[package_name] = jQuery(this).prop('checked');
			}
		});

		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_save_package',
				'package_settings': JSON.stringify(all_package_values),
				'save_type': jQuery(this).attr('data-save'),
				'package_id': jQuery(this).attr('data-id')
			},
			success: function(data) {
				if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
					window.location = jQuery.parseJSON(data).redirect;
				}
			}
		});
	});

	jQuery(document).on('click', '.db-delete-field', function() {
		var field_id = jQuery(this).attr('data-id');
		var deletable_row = jQuery(this).parent().parent();
		if ( confirm('Are you sure you want to delete this field?') ) {
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: { 
					'action': 'db_delete_field',
					'field_id': field_id
				},
				success: function(data) {
					if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
						deletable_row.remove();
					}
				}
			});
		}
	});

	jQuery(document).on('click', '.db-delete-reg-field', function() {
		var field_id = jQuery(this).attr('data-id');
		var deletable_row = jQuery(this).parent().parent();
		if ( confirm('Are you sure you want to delete this field?') ) {
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: { 
					'action': 'db_delete_reg_field',
					'field_id': field_id
				},
				success: function(data) {
					if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
						deletable_row.remove();
					}
				}
			});
		}
	});

	jQuery(document).on('click', '.db-save-settings', function() {
		var all_setting_values = {};
		var invalid_count = 0;
		jQuery('[class^="db-settings-"]').parent().parent().removeClass('invalid');

		// Save currently selected search fields
		directory_prepare_search_fields();
		jQuery(".db-confirm-layout").trigger('click');
		
		jQuery('[class^="db-settings-"]').each(function() {
			if ( jQuery('.db-settings-payment_active').val() == 'yes' && jQuery(this).attr('data-required') == 'true' && jQuery(this).val() == '' ) {
				jQuery(this).parent().parent().addClass('invalid');
				invalid_count++;
			}
			var setting_name = jQuery(this).attr('class').replace('db-settings-', '').replace('-', '_');
			if ( jQuery(this).attr('type') != 'checkbox' ) {
				all_setting_values[setting_name] = jQuery(this).val();
			} else {
				all_setting_values[setting_name] = jQuery(this).prop('checked');
			}
		});

		if ( invalid_count > 0 ) {
			return;
		}

		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_save_settings',
				'db_settings': JSON.stringify(all_setting_values),
			},
			success: function(data) {
				if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
					window.location = window.location.href;
				}
			}
		});
	});

	jQuery(document).on('click', '.db-save-templates', function() {
		var all_setting_values = {};
		jQuery('[class^="db-template-"]').each(function() {
			var setting_name = jQuery(this).attr('class').replace('db-template-', '').replace('-', '_');
			all_setting_values[setting_name] = jQuery(this).val();
		});

		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_save_templates',
				'db_templates': JSON.stringify(all_setting_values),
			},
			success: function(data) {
				if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
					window.location = window.location.href;
				}
			}
		});
	});

	jQuery(document).on('click', '.db-checkbox', function() {
		if ( jQuery(this).find('input').prop('checked') ) {
			jQuery(this).removeClass('active');
			jQuery(this).find('input').prop('checked', false);
		} else {
			jQuery(this).addClass('active');
			jQuery(this).find('input').prop('checked', true);
		}
	});

	jQuery(document).on('focus', '.db-field-row input, .db-field-row textarea', function() {
		jQuery(this).parent().parent().addClass('focused').addClass('active');
	});

	jQuery(document).on('blur', '.db-field-row input, .db-field-row textarea', function() {
		jQuery(this).parent().parent().removeClass('focused');
		if ( jQuery(this).val() == '' ) {
			jQuery(this).parent().parent().removeClass('active');
		}
	});

	jQuery(document).on('click', '.db-delete-package', function() {
		var package_id = jQuery(this).attr('data-id');
		var deletable_row = jQuery(this).parent().parent();
		if ( confirm('Are you sure you want to delete this package?') ) {
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: { 
					'action': 'db_delete_package',
					'package_id': package_id
				},
				success: function(data) {
					if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
						deletable_row.remove();
					}
				}
			});
		}
	});

	jQuery(document).on('change', '.db-create-listing_run_type', function() {
		if ( jQuery(this).val() == 'days' ) {
			jQuery('.db-create-listing_run_days').parent().parent().show();
		} else {
			jQuery('.db-create-listing_run_days').parent().parent().hide();
		}
	});
	jQuery('.db-create-listing_run_type').trigger('change');

	jQuery(document).on('change', '.db-create-payment_type', function() {
		if ( jQuery(this).val() == 'onetime' ) {
			jQuery('.db-create-payment_cycle').parent().parent().hide();
			jQuery('.db-create-payment_interval').parent().parent().hide();
			jQuery('.db-create-listing_run_type').parent().parent().show();
			jQuery('.db-create-listing_run_days').parent().parent().show();
			jQuery('.db-create-trial_period').parent().parent().parent().hide();
			jQuery('.db-create-trial_cycle').parent().parent().hide();
			jQuery('.db-create-trial_interval').parent().parent().hide();
		} else {
			jQuery('.db-create-payment_cycle').parent().parent().show();
			jQuery('.db-create-payment_interval').parent().parent().show();
			jQuery('.db-create-listing_run_type').parent().parent().hide();
			jQuery('.db-create-listing_run_days').parent().parent().hide();

			jQuery('.db-create-trial_period').parent().parent().parent().show();
			if ( jQuery('.db-create-trial_period').length ) {
				if ( jQuery('.db-create-trial_period').parent().hasClass('active') ) {
					jQuery('.db-create-trial_cycle').parent().parent().show();
					jQuery('.db-create-trial_interval').parent().parent().show();
				} else {
					jQuery('.db-create-trial_cycle').parent().parent().hide();
					jQuery('.db-create-trial_interval').parent().parent().hide();
				}
			}
		}
	});
	jQuery('.db-create-payment_type').trigger('change');

	jQuery(document).on('click', '.db-checkbox', function() {
		if ( jQuery(this).find('.db-create-trial_period').length ) {
			if ( jQuery(this).hasClass('active') ) {
				jQuery('.db-create-trial_cycle').parent().parent().show();
				jQuery('.db-create-trial_interval').parent().parent().show();
			} else {
				jQuery('.db-create-trial_cycle').parent().parent().hide();
				jQuery('.db-create-trial_interval').parent().parent().hide();
			}
		}
	});
	if ( jQuery('.db-create-trial_period').length ) {
		if ( jQuery('.db-create-trial_period').parent().hasClass('active') ) {
			jQuery('.db-create-trial_cycle').parent().parent().show();
			jQuery('.db-create-trial_interval').parent().parent().show();
		} else {
			jQuery('.db-create-trial_cycle').parent().parent().hide();
			jQuery('.db-create-trial_interval').parent().parent().hide();
		}
	}

	jQuery(document).on('click', '.db-upload-file', function() {
		var $wpfileupload = jQuery(this).parent().find('input[type="hidden"]');
		// var $wpimagedelete = jQuery(this).parent().find('.db-image-delete');
		// var $wpimagecontainer = jQuery(this).parent().find('.db-image-container');

		var image = wp.media({
			title: 'Upload file',
			multiple: false,
			library: {
				type: ''
			}
		}).open().on('select', function(e){
			var uploaded_image = image.state().get('selection').first();
			var image_url = uploaded_image.toJSON().url;
			$wpfileupload.val(image_url);
			// $wpimagedelete.show();
			// $wpimagecontainer.append('<img src="'+image_url+'" alt="">');
		});
	});

	jQuery(document).on('input', '#listing_address', function() {
		jQuery('#listing_address_lat').val('');
		jQuery('#listing_address_lng').val('');
	});

	jQuery(document).on('mouseenter', '.db-order-value-left', function() {
		if ( jQuery(this).next().length && jQuery(this).next().hasClass('db-payment-dialog') ) {
			jQuery(this).next().addClass('active');
		}
	});

	jQuery(document).on('mouseleave', '.db-order-value-left', function() {
		if ( jQuery(this).next().length && jQuery(this).next().hasClass('db-payment-dialog') ) {
			jQuery(this).next().removeClass('active');
		}
	});

	jQuery(document).on('click', '.db-upload-listing-images', function() {
		var $all_selected_images = jQuery('#listing_gallery_img').val();
		var image = wp.media({ 
			title: 'Upload Images',
			multiple: true
		}).on('select', function(e){
			var selection = image.state().get('selection');
			selection.map( function( attachment ) {
				attachment = attachment.toJSON();

				jQuery(".db-listing-uploaded-images .column").append('<div class="portlet ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" data-id="'+attachment.id+'"><div class="portlet-header ui-sortable-handle ui-widget-header ui-corner-all"><span class="db-uploaded-img-delete dbicon-cancel"></span><img src="'+attachment.url+'"></div></div>');

				if ( $all_selected_images != '' && $all_selected_images.slice(-1) != '|' ) {
					$all_selected_images += '|';
				}

				$all_selected_images += attachment.id+'|';
			});
			jQuery('#listing_gallery_img').val($all_selected_images.slice(0,-1));
		}).open();
	});

	jQuery(document).on('click', '.db-uploaded-img-delete', function() {
		var all_images = jQuery('#listing_gallery_img').val().split('|');
		all_images.splice(jQuery(this).parent().parent().index(), 1);
		var $image_string = '';
		jQuery.each(all_images, function(indx, value) {
			$image_string += value+'|';
		});
		jQuery('#listing_gallery_img').val($image_string.slice(0,-1));
		jQuery(this).parent().parent().remove();
	});

	jQuery(document).on('click', '.db-order-select', function() {
		jQuery('.db-order-package-container').show();
		jQuery(this).hide();
	});

	jQuery(document).on('click', '.db-order-package-save', function() {
		var listing_id = jQuery(this).attr('data-id');
		var current_position = jQuery(this);

		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_change_package',
				'listing_id': listing_id,
				'package_id': jQuery('.db-order-package').val(),
				'package_name': jQuery('.db-order-package option[value="'+jQuery('.db-order-package').val()+'"]').text(),
			},
			success: function(data) {
				var parsed_data = jQuery.parseJSON(data);
				if ( jQuery.isNumeric(parsed_data.save_response) ) {
					jQuery('.db-order-select').html(parsed_data.package_name).show();
					jQuery('.db-order-package-container').hide();
					current_position.parent().parent().parent().next().find('.db-order-value').html(parsed_data.paid);
				} else {
					jQuery('.db-order-select').show();
					jQuery('.db-order-package-container').hide();
				}
			}
		});
	});

	jQuery(document).on('click', '#db-choose-category-icon', function() {
		jQuery('.db-category-icon-dialog').addClass('active');
	});

	jQuery(document).on('click', '#db-delete-field-icon', function() {
		jQuery(this).parent().find('[type="hidden"]').val('');
		jQuery(this).parent().find('.db-active-category-icon').attr('class', 'db-active-category-icon');
		jQuery(this).parent().find('#db-delete-field-icon').removeClass('db-button-visible');
	});

	jQuery(document).on('click', '.db-category-icon-dialog-close', function() {
		jQuery('.db-category-icon-dialog').removeClass('active');
	});

	jQuery(document).on('click', '.db-category-icon-dialog-inner i', function() {
		var main_content = jQuery(this).parent().parent().parent();

		if ( main_content.hasClass('category-icon-modal-container') ) {
			main_content = main_content.parent();
		}

		main_content.find('[type="hidden"]').val(jQuery(this).attr('data-id'));
		jQuery('.db-category-icon-dialog').removeClass('active');
		jQuery('.db-active-category-icon').attr('class', 'db-active-category-icon '+jQuery(this).attr('data-id'));
		if ( main_content.find('#db-delete-field-icon').length ) {
			main_content.find('#db-delete-field-icon').addClass('db-button-visible');
		}
			
	});

	jQuery(document).on('change', '.db-settings-search_radius_status', function() {
		if ( jQuery(this).val() == 'yes' ) {
			jQuery('.db-row.db-search-radius-options').show();
		} else {
			jQuery('.db-row.db-search-radius-options').hide();
		}
	});
	jQuery('.db-settings-search_radius_status').trigger('change');

	jQuery(document).on('click', '.db-expiration-select', function() {
		jQuery('.db-expiration-dialog').show();
		jQuery(this).hide();
	});

	jQuery(document).on('click', '.db-expiration-save', function() {
		var listing_id = jQuery(this).attr('data-id');

		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_change_expiration',
				'listing_id': listing_id,
				'new_date': jQuery('.db-listing-expiration-date').val(),
			},
			success: function(data) {
				if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
					jQuery('.db-expiration-select').html(jQuery.parseJSON(data).package_name).show();
					jQuery('.db-expiration-dialog').hide();
				} else {
					jQuery('.db-expiration-select').show();
					jQuery('.db-expiration-dialog').hide();
				}
			}
		});
	});

	jQuery(document).on('click', '.db-activate-theme', function() {
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_activate_theme',
				'theme_id': jQuery(this).attr('data-id'),
				'theme_path': jQuery(this).attr('data-path'),
				'theme_url': jQuery(this).attr('data-url')
			},
			success: function(data) {
				if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
					location.reload();
				} else {
					// jQuery('.db-expiration-select').show();
					// jQuery('.db-expiration-dialog').hide();
				}
			}
		});
	});

	jQuery(document).on('change', '.db-hop-times-row [type="radio"]', function() {
		jQuery('.db-hop-time-container input[type="hidden"]').val(jQuery(this).val()+'|');
		if ( jQuery(this).val() == 'custom' ) {
			jQuery('.db-add-new-hop').show();
			jQuery('.db-hop-time-container').show();
			jQuery('.db-hop-time-container .db-hop-day-row').remove();
		} else {
			jQuery('.db-add-new-hop').hide();
			jQuery('.db-hop-time-container').hide();
			jQuery('.db-hop-time-container .db-hop-day-row').remove();
		}
	});

	jQuery(document).on('click', '.db-add-new-hop', function() {
		jQuery('.db-hop-dialog').show();
	});

	jQuery(document).on('change', '[name="custom-hop-day[]"]', function() {
		if ( jQuery(this).prop('checked') ) {
			jQuery(this).parent().addClass('active');
		} else {
			jQuery(this).parent().removeClass('active');
		}
	});

	jQuery(document).on('click', '.db-hop-add-time', function() {
		if ( !jQuery('.db-hop-dialog .db-hop-left label.active').length ) {
			jQuery('.db-hop-dialog-inner').prepend('<span class="db-hop-error">Please select a day!</span>');
			return;
		} else {
			jQuery('.db-hop-dialog-inner .db-hop-error').remove();
		}
		var appendable_html = '';
		var hop_indexes = [];
		jQuery('.db-hop-dialog .db-hop-left label.active').each(function() {
			hop_indexes.push(jQuery(this).index());
		});

		var hop_test;
		if ( hop_indexes.length > 1 ) {
			var ordered = 'not_ordered';
		} else {
			var ordered = 'ordered';
		}
		
		for (var i = 0; i < hop_indexes.length; i++) {
			if ( i > 0 ) {
				if ( hop_indexes[i] == hop_indexes[i-1]+1 ) {
					ordered = 'ordered';
				} else {
					ordered = 'not_ordered';
					i = 200;
				}
			}
			
		}

		var time_from = jQuery('.db-hop-from').val();
		var time_till = jQuery('.db-hop-till').val();
		var hidden_value = '';

		if ( hop_indexes.length == 1 ) {
			var first_value = jQuery(jQuery('.db-hop-dialog .db-hop-left label').get( hop_indexes['0'] )).find('input').val();
			appendable_html = '<div class="db-hop-day-row"><span class="db-hop-day-names">'+first_value+'</span><span class="db-hop-day-times">'+time_from+' - '+time_till+'</span><span class="db-hop-remove dbicon-cancel"></span></div>';
			hidden_value = first_value+'=='+time_from+'-'+time_till+'|';
		} else if ( hop_indexes.length > 1 && ordered == 'ordered' ) {
			var first_value = jQuery(jQuery('.db-hop-dialog .db-hop-left label').get( hop_indexes['0'] )).find('input').val();
			var last_value = jQuery(jQuery('.db-hop-dialog .db-hop-left label').get( hop_indexes[hop_indexes.length-1] )).find('input').val();
			appendable_html = '<div class="db-hop-day-row"><span class="db-hop-day-names">'+first_value+' - '+last_value+'</span><span class="db-hop-day-times">'+time_from+' - '+time_till+'</span><span class="db-hop-remove dbicon-cancel"></span></div>';
			hidden_value = first_value+'--'+last_value+'=='+time_from+'-'+time_till+'|';
		} else if ( ordered == 'not_ordered' ) {
			var day_names = '';
			jQuery.each(hop_indexes, function(index, label_index) {
				day_names += jQuery(jQuery('.db-hop-dialog .db-hop-left label').get( label_index )).find('input').val()+', ';
			});
			appendable_html = '<div class="db-hop-day-row"><span class="db-hop-day-names">'+day_names.slice(0,-2)+'</span><span class="db-hop-day-times">'+time_from+' - '+time_till+'</span><span class="db-hop-remove dbicon-cancel"></span></div>';
			hidden_value = day_names.slice(0,-2)+'=='+time_from+'-'+time_till+'|';
		}
		jQuery('.db-hop-time-container').append(appendable_html);
		jQuery('.db-hop-time-container input[type="hidden"]').val(jQuery('.db-hop-time-container input[type="hidden"]').val()+hidden_value);

		jQuery('.db-hop-dialog .db-hop-left label.active').removeClass('active');
		jQuery('.db-hop-from').val('');
		jQuery('.db-hop-till').val('');
		jQuery('.db-hop-dialog-inner .db-hop-error').remove();
		jQuery('.db-hop-dialog').hide();
	});

	jQuery(document).on('click', '.db-hop-remove', function() {
		var time_parent = jQuery(this).parent();
		var day_value = time_parent.find('.db-hop-day-names').html();
		day_value = day_value.replace(' - ', '--');
		var time_value = time_parent.find('.db-hop-day-times').html();
		time_value = time_value.replace(' - ', '-');

		var old_value = jQuery('.db-hop-time-container input[type="hidden"]').val();
		var new_value = old_value.replace(day_value+'=='+time_value+'|', '');
		jQuery('.db-hop-time-container input[type="hidden"]').val(new_value);

		jQuery(this).parent().remove();
	});

	jQuery(document).on('click', '.db-hop-dialog-close', function() {
		jQuery('.db-hop-dialog .db-hop-left label.active').removeClass('active');
		jQuery('.db-hop-from').val('');
		jQuery('.db-hop-till').val('');
		jQuery('.db-hop-dialog-inner .db-hop-error').remove();
		jQuery('.db-hop-dialog').hide();
	});

	jQuery(document).on('click', '.db-status-select', function() {
		jQuery('.db-listing-status-container').show();
		jQuery(this).hide();
	});

	jQuery(document).on('click', '.db-listing-status-save', function() {
		var listing_id = jQuery(this).attr('data-id');
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_change_status',
				'listing_id': listing_id,
				'listing_status': jQuery('.db-listing-status').val(),
			},
			success: function(data) {
				if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
					jQuery('.db-status-select').html(jQuery.parseJSON(data).listing_status).show();
					jQuery('.db-listing-status-container').hide();
				} else {
					jQuery('.db-status-select').show();
					jQuery('.db-listing-status-container').hide();
				}
			}
		});
	});

	function directory_prepare_search_fields( field_type ) {
		if ( field_type == 'homepage' ) {
			var selected_search_fields = jQuery('.db-settings-homepage_search_fields').val();
			var active_select = jQuery('.db-settings-homepage_search_fields option:not(:selected)');
		} else if ( field_type == 'searchpage' ) {
			var selected_search_fields = jQuery('.db-settings-search_fields').val();
			var active_select = jQuery('.db-settings-search_fields option:not(:selected)');
		}

		if( selected_search_fields ) {
			// Remove unselected options
			active_select.each( function(index, value) {
				jQuery('.db-search-field-layout-dialog.'+field_type+' .portlet:contains("' + jQuery(value).text() + '")').remove();
			});
			
			jQuery.each(selected_search_fields, function(index, value) {
				if ( field_type == 'homepage' ) {
					var selected_text = jQuery('.db-settings-homepage_search_fields option[value="'+value+'"]').text();
				} else if ( field_type == 'searchpage' ) {
					var selected_text = jQuery('.db-settings-search_fields option[value="'+value+'"]').text();
				}
				
				if ( jQuery('.db-search-field-layout-dialog.'+field_type+':contains("' + selected_text + '")').length == 0 ) {
					jQuery('.db-search-field-layout-dialog.'+field_type+' .column').first().append('<div class="portlet" data-id="'+value+'"><div class="portlet-header">'+selected_text+'</div></div>');
				}
			});
		}
	}

	jQuery(document).on('click', '.db-change-layout', function() {
		if ( jQuery(this).attr('data-source') == 'homepage' ) {
			var selected_search_fields = jQuery('.db-settings-homepage_search_fields').val();
		} else if ( jQuery(this).attr('data-source') == 'searchpage' ) {
			var selected_search_fields = jQuery('.db-settings-search_fields').val();
		}
		
		if( selected_search_fields ) {
			if ( selected_search_fields.length >= 2 ) {

				directory_prepare_search_fields( jQuery(this).attr('data-source') );

				jQuery( ".column" ).sortable({
					connectWith: ".column",
					handle: ".portlet-header",
					cancel: ".portlet-toggle",
					placeholder: "portlet-placeholder ui-corner-all"
				});

				jQuery( ".portlet" )
					.addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
					.find( ".portlet-header" )
					.addClass( "ui-widget-header ui-corner-all" )
					.prepend( "<span class='ui-icon ui-icon-minusthick portlet-toggle'></span>");

				jQuery( ".portlet-toggle" ).on( "click", function() {
					var icon = jQuery( this );
					icon.toggleClass( "ui-icon-minusthick ui-icon-plusthick" );
					icon.closest( ".portlet" ).find( ".portlet-content" ).toggle();
				});

				jQuery(this).parent().parent().slideUp();
				jQuery(this).parent().parent().next().slideDown();
			}
		}
	});

	if ( jQuery( ".column.db-gallery" ).length ) {
		jQuery( ".column.db-gallery" ).sortable({
			connectWith: ".column.db-gallery",
			handle: ".portlet-header",
			placeholder: "portlet-placeholder",
			stop: function() {
				var image_order = '';
				jQuery('.column.db-gallery .portlet').each(function() {
					image_order += jQuery(this).attr('data-id')+'|';
				});
				jQuery('#listing_gallery_img').val(image_order.slice(0,-1));
			}
		});	
	}

	jQuery(document).on('click', '.db-confirm-layout', function() {
		var search_layout = {};
		jQuery('.db-search-field-layout-dialog.'+jQuery(this).attr('data-source')+' .column').each(function() {
			var search_row = [];
			if ( jQuery(this).children().length != 0 ) {
				jQuery(this).find('.portlet').each(function() {
					search_row.push(jQuery(this).attr('data-id'));
				});
				search_layout['row_'+(jQuery(this).index()-2)] = search_row;
			}
		});
		if ( jQuery(this).attr('data-source') == 'searchpage' ) {
			jQuery('.db-settings-search_layout').val(JSON.stringify(search_layout));
		} else if ( jQuery(this).attr('data-source') == 'homepage' ) {
			jQuery('.db-settings-homepage_search_layout').val(JSON.stringify(search_layout));
		}

		jQuery(this).parent().slideUp();
		jQuery(this).parent().prev().slideDown();
	});

	jQuery(document).on('click', '.db-add-new-column', function() {
		jQuery('.db-search-field-layout-dialog').append('<div class="column"></div>');
		jQuery( ".column" ).sortable();
	});

	if ( jQuery('#db-choose-category-color').length ) {
		jQuery('#db-choose-category-color').wpColorPicker();
	}

	jQuery(document).on('click', '.db-featured-listing', function() {
		jQuery(this).hide();
		jQuery('.db-featured-dialog').show();
	});

	jQuery(document).on('click', '.db-featured-save', function() {
		var listing_id = jQuery(this).attr('data-id');
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_featured_status',
				'listing_id': listing_id,
				'featured_status': jQuery('.db-featured-status').val()
			},
			success: function(data) {
				if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
					jQuery('.db-featured-listing').html(jQuery('.db-featured-status').val()).show();
					jQuery('.db-featured-dialog').hide();
				} else {
					jQuery('.db-featured-listing').show();
					jQuery('.db-featured-dialog').hide();
				}
			}
		});
	});

	jQuery(document).on('click', '.db-remove-custom-image', function() {
		jQuery('#db_listing_custom_img').val('');
		jQuery('.db-custom-img-item').removeClass('active');
		jQuery('.db-custom-img-item.empty').addClass('active');
	});

	jQuery(document).on('click', '.db-set-custom-image', function() {
		var image = wp.media({ 
			title: 'Upload Image',
			multiple: false
		}).open().on('select', function(e){
			var uploaded_image = image.state().get('selection').first();
			var image_url = uploaded_image.toJSON().url;
			var image_id = uploaded_image.toJSON().id;
			
			jQuery('#db_listing_custom_img').val(image_id);
			jQuery('.db-custom-img-wrapper img').attr('src', image_url);

			jQuery('.db-custom-img-item').removeClass('active');
			jQuery('.db-custom-img-item.set').addClass('active');
		});
	});

	jQuery(document).on('click', '.db-cancel-claim', function() {
		var post_id = jQuery(this).attr('data-id');
		var current_row = jQuery(this).parent().parent();

		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_cancel_claim',
				'claim_post': post_id
			},
			success: function(data) {
				if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
					current_row.remove();
				} else {
					alert('Something went wrong!');
				}
			}
		});
	});

	jQuery(document).on('click', '.db-approve-claim', function() {
		var post_id = jQuery(this).attr('data-id');
		var current_row = jQuery(this).parent();

		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_approve_claim',
				'claim_post': post_id
			},
			success: function(data) {
				if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
					current_row.html(jQuery.parseJSON(data).message);
				} else {
					alert('Something went wrong!');
				}
			}
		});
	});

	jQuery(document).on('change', '.db-settings-payment_method', function() {
		var selected_values = jQuery(this).val();

		if ( selected_values['0'] == 'authorize.net' ) {
			jQuery('.db-settings-default_currency').parent().parent().parent().hide();
			jQuery('.auth-msg').removeClass('hidden');
		} else {
			jQuery('.auth-msg').addClass('hidden');
			jQuery('.db-settings-default_currency').parent().parent().parent().show();
		}
		
		if ( selected_values['0'] == 'paypal' ) {
			jQuery('.auth-msg').addClass('hidden');
			if ( selected_values['1'] == 'authorize.net' ) {
				jQuery('.auth-msg').removeClass('hidden');
			}
			jQuery('.db-settings-default_currency').parent().parent().parent().show();
		} else {
			jQuery('.db-settings-default_currency').parent().parent().parent().hide();
		}

		
	});
	jQuery('.db-settings-payment_method').trigger('change');

	jQuery(document).on('click', '.db-cancel-subscription[data-gateway="paypal"]', function() {
		jQuery(this).hide();
		jQuery(this).next().removeClass('hidden');
	});

	jQuery(document).on('click', '.db-cancel-subscription[data-gateway="authorize.net"]', function() {
		var post_id = jQuery(this).attr('data-id');
		var sub_parent = jQuery(this).parent();

		sub_parent.html('Cancelling');
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'db_cancel_subscription',
				'sub_id': post_id
			},
			success: function(data) {
				var parsed_data = jQuery.parseJSON(data);
				if ( parsed_data.save_response == 'success' ) {
					sub_parent.parent().find('td').first().html('Cancelled');
				}
				sub_parent.html(parsed_data.message);
			}
		});
	});

	jQuery(document).on('click', '.db-refund-manually:not([disabled="disabled"])', function() {
		var listing_id = jQuery(this).attr('data-id');
		var button = jQuery(this);

		if ( !button.hasClass('processing') && jQuery('.db-refund-amount').val() != '' ) {
			button.addClass('processing');
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: { 
					'action': 'db_manual_refund',
					'listing_id': listing_id,
					'ref_amount': jQuery('.db-refund-amount').val(),
					'ref_reason': jQuery('.db-refund-reason').val(),
					'ref_gateway': button.attr('data-gateway'),
					'ref_symbol': button.attr('data-symbol')
				},
				success: function(data) {
					button.removeClass('processing').addClass('refunded').attr('disabled', true);
					jQuery('.db-refund-amount, .db-refund-reason').val('');

					var first_note = jQuery('.db-payment-wrapper .db-note-item').first();
					if ( first_note.hasClass('empty') ) {
						first_note.remove();
					}

					var parsed_data = jQuery.parseJSON( data );
					jQuery('.db-payment-wrapper').prepend(parsed_data.note);
					jQuery('.db-payment-history-wrapper').append(parsed_data.history);
				}
			});
		}
	});

	jQuery(document).on('click', '.db-refund-auto.authorize', function() {
		var listing_id = jQuery(this).attr('data-id');
		var button = jQuery(this);

		if ( !button.hasClass('processing') && jQuery('.db-refund-amount').val() != '' ) {
			button.addClass('processing');
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: { 
					'action': 'db_authorize_refund',
					'listing_id': listing_id,
					'ref_amount': jQuery('.db-refund-amount').val(),
					'ref_reason': jQuery('.db-refund-reason').val(),
					'ref_symbol': button.attr('data-symbol')
				},
				success: function(data) {
					var parsed_data = jQuery.parseJSON(data);
					button.removeClass('processing');
					if ( parsed_data.save_response == 'success' ) {
						button.removeClass('processing').addClass('refunded').attr('disabled', true);
						jQuery('.db-refund-error').html('');
					} else {
						jQuery('.db-refund-error').html(parsed_data.message);
					}
				}
			});
		}
	});

	jQuery(document).on('input', '.db-refund-amount', function() {
		if ( jQuery(this).val() != '' ) {
			jQuery('.db-refund-manually, .db-refund-auto').attr('disabled', false);
			jQuery('.db-refund-manually').attr('data-normal', jQuery('.db-refund-manually').attr('data-normal').replace('.', '').replace(/\d+/,jQuery(this).val()));
			jQuery('.db-refund-auto').attr('data-normal', jQuery('.db-refund-auto').attr('data-normal').replace('.', '').replace(/\d+/,jQuery(this).val()));
		} else {
			jQuery('.db-refund-manually, .db-refund-auto').attr('disabled', true);
			jQuery('.db-refund-manually').attr('data-normal', jQuery('.db-refund-manually').attr('data-normal').replace('.', '').replace(/\d+/,'0'));
			jQuery('.db-refund-auto').attr('data-normal', jQuery('.db-refund-auto').attr('data-normal').replace('.', '').replace(/\d+/,'0'));
		}
	});

	jQuery(document).on('click', '.db-show-refund', function() {
		jQuery(this).addClass('hidden');
		jQuery(this).next().removeClass('hidden');
	});
});