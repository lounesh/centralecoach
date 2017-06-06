/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */

jQuery(window).load(function() {
	"use strict";

	// Add class to Revolution Slider error message so that it can be styled
	jQuery( ".dt-rs-container div div:contains('Revolution Slider Error')" ).parent().addClass("rs-error-container");
	jQuery( ".dt-rs-container div div:contains('Revolution Slider Error')" ).html("Slider with alias not found. <strong>To understand how to import demo slider please check this <a href=\"http://documentation.cohhe.com/whitelab/knowledgebase/revolution-slider/\">documentation</a></strong>");

	jQuery(document).on('change', '.dt-checkbox input, .dt-radio input', function() {
		if ( jQuery(this).parent().hasClass('dt-radio') ) {
			jQuery('.dt-radio.active').removeClass('active');
		}
		
		if ( jQuery(this).prop('checked') ) {
			jQuery(this).parent().addClass('active');
		} else {
			jQuery(this).parent().removeClass('active');
		}
	});

	jQuery(document).on('click', '.dt-sign-in-register', function() {
		jQuery('.dt-login-register-modal').addClass('db-animate-dialog');
		setTimeout(function() {
			jQuery('.dt-login-register-modal').next().addClass('overlay-shown');
		}, 150);
	});

	jQuery(document).on('click', '.dr-register-modal-close', function() {
		jQuery('.dt-login-register-modal').removeClass('db-animate-dialog');
		jQuery('.dt-login-register-modal').next().removeClass('overlay-shown');
		jQuery('.dt-login-message, .dt-register-message, .dt-lost-message').html('');
	});

	jQuery(document).on('click', '.dt-custom-select', function(e) {
		var current_status = jQuery(this).parent().find('.dt-custom-select-container').hasClass('active');
		if ( !jQuery(e.target).closest('.dt-search-row').length ) {
			jQuery('.custom-select, .dt-custom-select-container').removeClass('active');
		}
		var custom_select = jQuery(this);
		if ( current_status ) {
			custom_select.parent().find('.dt-custom-select-container').removeClass('active');
			custom_select.parent().removeClass('active');
		} else {
			custom_select.parent().find('.dt-custom-select-container').addClass('active');
			custom_select.parent().addClass('active');
		}

		if ( custom_select.parent().find('.dt-custom-select-items')[0].scrollHeight < 139 ) {
			custom_select.parent().find('.dt-custom-select-scrollbar').hide();
		} else {
			custom_select.parent().find('.dt-custom-select-scrollbar').show();
		}

		custom_select.parent().find('.dt-custom-select-scrollbar').css('height', custom_select.parent().find('.dt-custom-select-items')[0].offsetHeight*(custom_select.parent().find('.dt-custom-select-items')[0].offsetHeight/custom_select.parent().find('.dt-custom-select-items')[0].scrollHeight));
	
		if ( custom_select.parent().find('.dt-custom-select-search').length ) {
			custom_select.parent().find('.dt-custom-select-search input').focus();
		}
	});

	jQuery(document).on('click', '.dt-header-search-submit', function() {
		var search_page = jQuery(this).attr('data-url');
		var search_string = '';

		jQuery('input[class^="dt-search-"]').each(function() {
			if ( jQuery(this).val() != '' ) {
				search_string += jQuery(this).attr('class').replace(' dt-custom-select-value', '').replace('dt-search-', '')+'='+jQuery(this).val()+'&';
			}
		});

		search_string = search_string.slice(0, -1);

		if ( search_page.indexOf('?') >= 0 ) {
			search_page += '&'+search_string;
		} else {
			search_page += '?'+search_string;
		}

		window.location.href = search_page;
	});

	jQuery(document).on('click', '.dt-header-category-item', function() {
		var search_page = jQuery('.dt-header-categories').attr('data-url');
		
		if ( search_page.indexOf('?') >= 0 ) {
			search_page += '&search_category='+jQuery(this).attr('data-id');
		} else {
			search_page += '?search_category='+jQuery(this).attr('data-id');
		}

		window.location.href = search_page;
	});

	if ( jQuery('.dt-modal-left-side').length ) {
		if ( typeof jQuery('.dt-modal-left-item.active').attr('data-bg') != 'undefined' ) {
			jQuery('.dt-modal-left-side').css('background', 'url('+jQuery('.dt-modal-left-item.active').attr('data-bg')+') #4e94b1');
		}
		if ( jQuery('.dt-modal-left-side').children().length > 1 ) {
			var pagination_html = '<div class="dt-modal-left-pagination">';
			for (var i = 0; i < jQuery('.dt-modal-left-side').children().length; i++) {
				var active = '';
				if ( i == 0 ) {
					active = ' active';
				}
				pagination_html += '<span class="dt-modal-left-page'+active+'"></span>';
			}
			pagination_html += '</div>';
			jQuery('.dt-modal-left-side').append(pagination_html);
		}
	}

	jQuery(document).on('click', '.dt-modal-left-page:not(.active)', function() {
		jQuery('.dt-modal-left-page').removeClass('active');
		jQuery(this).addClass('active');
		var page_index = jQuery(this).index();
		jQuery('.dt-modal-left-side .dt-modal-left-item').removeClass('active');
		jQuery(jQuery('.dt-modal-left-side .dt-modal-left-item').get(page_index)).addClass('active');
		jQuery('.dt-modal-left-side').css('background', 'url('+jQuery(jQuery('.dt-modal-left-side .dt-modal-left-item').get(page_index)).attr('data-bg')+')');
	});

	jQuery(document).on('click', '.dt-show-password', function() {
		if ( jQuery(this).parent().find('input').attr('type') == 'text' ) {
			jQuery(this).parent().find('input').attr('type', 'password');
		} else {
			jQuery(this).parent().find('input').attr('type', 'text');
		}
	});

	jQuery(document).on('click', '.dt-header-show-login', function() {
		jQuery('.dt-login-form').show();
		jQuery('.dt-register-form').hide();
		jQuery('.dt-lost-form').hide();
		jQuery('.modal-inscription').hide();
		jQuery('.modal-pwd').hide();
		jQuery('.modal-connexion').show().css('display', 'block');
	});

	jQuery(document).on('click', '.dt-header-show-register', function() {
		jQuery('.dt-register-form').show();
		jQuery('.dt-login-form').hide();
		jQuery('.dt-lost-form').hide();
		jQuery('.modal-connexion').hide();
		jQuery('.modal-pwd').hide();
		jQuery('.modal-inscription').show().css('display', 'block');
	});

	jQuery(document).on('click', '.dt-header-show-lost', function() {
		jQuery('.dt-register-form').hide();
		jQuery('.dt-login-form').hide();
		jQuery('.dt-lost-form').show();
		jQuery('.modal-pwd').show().css('display', 'block');
		jQuery('.modal-connexion').hide();
		jQuery('.modal-inscription').hide();
	});

	jQuery(document).on('submit', '.dt-login-form', function(e) {
		e.preventDefault();

		jQuery('.dt-login-message').html('');
		jQuery.ajax({
			type: 'POST',
			url: my_ajax.ajaxurl,
			data: { 
				'action': 'whitelab_signin',
				'wl_user': jQuery('.dt-login-form .dt-login-username').val(),
				'wl_pass': jQuery('.dt-login-form .dt-login-password').val()
			},
			success: function(data) {
				var response_data = jQuery.parseJSON(data);

				if ( response_data.response == 'success' ) {
					jQuery('.dt-login-form *').remove();
					jQuery('.dt-login-form').append('<div class="dt-login-message"><p class="dt-success">' + response_data.message + '</p></div>');

					if ( typeof response_data.account != 'undefined' ) {
						window.location = response_data.account;
					}
				} else {
					jQuery('.dt-login-form .dt-login-message').html('<p class="dt-error">' + response_data.message + '</p>');
					jQuery('.dt-login-form .dt-login-message a').attr('href', 'javascript:void(0)').attr('class', 'dt-header-show-lost');
				}
			}
		});
	});

	jQuery(document).on('submit', '.dt-register-form', function(e) {
		e.preventDefault();

		var all_reg_values = {};
		jQuery('.dt-register-form .form-input').each(function() {
			if ( jQuery(this).attr('type') == 'checkbox' ) {
				all_reg_values[jQuery(this).attr('name')] = jQuery(this).prop('checked');
			} else if ( jQuery(this).attr('type') == 'radio' ) {
				if ( jQuery(this).prop('checked') ) {
					all_reg_values[jQuery(this).attr('name')] = jQuery(this).val();
				}
			} else {
				all_reg_values[jQuery(this).attr('name')] = jQuery(this).val();
			}
		});

		if ( jQuery('.dt-register-form #g-recaptcha-response').length ) {
			all_reg_values['db_captcha'] = jQuery('.dt-register-form #g-recaptcha-response').val();
		}

		jQuery('.dt-register-message').html('');
		jQuery.ajax({
			type: 'POST',
			url: my_ajax.ajaxurl,
			data: { 
				'action': 'whitelab_register',
				'wl_data': JSON.stringify(all_reg_values)
			},
			success: function(data) {
				var response_data = jQuery.parseJSON(data);

				if ( response_data.response == 'success' ) {
					jQuery('.dt-register-form *').remove();
					jQuery('.dt-register-form').append('<div class="dt-register-message"><p class="dt-success">' + response_data.message + '</p></div>');
				} else {
					jQuery('.dt-register-form .dt-register-message').html('<p class="dt-error">' + response_data.message + '</p>');
					jQuery('.dt-register-form .dt-register-message a').remove();
				}
			}
		});
	});

	jQuery(document).on('submit', '.dt-lost-form', function(e) {
		e.preventDefault();

		jQuery('.dt-lost-message').html('');
		jQuery.ajax({
			type: 'POST',
			url: my_ajax.ajaxurl,
			data: { 
				'action': 'whitelab_lost_password',
				'wl_user': jQuery('.dt-lost-username').val()
			},
			success: function(data) {
				var response_data = jQuery.parseJSON(data);

				if ( response_data.response == 'success' ) {
					jQuery('.dt-lost-form *').remove();
					jQuery('.dt-lost-form').append('<div class="dt-lost-message"><p class="dt-success">An email was sent to your email address!</p></div>');
				} else {
					jQuery('.dt-lost-form .dt-lost-message').html('<p class="dt-error">' + response_data.message + '</p>');
				}
			}
		});
	});

	jQuery(".dt-custom-select-items").scroll(function() {
		var scrolled_percentage = jQuery(this).scrollTop()/(jQuery(this)[0].scrollHeight-jQuery(this).innerHeight())*100;
		var extra_scroll = jQuery(this).parent().parent().find('.dt-custom-select-scrollbar').height()*(scrolled_percentage/100);
		var scroll_height = 'calc('+scrolled_percentage+'% - '+extra_scroll+'px)';
		jQuery(this).parent().parent().find('.dt-custom-select-scrollbar').css('top', scroll_height);
	});

	if ( jQuery('.customizer .toggle-colorcustomizer').length ) {
		jQuery('.customizer .toggle-colorcustomizer').click(function() {
			if ( typeof jQuery.cookie('directory_customizer_popup') === 'undefined' ) {
				jQuery('.info-wrap').fadeIn(200);
			} else {
				jQuery('.customizer').toggleClass('visible');
			}
		});

		jQuery('.info-wrap .info-close').click(function() {
			jQuery.cookie('directory_customizer_popup', 'false', { path: '/' });
			jQuery('.info-wrap').fadeOut(200);
			jQuery('.customizer').toggleClass('visible');
		});

		jQuery('li.color-9').colpick({
			flat:true,
			layout:'hex',
			onChange: function(hsb,hex,rgb,el,bySetColor) {
				jQuery('li.color-9 .drag-element').attr('data-color', '#'+hex);
				jQuery('li.color-9').css('background', 'transparent');
				jQuery('li.color-9, .drop.color-9, .drop-helper-1.color-9, .drop-helper-2.color-9, .drop-helper-3.color-9, .drop-helper-4.color-9').css('background-color', '#'+hex);
				jQuery('li.color-9, .drop.color-9, .drop-helper-1.color-9, .drop-helper-2.color-9, .drop-helper-3.color-9, .drop-helper-4.color-9').css('color', '#'+hex);
			},
			onSubmit: function() {
				jQuery('li.color-9 .colpick').stop().fadeOut(200, function () {
					jQuery('li.color-9 .colpick').removeClass('active');
				});
			}
		});

		jQuery('li.color-9 .colpick').hide();
		jQuery(document).on('click', 'li.color-9', function(e) {
			var droplet_x = jQuery(this).find('.drag-element').attr('data-x');
			var droplet_y = jQuery(this).find('.drag-element').attr('data-x');

			if ( ( typeof droplet_x == 'undefined' || droplet_x == '0' ) && ( typeof droplet_y == 'undefined' || droplet_y == '0' ) ) {
				if ( !jQuery('li.color-9 .colpick').hasClass('active') ) {
					jQuery('li.color-9 .colpick').stop().fadeIn(200);
				};
				jQuery('li.color-9 .colpick').addClass('active');
			}
		});
	}

	jQuery(document).on('click', '.dt-custom-select-item', function() {
		if ( !jQuery(this).parent().parent().parent().parent().hasClass('single-select') ) {
			jQuery(this).toggleClass('active');
			var active_classes = '';
			var active_values = '';
			jQuery(this).parent().find('.dt-custom-select-item.active').each(function() {
				active_classes += jQuery(this).text()+', ';
				active_values += jQuery(this).attr('data-value')+',';
			});
			active_classes = active_classes.slice(0, -2);
			active_values = active_values.slice(0, -1);
			jQuery(this).parent().parent().parent().parent().find('.dt-custom-select').attr('value', active_classes);
			jQuery(this).parent().parent().parent().parent().find('input[type="hidden"]').val(active_values);			
		} else {
			jQuery(this).parent().find('.dt-custom-select-item').removeClass('active');
			jQuery(this).addClass('active');

			jQuery(this).parent().parent().parent().parent().find('.dt-custom-select').attr('value', jQuery(this).text());
			jQuery(this).parent().parent().parent().parent().find('input[type="hidden"]').val(jQuery(this).attr('data-value')).trigger('change');

			jQuery(this).parent().parent().parent().removeClass('active');
		}
	});

	jQuery(document).on('input', '.dt-custom-select-search input', function() {
		var search_text = jQuery(this).val().toLowerCase();
		if ( search_text != '' ) {
			jQuery(this).parent().parent().find('.dt-custom-select-item').each(function() {
				if ( jQuery(this).text().toLowerCase().indexOf(search_text) >= 0 ) {
					jQuery(this).show();
				} else {
					jQuery(this).hide();
				}
			});
		} else {
			jQuery(this).parent().parent().find('.dt-custom-select-item').show();
		}

		if ( jQuery(this).parent().parent().find('.dt-custom-select-items')[0].scrollHeight < 139 ) {
			jQuery(this).parent().parent().parent().find('.dt-custom-select-scrollbar').hide();
		} else {
			jQuery(this).parent().parent().parent().find('.dt-custom-select-scrollbar').show();
			jQuery(this).parent().parent().parent().find('.dt-custom-select-scrollbar').css('height', jQuery(this).parent().parent().find('.dt-custom-select-items')[0].offsetHeight*(jQuery(this).parent().parent().find('.dt-custom-select-items')[0].offsetHeight/jQuery(this).parent().parent().find('.dt-custom-select-items')[0].scrollHeight));
		}
	});

	jQuery('.db-field-row input[type="text"], .db-field-row input[type="email"], .db-field-row input[type="url"], .db-field-row input[type="password"], .db-field-row textarea, .dt-form-row input[type="text"], .dt-form-row input[type="password"], .dt-form-row input[type="email"]').each(function() {
		if ( jQuery(this).val() != '' ) {
			jQuery(this).parent().addClass('text-added');
		}
	});

	jQuery(document).on('input', '.db-field-row input[type="text"], .db-field-row input[type="email"], .db-field-row input[type="url"], .db-field-row input[type="password"], .db-field-row textarea, .dt-form-row input[type="text"], .dt-form-row input[type="password"], .dt-form-row input[type="email"]', function() {
		if ( jQuery(this).val() != '' ) {
			jQuery(this).parent().addClass('text-added');
		} else if ( jQuery(this).val() == '' ) {
			jQuery(this).parent().removeClass('text-added');
		}
	});

	jQuery(document).on('focus', '.db-field-row input[type="text"], .db-field-row input[type="email"], .db-field-row input[type="url"], .db-field-row input[type="password"], .db-field-row textarea, .dt-form-row input[type="text"], .dt-form-row input[type="password"], .dt-form-row input[type="email"]', function() {
		jQuery(this).parent().addClass('text-focused');
	});

	jQuery(document).on('blur', '.db-field-row input[type="text"], .db-field-row input[type="email"], .db-field-row input[type="url"], .db-field-row input[type="password"], .db-field-row textarea, .dt-form-row input[type="text"], .dt-form-row input[type="password"], .dt-form-row input[type="email"]', function() {
		jQuery(this).parent().removeClass('text-focused');
	});

	if ( jQuery('.dt-header-search-submit').length ) {
		jQuery(document).keydown(function(e) {
			if ( e.keyCode == 13 && jQuery(e.target).closest('.dt-header-search').length ) {
				jQuery('.dt-header-search-submit').click();
			}
		});
	}

	jQuery(document).on('change', '.db-radio-label input', function() {
		jQuery(this).parent().parent().find('.db-radio-label').removeClass('active');
		jQuery(this).parent().addClass('active');
	});

	jQuery(document).on('change', '.db-field-row.checkbox-label input', function() {
		jQuery(this).parent().find('.db-field-row-label').toggleClass('active');
	});

	jQuery(document).on('click', '.db-main-search .dt-custom-select-item', function() {
		if ( jQuery('.db-find-listings').length ) {
			jQuery('.db-find-listings').attr('data-page', '1');
			jQuery('.db-find-listings').click();
		}
	});

	jQuery(document).on('mouseenter', '.db-main-search-item', function() {
		jQuery('.db-map-marker[data-id="'+jQuery(this).attr('data-id')+'"]').addClass('hovered');
	});

	jQuery(document).on('mouseleave', '.db-main-search-item', function() {
		jQuery('.db-map-marker[data-id="'+jQuery(this).attr('data-id')+'"]').removeClass('hovered');
	});

	jQuery(document).bind("ajaxComplete", function(event, xhr, settings) {
		if ( typeof settings.data != 'undefined' && settings.data.indexOf('vc_get_vc_grid_data') >= 0 ) {
			jQuery('.blog-loading').removeClass('blog-loading');
		}
	});

	jQuery(document).on('click', '.comment-form-comment .db-send-comment', function() {
		jQuery('#commentform').removeAttr('novalidate');
		jQuery('#commentform input[type="submit"]').click();
	});

	jQuery(document).on('click', '.db-comment-count', function() {
		jQuery('.db-comment-inner > .commentlist, .db-comment-inner > #respond, .db-single-listing-left .review-list, .db-single-listing-left .comment-respond').slideToggle();
		jQuery(this).toggleClass('inactive');
	});

	jQuery(document).on('click', '.db-choose-package:not(.button-disabled)', function() {
		jQuery('.db-choose-package').removeClass('package-clicked');
		jQuery(this).addClass('package-clicked');

		jQuery(this).parent().parent().find('input[type="radio"]').prop('checked', true);

		jQuery(this).addClass('loading-effect button-disabled');

		jQuery('[name="db-active-package"]').val(jQuery(this).attr('data-id'));

		if ( jQuery('#db-add-listing-form input[type="submit"]').length ) {
			jQuery('#db-add-listing-form input[type="submit"]').click();
		}

		if ( jQuery('#db-add-listing-form').length && !jQuery('#db-add-listing-form').get(0).checkValidity() ) {
			jQuery(this).removeClass('loading-effect button-disabled');
		}
	});

	jQuery('body').click(function(e) {
		if ( jQuery('.dt-login-register-modal').hasClass('db-animate-dialog') && !jQuery(e.target).parents('.dt-register-modal-inner').length && jQuery(e.target).attr('class') != 'dt-quote-page' ) {
			jQuery('.dt-login-register-modal').removeClass('db-animate-dialog');
			jQuery('.dt-login-register-modal').next().removeClass('overlay-shown');
			jQuery('.dt-login-message, .dt-register-message, .dt-lost-message').html('');
		}

		if ( jQuery('#db-contact-listing-dialog').hasClass('db-animate-dialog') && jQuery(e.target).attr('id') != 'db-contact-listing-dialog' && !jQuery(e.target).parents('#db-contact-listing-dialog').length ) {
			jQuery('#db-contact-listing-dialog').removeClass('db-animate-dialog');
			jQuery('#db-contact-listing-dialog').next().removeClass('overlay-shown');
			jQuery('body').removeClass('db-contact-dialog-open');
		}
	});

	jQuery(document).on('click', '.db-contact-open', function() {
		jQuery('body').addClass('db-contact-dialog-open');
		jQuery('#db-contact-listing-dialog').addClass('db-animate-dialog');
		setTimeout(function() {
			jQuery('#db-contact-listing-dialog').next().addClass('overlay-shown');
		}, 150);
	});

	jQuery(document).on('click', '.db-contact-close', function() {
		jQuery('#db-contact-listing-dialog').removeClass('db-animate-dialog');
		jQuery('body').removeClass('db-contact-dialog-open');
		jQuery('#db-contact-listing-dialog').next().removeClass('overlay-shown');
	});

	jQuery(document).on('submit', '#db-add-listing-form', function(e) {
		if ( !jQuery(this).find('input[type="submit"]').hasClass('db-edit-listing') ) {
			e.preventDefault();
		}
		if ( !jQuery(this).hasClass('in-process') ) {
			var invalid = 0;
			var scroll_to = 0;

			jQuery('.db-field-row').removeClass('db-scroll-to');
			jQuery(this).find('.required').each(function() {
				jQuery(this).removeClass('invalid');
				var field_type = jQuery(this).find('input[name], #listing_terms_and_conditions, textarea').prop('tagName');
				var field_input = jQuery(this).find('input[name], #listing_terms_and_conditions, textarea');

				
					if ( field_type == 'INPUT' ) {
						if ( field_input.attr('type') == 'checkbox' ) {
							if ( field_input.prop('checked') === false ) {
								jQuery(this).addClass('invalid');
								if ( scroll_to == 0 ) {
									jQuery(this).addClass('db-scroll-to');
									scroll_to++;
								}
								invalid++;
							}
						} else if ( field_input.attr('type') == 'radio' ) {
							var checked = 0;
							jQuery.each(field_input, function() {
								if ( jQuery(this).prop('checked') === true ) {
									checked++;
								}
							});
							if ( checked == 0 ) {
								jQuery(this).addClass('invalid');
								if ( scroll_to == 0 ) {
									jQuery(this).addClass('db-scroll-to');
									scroll_to++;
								}
								invalid++;
							}
						} else {
							if ( field_input.val() == '' ) {
								jQuery(this).addClass('invalid');
								if ( scroll_to == 0 ) {
									jQuery(this).addClass('db-scroll-to');
									scroll_to++;
								}
								invalid++;
							}
						}
					} else if ( field_type == 'TEXTAREA' ) {
						if ( field_input.val() == '' ) {
							jQuery(this).addClass('invalid');
							if ( scroll_to == 0 ) {
								jQuery(this).addClass('db-scroll-to');
								scroll_to++;
							}
							invalid++;
						}
					}
			});

			if ( invalid > 0 ) {
				e.preventDefault();

				jQuery("html, body").animate({ scrollTop: jQuery('.db-field-row.db-scroll-to').offset().top-50 }, "slow");
				jQuery('.db-choose-package').removeClass('loading-effect button-disabled');
			} else if ( !jQuery(this).find('input[type="submit"]').hasClass('db-edit-listing') ) {
				jQuery(this).addClass('in-process');
				var all_fields = {};
				jQuery('#db-add-listing-form [name]').each(function() {
					all_fields[jQuery(this).attr('name')] = jQuery(this).val();
				});

				if ( !jQuery(this).hasClass('added') ) {

					jQuery('.db-add-form-error').remove();

					jQuery.ajax({
						type: 'POST',
						url: db_main.ajaxurl,
						data: { 
							'action': 'db_create_listing',
							'field_data': JSON.stringify(all_fields)
						},
						success: function(data) {
							var parsed_resp = jQuery.parseJSON(data);
							if ( jQuery.isNumeric(parsed_resp.save_response) ) {
								jQuery('[name="db-listing-id"]').val(parsed_resp.save_response);
								jQuery('[name="custom"]').val(parsed_resp.save_response+':'+parsed_resp.author+':author');
								jQuery('[name="db-package-fee"], [name="a3"]').val(parsed_resp.amount);

								if ( parsed_resp.payment_type == 'onetime' ) {
									jQuery('[name="cmd"]').val('_xclick');
								} else {
									jQuery('[name="cmd"]').val('_xclick-subscriptions');
									jQuery('[name="p3"]').val(parsed_resp.payment_interval);
									jQuery('[name="t3"]').val(parsed_resp.payment_cycle.charAt(0).toUpperCase());

									if ( parsed_resp.payment_trial == true ) {
										jQuery('#paypal-gateway .db-checkout-proceed').append('<input type="hidden" name="a1" value="0">');
										jQuery('#paypal-gateway .db-checkout-proceed').append('<input type="hidden" name="p1" value="'+parsed_resp.trial_interval+'">');
										jQuery('#paypal-gateway .db-checkout-proceed').append('<input type="hidden" name="t1" value="'+parsed_resp.trial_cycle.charAt(0).toUpperCase()+'">');
									}
								}

								if ( parsed_resp.amount != '0' ) {
									jQuery('.db-main-checkout-wrapper').addClass('db-animate-dialog');
									setTimeout(function() {
										jQuery('.db-main-checkout-wrapper').next().addClass('overlay-shown');
									}, 150);
								}

								jQuery('#db-add-listing-form').addClass('added');
								jQuery('#db-add-listing-form').attr('data-added_as', jQuery('[name="db-active-package"]').val());

								if ( parsed_resp.redirect == 'true' && parsed_resp.amount != '0' ) {
									window.location = jQuery('.db-main-checkout').attr('data-return');
								} else if ( parsed_resp.redirect == 'true' && parsed_resp.amount == '0' ) {
									window.location = jQuery('.db-main-checkout').attr('data-success');
								}
							} else {
								if ( parsed_resp.error == 'form' ) {
									jQuery('#db-add-listing-form').prepend( '<p class="db-add-form-error">' + parsed_resp.message + '</p>' );
									jQuery("html, body").animate({ scrollTop: 0 }, "fast");
								} else {
									alert(parsed_resp.message);
								}
							}
							jQuery('.db-choose-package').removeClass('loading-effect button-disabled');
							jQuery('#db-add-listing-form').removeClass('in-process');
						}
					});
				} else if ( jQuery(this).hasClass('db-checkout-closed') ) {
					if ( jQuery('[name="db-active-package"]').val() == jQuery('#db-add-listing-form').attr('data-added_as') ) {
						jQuery('.db-main-checkout-wrapper').addClass('db-animate-dialog');
						setTimeout(function() {
							jQuery('.db-main-checkout-wrapper').next().addClass('overlay-shown');
						}, 150);
					} else {
						jQuery.ajax({
							type: 'POST',
							url: db_main.ajaxurl,
							data: { 
								'action': 'db_change_active_package',
								'listing_id': jQuery('[name="db-listing-id"]').val(),
								'package_id': jQuery('[name="db-active-package"]').val()
							},
							success: function(data) {
								var parsed_resp = jQuery.parseJSON(data);
								if ( jQuery.isNumeric(parsed_resp.save_response) ) {
									jQuery('[name="db-listing-id"], [name="custom"]').val(parsed_resp.save_response);
									jQuery('[name="db-package-fee"]').val(parsed_resp.amount);

									if ( parsed_resp.amount != '0' ) {
										jQuery('.db-main-checkout-wrapper').addClass('db-animate-dialog');
										setTimeout(function() {
											jQuery('.db-main-checkout-wrapper').next().addClass('overlay-shown');
										}, 150);
									}

									jQuery('#db-add-listing-form').attr('data-added_as', jQuery('[name="db-active-package"]').val());

									if ( parsed_resp.redirect == 'true' && parsed_resp.amount == '0' ) {
										window.location = jQuery('.db-main-checkout').attr('data-success');
									}
								} else {
									alert(parsed_resp.message);
								}
								jQuery('.db-choose-package').removeClass('loading-effect button-disabled');
								jQuery(this).removeClass('in-process');
							}
						});
					}
				}
			}			
		}
	});

	jQuery(document).on('submit', '#paypal-gateway', function(e) {
		var current_form = jQuery(this);
		if ( !current_form.hasClass('billing-sent') ) {
			e.preventDefault();

			var all_fields = {};
			jQuery('#paypal-gateway .db-checkout-left [name]').each(function() {
				all_fields[jQuery(this).attr('name')] = jQuery(this).val();
			});

			var card_fields = {};
			jQuery('#paypal-gateway .db-checkout-right [name]').each(function() {
				card_fields[jQuery(this).attr('name')] = jQuery(this).val();
			});

			jQuery('#paypal-gateway .db-checkout-proceed').addClass('loading-effect');

			jQuery.ajax({
				type: 'POST',
				url: db_main.ajaxurl,
				data: { 
					'action': 'db_save_billing',
					'field_data': JSON.stringify(all_fields),
					'card_data': JSON.stringify(card_fields),
					'listing_id': jQuery('[name="db-listing-id"]').val(),
					'gateway': 'paypal'
				},
				success: function(data) {
					var parsed_resp = jQuery.parseJSON(data);
					if ( jQuery.isNumeric(parsed_resp.save_response) ) {
						current_form.addClass('billing-sent');
						jQuery('#paypal-gateway').submit();
					} else {
						if ( jQuery('#authorize_form .db-checkout-proceed .db-checkout-error').length ) {
							jQuery('#authorize_form .db-checkout-proceed .db-checkout-error').html(parsed_resp.message);
						} else {
							jQuery('#authorize_form .db-checkout-proceed').prepend('<span class="db-checkout-error">'+parsed_resp.message+'</span>')
						}
						jQuery('#paypal-gateway .db-checkout-proceed').removeClass('loading-effect');
					}
				}
			});
		}
	});

	jQuery(document).on('click', 'body.single-listings .db-choose-package[data-amount!="0"]', function() {
		jQuery('.db-main-checkout-wrapper').addClass('db-animate-dialog');
		setTimeout(function() {
			jQuery('.db-main-checkout-wrapper').next().addClass('overlay-shown');
		}, 150);

		jQuery('[name="db-package-fee"], [name="a3"]').val(jQuery(this).attr('data-amount'));
		jQuery('[name="db-package-fee"]').after('<input type="hidden" name="db-listing-claim" value="true">');

		jQuery('[name="custom"]').val( jQuery('[name="db-listing-id"]').val()+':'+my_ajax.current+':claim' );
	});

	jQuery(document).on('click', 'body.single-listings .db-choose-package[data-amount="0"]', function() {
		jQuery.ajax({
			type: 'POST',
			url: db_main.ajaxurl,
			data: { 
				'action': 'db_save_claim',
				'listing_id': jQuery('[name="db-listing-id"]').val(),
				'package_id': jQuery(this).attr('data-id'),
			},
			success: function(data) {
				var parsed_resp = jQuery.parseJSON(data);
				if ( jQuery.isNumeric(parsed_resp.save_response) ) {
					window.location = window.location.href.replace('?db-claim', '');
				} else {
					alert('There was an issue while saving the claimed data!');
				}
			}
		});
	});

	jQuery(document).on('click', '.db-checkout-close', function() {
		jQuery('.db-main-checkout-wrapper').removeClass('db-animate-dialog');
		jQuery('.db-main-checkout-wrapper').next().removeClass('overlay-shown');
		jQuery('.db-choose-package').removeClass('loading-effect').removeClass('button-disabled');
		jQuery('#db-add-listing-form').addClass('db-checkout-closed').removeClass('in-process');
	});

	jQuery(document).on('click', '.dt-show-mobile-menu', function() {
		jQuery('.main-header-right-side').toggleClass('mobile-menu-shown');
	});

	jQuery(document).on('click', '.wl-pin-it-button', function() {
		jQuery('[data-pin-log="button_pinit_bookmarklet"]').click();
	});

	jQuery(document).on('click', '.db-account-listing-option.renew', function() {
		var package_id = jQuery(this).attr('data-id');
		var list_id = jQuery(this).attr('data-list-id');

		jQuery.ajax({
			type: 'POST',
			url: db_main.ajaxurl,
			data: { 
				'action': 'db_renew_listing',
				'package_id': package_id
			},
			success: function(data) {
				var parsed_resp = jQuery.parseJSON(data);
				if ( jQuery.isNumeric(parsed_resp.save_response) ) {
					jQuery('[name="db-listing-id"], [name="custom"]').val(list_id);
					jQuery('[name="db-package-fee"], [name="amount"]').val(parsed_resp.amount);
					jQuery('[name="item_name"]').val(parsed_resp.name);

					jQuery('.db-main-checkout-wrapper').addClass('db-animate-dialog');
					setTimeout(function() {
						jQuery('.db-main-checkout-wrapper').next().addClass('overlay-shown');
					}, 150);
				} else {
					alert(parsed_resp.message);
				}
			}
		});
	});

	jQuery( window ).resize(function() {
		if ( jQuery(window).width() < 1200 ) {
			var checkout_width = jQuery(window).width()-20;

			if ( checkout_width%2 == 1 ) {
				jQuery('.db-main-checkout-wrapper').css( 'width', checkout_width-1+'px' );
			} else {
				jQuery('.db-main-checkout-wrapper').css( 'width', checkout_width+'px' );
			}
		} else {
			jQuery('.db-main-checkout-wrapper').css( 'width', '' );
		}
	});

	jQuery(document).on('click', '.main-header-right-side.mobile-menu-shown .menu-item-has-children > a', function(e) {
		e.preventDefault();
		jQuery(this).parent().toggleClass('menu-shown');
	});

	jQuery(document).on('click', 'body', function(e) {
		if ( jQuery('.custom-select').length && !jQuery(e.target).closest('.custom-select').length && !jQuery(e.target).hasClass('db-find-listings') ) {
			jQuery('.custom-select, .custom-select .dt-custom-select-container').removeClass('active');
		}

		if ( jQuery('.single-select').length && !jQuery(e.target).closest('.single-select').length ) {
			jQuery('.single-select, .single-select .dt-custom-select-container').removeClass('active');
		}

		if ( jQuery('.dt-search-row.listing-category').length && !jQuery(e.target).closest('.dt-search-row.listing-category').length ) {
			jQuery('.dt-search-row.listing-category, .dt-search-row.listing-category .dt-custom-select-container').removeClass('active');
		}
	});

	jQuery(document).on('click', '.dt-search-row.listing-category', function(e) {
		if ( jQuery(e.target).hasClass('dt-search-row') ) {
			jQuery('.dt-search-row.listing-category').find('input.dt-custom-select').click();
		}
	});

	// jQuery(document).on('click', '.dt-search-row .db-field-row.custom-select', function(e) {
	// 	if ( jQuery(e.target).closest('.db-field-row').length && jQuery(e.target).closest('.db-field-row').hasClass('custom-select') ) {
	// 		jQuery(e.target).closest('.db-field-row').find('input.dt-custom-select').click();
	// 	}
	// });
});

jQuery(document).ready(function($) {
	"use strict";
	
	jQuery(document).on('click', '.dt-blog-item-share img', function() {
		jQuery(this).parent().find('.dt-share-item-wrapper').addClass('active');
		jQuery(this).hide();
	});

	jQuery(document).on('click', '.db-pricing-main-wrapper .db-choose-package', function() {
		var fee_name = jQuery(this).parent().parent().find('label').text();
		var fee_amount = jQuery(this).parent().find('.db-fee-value').text().replace(/[^0-9]/g, '');
		jQuery('[name="item_name"]').val(fee_name+' - claim listing');
		jQuery('[name="amount"]').val(fee_amount);
	});

	jQuery(document).on('click', '.db-payment-packages .db-choose-package', function() {
		var fee_name = jQuery(this).parent().parent().find('label').text();
		var fee_amount = jQuery(this).parent().find('.db-fee-value').text().replace(/[^0-9]/g, '');
		jQuery('[name="item_name"]').val(fee_name);
		jQuery('[name="amount"]').val(fee_amount);
	});

	if ( jQuery('body').hasClass('blog') || jQuery('body').hasClass('search') || jQuery('body').hasClass('archive') ) {
		if ( jQuery('#content article').length ) {
			jQuery('#content').isotope({
				itemSelector: 'article',
				layoutMode: 'masonry',
				transitionDuration: '0.2s',
				hiddenStyle: {
					opacity: 0
				},
				visibleStyle: {
					opacity: 1
				}
			});
		}
	}
});