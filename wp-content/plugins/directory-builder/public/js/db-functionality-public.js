(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
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
var $search_map;
var $search_markers = [];
var $markerCluster;
jQuery(document).ready(function($) {
	var $search_item_container = jQuery('.db-main-search-listings');
	jQuery(document).on('click', '.db-find-listings', function() {
		var all_search_fields = {};
		jQuery('[class^="db-search-"]').each(function() {
			var setting_name = jQuery(this).attr('class').replace('db-search-', '').replace('-', '_');
			if ( setting_name == 'sort' || jQuery(this).hasClass('db-search-sort') ) {
				return true;
			}
			if ( jQuery(this).attr('type') != 'checkbox' ) {
				if ( jQuery(this).val() != '' ) {
					all_search_fields[setting_name] = jQuery(this).val();
				}
			} else {
				all_search_fields[setting_name] = jQuery(this).prop('checked');
			}
		});
		jQuery('[id^="db-search-"]').each(function() {
			var setting_name = jQuery(this).attr('id').replace('db-search-', '').replace('-', '_');
			if ( setting_name == 'sort' ) {
				return true;
			}
			if ( jQuery(this).attr('type') != 'checkbox' ) {
				if ( jQuery(this).val() != '' ) {
					all_search_fields[setting_name] = jQuery(this).val();
				}
			} else {
				all_search_fields[setting_name] = jQuery(this).prop('checked');
			}
		});

		jQuery('.db-main-search-listings').addClass('loading').scrollTop(0);

		jQuery('.db-search-next-page, .db-search-prev-page').addClass('hidden');

		jQuery.ajax({
			type: 'POST',
			url: db_main.ajaxurl,
			data: { 
				'action': 'db_search_listings',
				'search_terms': JSON.stringify(all_search_fields),
				'db_full_url': window.location.href,
				'db_page': jQuery(this).attr('data-page')
			},
			success: function(data) {
				db_parse_search_data( data );

				setTimeout(function() {
					jQuery('.db-main-search-listings').removeClass('loading');
				}, 600);
			}
		});
	});

	jQuery(document).on('click', '.db-search-next-page', function() {
		jQuery('.db-find-listings').attr('data-page', parseInt(jQuery('.db-find-listings').attr('data-page'))+1).click();
	});

	jQuery(document).on('click', '.db-search-prev-page', function() {
		jQuery('.db-find-listings').attr('data-page', parseInt(jQuery('.db-find-listings').attr('data-page'))-1).click();
	});

	function db_set_search_markers( search_map, search_marker ) {
		if ( search_marker['0'] == '' || search_marker['1'] == '' ) {
			return;
		}

		var marker_location = new google.maps.LatLng(search_marker['0'], search_marker['1']);

		// var marker = new google.maps.Marker({ position: marker_location, map: search_map });

		var marker = new RichMarker({
			position: marker_location,
			map: search_map,
			draggable: false,
			shadow: 'none',
			content: '<div class="db-map-marker '+search_marker['2']+'" data-id="'+search_marker['3']+'"></div>'
		});

		$search_markers.push(marker);

		var infoBubble = new InfoBubble({
			map: search_map,
			content: '<div class="marker-loading marker-id-'+search_marker['3']+'"></div>',
			position: marker_location,
			shadowStyle: 0,
			padding: 0,
			backgroundColor: 'rgb(255,255,255)',
			borderRadius: 4,
			arrowSize: 0,
			borderWidth: 0,
			borderColor: 'transparent',
			disableAutoPan: true,
			hideCloseButton: false,
			arrowPosition: 0,
			backgroundClassName: 'db-marker-window',
			arrowStyle: 2
		});

		google.maps.event.addListener(marker, 'click', function() {
			infoBubble.setMinWidth(70);
			infoBubble.setMinHeight(70)
			infoBubble.setCloseSrc(db_main.template_url+'/images/x-white.png');
			jQuery(infoBubble.close_).hide();
			infoBubble.open(search_map, marker);
			jQuery(infoBubble.content_).parent().attr('class', 'db-marker-window-loading');
			jQuery(infoBubble.content_).parent().parent().addClass('db-marker-perspective');

			jQuery.ajax({
				type: 'POST',
				url: db_main.ajaxurl,
				data: { 
					'action': 'db_marker_window',
					'marker_id': search_marker['3']
				},
				success: function( data ) {
					jQuery('.db-marker-window .marker-id-'+search_marker['3']).html(data).addClass('active');

					infoBubble.setMinWidth(300);
					infoBubble.setMinHeight(400);
					jQuery(infoBubble.content_).parent().attr('class', 'db-marker-window-loaded');
					setTimeout(function() {
						jQuery(infoBubble.close_).show();
					}, 200);
					infoBubble.panToView();
				}
			});
		});

		google.maps.event.addListener(search_map, 'click', function() {
			infoBubble.close();
		});
	}

	function db_clear_markers() {
		if ( $search_markers.length ) {
			jQuery.each($search_markers, function(index, marker) {
				marker.setMap(null);
				$markerCluster.removeMarker(marker);
			});	
		}
		$search_markers = [];
	}

	jQuery( window ).resize(function() {
		whitelab_calculate_side_height();
	});

	function db_parse_search_data( data ) {
		jQuery('.db-main-search-listings').html('<span class="db-search-scrollbar"></span>');
		var parsed_search_data = jQuery.parseJSON(data);
		if ( typeof parsed_search_data.listing_html.length != 'number' ) {
			jQuery('.db-main-search-listings').removeClass('db-no-listings');
			jQuery.each(parsed_search_data.listing_html, function(index, data) {
				jQuery('.db-main-search-listings').append(data);
			});

			var search_height = jQuery('.db-main-search-listings')[0].scrollHeight;
			jQuery('.db-main-search-listings').append('<a href="javascript:void(0)" class="db-search-next-page hidden">Next page</a>');
			jQuery('.db-main-search-listings').append('<a href="javascript:void(0)" class="db-search-prev-page hidden">Previous page</a>');
			if ( search_height > jQuery('.db-main-search-listings')[0].clientHeight ) {
				jQuery('.db-search-next-page, .db-search-prev-page').css('top', search_height+'px');
			} else {
				jQuery('.db-search-next-page, .db-search-prev-page').css('top', (search_height-50)+'px');
			}

			var scrollbar_height = jQuery('.db-main-search-listings')['0'].clientHeight*(jQuery('.db-main-search-listings')['0'].clientHeight/jQuery('.db-main-search-listings')['0'].scrollHeight);
			if ( scrollbar_height < jQuery('.db-main-search-listings')['0'].scrollHeight ) {
				jQuery('.db-main-search-listings').find('.db-search-scrollbar').css('height', scrollbar_height).show();
			} else {
				jQuery('.db-main-search-listings').find('.db-search-scrollbar').hide();
			}

			db_clear_markers();
			var merker_count = 0;
			jQuery.each(parsed_search_data.marker_data, function(index, marker) {
				db_set_search_markers($search_map, marker);
				merker_count++;
			});

			var options = {
				imagePath: db_main.plugin_url+'public/images/m'
			}

			$markerCluster = new MarkerClusterer($search_map, $search_markers, options);

			if ( jQuery('.db-found-count').length ) {
				jQuery('.db-found-count').attr('data-found', $search_markers.length);
				if ( jQuery('.db-find-listings').attr('data-page') == 1 ) {
					jQuery('.db-found-count').attr('data-total-found', $search_markers.length + ' ' + db_main.search_of + ' ' + parsed_search_data.total);
				} else {
					jQuery('.db-found-count').attr('data-total-found', (parseInt(jQuery('.db-find-listings').attr('data-max'))*(jQuery('.db-find-listings').attr('data-page')-1))+parseInt($search_markers.length) + ' ' + db_main.search_of + ' ' + parsed_search_data.total);
				}
			}
			
			google.maps.event.addListener($search_map, 'dragend', function() {
				var filtered_listings = 0;
				jQuery.each($search_markers, function(index, marker_value) {
					if ( $search_map.getBounds().contains(marker_value.getPosition() ) ) {
						jQuery('.db-main-search-listings .db-main-search-item[data-id="'+jQuery(marker_value.content).attr('data-id')+'"]').removeClass('list-item-hidden');
						setTimeout(function() {
							$search_item_container.isotope( 'revealItemElements', jQuery('.db-main-search-listings .db-main-search-item[data-id="'+jQuery(marker_value.content).attr('data-id')+'"]').show() );
						}, 50);
						filtered_listings++;
					} else {
						jQuery('.db-main-search-listings .db-main-search-item[data-id="'+jQuery(marker_value.content).attr('data-id')+'"]').addClass('list-item-hidden');
						setTimeout(function() {
							$search_item_container.isotope( 'hideItemElements', jQuery('.db-main-search-listings .db-main-search-item[data-id="'+jQuery(marker_value.content).attr('data-id')+'"]') );
						}, 50);
					}
				});
				setTimeout(function() {
					if ( jQuery('.db-found-count').length ) {
						jQuery('.db-found-count').attr('data-found', filtered_listings);
					}
					$search_item_container.isotope('reloadItems').isotope();
					$search_item_container.scrollTop(0);
				}, 250);
			});

			google.maps.event.addListener($search_map, 'zoom_changed', function() {
				var filtered_listings = 0;
				jQuery.each($search_markers, function(index, marker_value) {
					if ( $search_map.getBounds().contains(marker_value.getPosition() ) ) {
						jQuery('.db-main-search-listings .db-main-search-item[data-id="'+jQuery(marker_value.content).attr('data-id')+'"]').removeClass('list-item-hidden');
						setTimeout(function() {
							$search_item_container.isotope( 'revealItemElements', jQuery('.db-main-search-listings .db-main-search-item[data-id="'+jQuery(marker_value.content).attr('data-id')+'"]').show() );
						}, 50);
						filtered_listings++;
					} else {
						jQuery('.db-main-search-listings .db-main-search-item[data-id="'+jQuery(marker_value.content).attr('data-id')+'"]').addClass('list-item-hidden');
						setTimeout(function() {
							$search_item_container.isotope( 'hideItemElements', jQuery('.db-main-search-listings .db-main-search-item[data-id="'+jQuery(marker_value.content).attr('data-id')+'"]') );
						}, 50);
					}
				});
				setTimeout(function() {
					if ( jQuery('.db-found-count').length ) {
						jQuery('.db-found-count').attr('data-found', filtered_listings);
					}
					$search_item_container.isotope('reloadItems').isotope();
					$search_item_container.scrollTop(0);
				}, 250);
			});

			setTimeout(function() {
				var map_bounds = new google.maps.LatLngBounds();

				jQuery.each($search_markers, function(index, marker) {
					map_bounds.extend(marker.position);
				});

				$search_map.fitBounds(map_bounds);
				if ( merker_count == 1 ) {
					$search_map.setZoom(13);
				}
				db_set_isotope();
			}, 200);
			
		} else {
			if ( parsed_search_data.map_changed && parsed_search_data.map_lat != null ) {
				setTimeout(function() {
					$search_map.setCenter(new google.maps.LatLng(parsed_search_data.map_lat, parsed_search_data.map_lng));
					$search_map.setZoom(10);
				}, 100);
			}

			jQuery('.db-main-search-listings').addClass('db-no-listings');
			jQuery('.db-main-search-listings').append('<div class="db-main-search-item full-listing" style="text-align: center;">No listings found!</div>');
			db_clear_markers();

			if ( jQuery('.db-found-count').length ) {
				jQuery('.db-found-count').attr('data-found', '0').attr('data-total-found', '0');
			}

			if ( parsed_search_data.gmsg != null ) {
				alert( parsed_search_data.gmsg );
			}
		}

		// Change to new url
		history.pushState({page: parsed_search_data.new_url}, '', parsed_search_data.new_url);

		jQuery('.db-search-side-two').removeClass('db-show-pagination');
		var current_listings = parseInt(jQuery('.db-found-count').attr('data-found'));
		var max_listings = parseInt(jQuery('.db-find-listings').attr('data-max'));
		var page = parseInt(jQuery('.db-find-listings').attr('data-page'));
		var total = parseInt(parsed_search_data.total);
		var current_count = ( ( max_listings * ( page - 1) ) + current_listings );

		jQuery('.db-found-count').removeClass('total-hidden');
		if ( current_count < total ) {
			jQuery('.db-search-next-page').removeClass('hidden');
			jQuery('.db-search-prev-page').removeClass('hidden');
		} else if ( current_count == total ) {
			jQuery('.db-search-next-page').addClass('hidden');
			jQuery('.db-search-prev-page').removeClass('hidden');

			if ( jQuery('.db-find-listings').attr('data-page') == 1 ) {
				jQuery('.db-found-count').addClass('total-hidden');
			}
		}

		if ( jQuery('.db-find-listings').attr('data-page') == 1 ) {
			jQuery('.db-search-prev-page').addClass('hidden');
		}

		whitelab_calculate_side_height();
	}

	jQuery(document).on('click', '.db-search-categories a', function() {
		var all_search_fields = {};
		all_search_fields.search_category = jQuery(this).attr('data-term-id')

		jQuery.ajax({
			type: 'POST',
			url: db_main.ajaxurl,
			data: { 
				'action': 'db_search_listings',
				'search_terms': JSON.stringify(all_search_fields),
				'db_full_url': window.location.href
			},
			success: function(data) {
				db_parse_search_data( data );
			}
		});
	});

	var $lastSearchScrollTop = 0;
	jQuery('.db-main-search-listings').scroll(function() {
		var st = jQuery(this).scrollTop();
		var scrolled_percentage = jQuery(this).scrollTop()/(jQuery(this)[0].scrollHeight-jQuery(this).innerHeight())*100;
		var extra_scroll = jQuery(this).find('.db-search-scrollbar').height()*(scrolled_percentage/100);
		var scroll_height = 'calc('+scrolled_percentage+'% - '+extra_scroll+'px + '+jQuery(this).scrollTop()+'px)';

		if ( jQuery(window).outerWidth() > 980 ) {

			if ( st < $lastSearchScrollTop ) {
				var extra_scroll = parseInt(jQuery(this).attr('data-scroll'))-($lastSearchScrollTop - st);
				if ( extra_scroll < 0 ) {
					extra_scroll = 0;
				}
				jQuery(this).attr('data-scroll', extra_scroll);
			}

			var max_search_height = parseInt( jQuery('.db-search-controls')['0'].scrollHeight );
			var current_search_height = max_search_height - ( jQuery(this).scrollTop() - parseInt( jQuery(this).attr('data-scroll') ) );
			if ( current_search_height > max_search_height ) {
				current_search_height = max_search_height;
			}
			var scrolled_value = 1 - ( current_search_height / max_search_height );
			var scrolled_value_rev = current_search_height / max_search_height;
			if ( scrolled_value > 0.7 ) {
				scrolled_value = 1;
			}
			if ( scrolled_value_rev < 0.3 ) {
				scrolled_value_rev = 0;
			}
			jQuery('.db-search-controls').css('height', current_search_height + 'px');

			var showmore_top = -12 * scrolled_value_rev;
			if ( showmore_top > 0 ) {
				showmore_top = 0;
			}
			var showmore_margin_top = 13 * scrolled_value;
			var showmore_margin_bottom = 36 * scrolled_value;
			var showmore_margin_height = 21 * scrolled_value;

			jQuery('.db-show-more-fields').css({
				'margin-bottom': '36px',
				'margin-top': showmore_margin_top + 'px',
				'height': showmore_margin_height + 'px',
				'top': showmore_top + 'px'
			});

			var scrolled_percentage_sec = (jQuery(this).scrollTop()-parseInt( jQuery(this).attr('data-scroll') ))/(jQuery(this)[0].scrollHeight-jQuery(this).innerHeight())*100;
			if ( scrolled_percentage_sec > 0 ) {
				jQuery(this).parent().addClass('db-hide-fields');
				jQuery('.db-show-more-fields').addClass('db-invisible');
			} else {
				jQuery(this).parent().removeClass('db-hide-fields');
				jQuery('.db-show-more-fields').removeClass('db-invisible');
			}

			if ( scrolled_percentage > 95 ) {
				jQuery(this).parent().addClass('db-show-pagination');
			} else {
				jQuery(this).parent().removeClass('db-show-pagination');
			}

			whitelab_calculate_side_height();

		}
		
		jQuery(this).find('.db-search-scrollbar').css('top', scroll_height);

		$lastSearchScrollTop = st;
	});

	if ( jQuery(window).outerWidth() < 1000 ) {
		jQuery('.db-main-search-listings').addClass('db-show-pagination');
	}

	jQuery(document).on('click', '.db-show-more-fields', function() {
		jQuery('.db-search-side-two').removeClass('db-hide-fields');
		jQuery('.db-search-controls').css('height', '');
		jQuery('.db-show-more-fields').css({
			'margin-bottom': '',
			'margin-top': '',
			'height': '',
			'top': ''
		});

		jQuery('.db-main-search-listings').attr('data-scroll', jQuery('.db-main-search-listings').scrollTop());

		setTimeout(function() {
			whitelab_calculate_side_height();
		}, 200);
	});

	function db_set_isotope() {
		if ( typeof $search_item_container.attr('style') == 'undefined' ) {
			$search_item_container.isotope({
				itemSelector: '.db-main-search-item:not(.list-item-hidden)',
				layoutMode: 'masonry',
				masonry: {
					gutter: 30
				},
				getSortData: jQuery.parseJSON(db_main.custom_sorting),
				sortBy: [ 'featured', 'name' ],
				sortAscending: jQuery.parseJSON(db_main.custom_sorting_dir),
				transitionDuration: '0.2s',
				hiddenStyle: {
					opacity: 0
				},
				visibleStyle: {
					opacity: 1
				}
			});
		} else {
			$search_item_container.isotope('reloadItems').isotope();
		}
	}

	jQuery(document).on('change', '.db-search-sort, #db-search-sort', function() {
		var sort_by_value = jQuery(this).val();
		$search_item_container.isotope({
			sortBy: [ 'featured', sort_by_value ],
		});
	});

	jQuery(document).on('click', '.db-contact-author', function() {
		jQuery.ajax({
			type: 'POST',
			url: db_main.ajaxurl,
			data: { 
				'action': 'db_send_contact_email',
				'db_author': jQuery(this).attr('data-author'),
				'db_message': jQuery('.db-contact-message').val(),
				'db_name': jQuery('.db-contact-name').val(),
				'db_email': jQuery('.db-contact-email').val()
			},
			success: function(data) {
				jQuery('.db-contact-status').html(data);
			}
		});
	});

	jQuery(document).on('change', '#listing_category', function() {
		var category_id = jQuery(this).val();
		jQuery('.db-payment-packages li').each(function() {
			var for_categories = jQuery(this).attr('data-for').split(',');
			if ( jQuery.inArray( category_id, for_categories ) < 0 ) {
				jQuery(this).hide();
			} else {
				jQuery(this).show();
			}
		});

		jQuery('.db-field-row.db-cat-for').each(function() {
			var for_categories = jQuery(this).attr('data-for').split(',');
			if ( jQuery.inArray( category_id, for_categories ) < 0 ) {
				jQuery(this).addClass('field-hidden');
			} else {
				jQuery(this).removeClass('field-hidden');
			}
		});
	});
	jQuery('#listing_category').trigger('change');

	jQuery(document).on('hover', '.db-rating-container span, .db-rating-container svg', function() {
		var selected_rating = jQuery(this).index()+1;
		jQuery(this).parent().removeClass('selected-1').removeClass('selected-2').removeClass('selected-3').removeClass('selected-4').removeClass('selected-5');
		jQuery(this).parent().addClass('selected-'+selected_rating);
	});

	jQuery(document).on('click', '.db-rating-container span, .db-rating-container svg', function() {
		var active_rating = jQuery(this).index()+1;
		jQuery(this).parent().removeClass('active-1').removeClass('active-2').removeClass('active-3').removeClass('active-4').removeClass('active-5');
		jQuery(this).parent().addClass('active-'+active_rating);
		jQuery(this).parent().parent().find('[name="listing_rating"][value="'+active_rating+'"]').prop('checked', true);
	});

	jQuery(document).on('mouseout', '.db-rating-stars', function(e) {
		if ( jQuery(e.target).hasClass('db-rating-container') ) {
			jQuery('.db-rating-container').removeClass('selected-1').removeClass('selected-2').removeClass('selected-3').removeClass('selected-4').removeClass('selected-5');
		}
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

		jQuery('.db-hop-dialog .db-hop-left label.active input').prop('checked', false);
		jQuery('.db-hop-dialog .db-hop-left label.active').removeClass('active');
		jQuery('.db-hop-from').val('');
		jQuery('.db-hop-till').val('');
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

	jQuery(document).on('click', function(e) {
		if ( !jQuery(e.target).hasClass('db-add-new-hop') ) {
			if ( jQuery('.db-hop-dialog').css('display') == 'block' ) {
				jQuery(".db-hop-dialog").hide();
			}
		}
	});

	jQuery(".db-hop-dialog").click(function(e) {
		if ( !jQuery(e.target).hasClass('db-hop-add-time') ) {
			e.stopPropagation();
		}
	});

	function whitelab_calculate_side_height() {
		if ( jQuery('.db-search-side-two.left').length || jQuery('.db-search-side-two.right').length ) {
			var header = jQuery('header.site-header').outerHeight() + 26;
			var search = jQuery('.db-search-controls').outerHeight();
			var showmore = jQuery('.db-show-more-fields').outerHeight() + parseInt( jQuery('.db-show-more-fields').css('margin-bottom').replace('px', 'px') ) + 13;
			if ( !jQuery('body').hasClass('admin-bar') ) {
				header -= 32;
			}

			var custom_val = 0;
			if ( jQuery('.db-search-side-two').hasClass('db-show-pagination') ) {
				custom_val = 30;
			}

			if ( !jQuery('#whitelab-search-height').length ) {
				jQuery('body').append('<style type="text/css" id="whitelab-search-height">@media (min-width: 992px) {body .db-main-search-listings{height: calc(100vh - '+(header+search+showmore+custom_val)+'px) !important;}}</style>');
			} else {
				jQuery('body #whitelab-search-height').html('@media (min-width: 992px) {body .db-main-search-listings{height: calc(100vh - '+(header+search+showmore+custom_val)+'px) !important;}}');
			}
		}
	}

	whitelab_calculate_side_height();

	jQuery(document).on('click', '.db-autolocate-me', function() {
		var geolocate_button = jQuery(this);
		var geolocation_field = jQuery(this).prev();

		if ( navigator.geolocation ) {
			navigator.geolocation.getCurrentPosition(function( position ) {
				jQuery.get('https://maps.googleapis.com/maps/api/geocode/json?address='+encodeURIComponent(position.coords.latitude+','+position.coords.longitude)+'&language=en', function( data ) {
					if ( data.status == 'OK' ) {
						geolocation_field.val( data.results['0'].formatted_address );

						if ( jQuery('.db-set-address').length ) {
							jQuery('.db-set-address').click();
						}
					} else {
						if ( data.status == 'OVER_QUERY_LIMIT' ) {
							alert('You\'re over your API query limit!');
						} else if ( data.status == 'REQUEST_DENIED' ) {
							alert('Seems like your address request was denied by Google!');
						} else {
							alert('Something went wrong while contacting Google!');
						}
					}
				});
			}, function( error ) {
				console.log('Failed to geolocate your location');
			}, { timeout: 30000, enableHighAccuracy: true });
		} else {
			alert('Your browser doesn\'t support geolocation');
		}
	});

	jQuery(document).on('change', '.db-pricing-main-wrapper.default [name="listing_package"]', function() {
		var current_package = jQuery(this).val();

		jQuery.ajax({
			type: 'POST',
			url: db_main.ajaxurl,
			data: { 
				'action': 'db_get_current_package',
				'package_id': current_package
			},
			success: function( data ) {
				var parsed_resp = jQuery.parseJSON(data);
				if ( parsed_resp.status == 'success' ) {
					if ( parsed_resp.fee_amount != '0' ) {
						jQuery('[name="custom"]').val(jQuery('[name="db-listing-id"]').val()+':'+parsed_resp.author+':author');
						jQuery('[name="db-package-fee"], [name="a3"], [name="amount"]').val(parsed_resp.fee_amount);
						jQuery('[name="item_name"]').val(parsed_resp.fee_label);

						if ( parsed_resp.payment_type == 'onetime' ) {
							jQuery('[name="cmd"]').val('_xclick');
						} else {
							jQuery('[name="cmd"]').val('_xclick-subscriptions');
							jQuery('[name="p3"]').val(parsed_resp.payment_interval);
							jQuery('[name="t3"]').val(parsed_resp.payment_cycle.charAt(0).toUpperCase());
						}

						jQuery('.db-main-checkout-wrapper').addClass('db-animate-dialog');
						setTimeout(function() {
							jQuery('.db-main-checkout-wrapper').next().addClass('overlay-shown');
						}, 150);
					} else {
						jQuery.ajax({
							type: 'POST',
							url: db_main.ajaxurl,
							data: { 
								'action': 'db_save_claim',
								'listing_id': jQuery('[name="db-listing-id"]').val(),
								'package_id': current_package,
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
					}
				}
			}
		});
	});

	jQuery(document).on('click', '.db-checkout-item', function() {
		jQuery('.db-checkout-select .db-checkout-item').removeClass('active');
		jQuery(this).addClass('active');

		jQuery('.db-checkout-option').hide();
		jQuery('.db-checkout-option.'+jQuery(this).attr('data-type')).show();
	});

	jQuery(document).on('submit', '#authorize_form', function(e) {
		e.preventDefault();

		var all_fields = {};
		jQuery('#authorize_form .db-checkout-left [name]').each(function() {
			all_fields[jQuery(this).attr('name')] = jQuery(this).val();
		});

		var card_fields = {};
		jQuery('#authorize_form .db-checkout-right [name]').each(function() {
			card_fields[jQuery(this).attr('name')] = jQuery(this).val();
		});

		jQuery('#authorize_form .db-checkout-proceed').addClass('loading-effect');

		jQuery.ajax({
			type: 'POST',
			url: db_main.ajaxurl,
			data: { 
				'action': 'db_save_billing',
				'field_data': JSON.stringify(all_fields),
				'card_data': JSON.stringify(card_fields),
				'listing_id': jQuery('[name="db-listing-id"]').val(),
				'gateway': 'authorizenet'
			},
			success: function(data) {
				var parsed_resp = jQuery.parseJSON(data);
				if ( jQuery.isNumeric(parsed_resp.save_response) ) {
					window.location.replace(jQuery('.db-main-checkout').attr('data-return'));
				} else {
					if ( jQuery('#authorize_form .db-checkout-proceed .db-checkout-error').length ) {
						jQuery('#authorize_form .db-checkout-proceed .db-checkout-error').html(parsed_resp.message);
					} else {
						jQuery('#authorize_form .db-checkout-proceed').prepend('<span class="db-checkout-error">'+parsed_resp.message+'</span>')
					}
					jQuery('#authorize_form .db-checkout-proceed').removeClass('loading-effect');
				}
			}
		});
	});

	jQuery(document).on('click', '.db-pricing-main-wrapper.default .db-checkout-close', function() {
		jQuery('.db-main-checkout-wrapper').removeClass('db-animate-dialog');
		jQuery('.db-main-checkout-wrapper').next().removeClass('overlay-shown');
	});

	jQuery(document).on('input', 'input[type="date"]', function() {
		var current_value = jQuery(this).val();
		var parsed_values = jQuery(this).val().split('-');

		if ( parsed_values['0'].length > 4 ) {
			var new_date = parsed_values['0'].slice(0,4) + '-' + parsed_values['1'] + '-' + parsed_values['2'];
			jQuery(this).val(new_date);
		}
	});
});

jQuery(window).load(function() {
	var $geocoder;
	var $map;
	var $first_marker;
	function db_start_geolocation() {
		$geocoder = new google.maps.Geocoder()
		$geocoder.geocode( { "address": db_main.default_location}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				db_initialize(results[0].geometry.location);
			} 
		});
	}
	
	function db_initialize(location) {
		var mapCanvas = document.getElementById("db-listing-map");
		var myLatlng = location;
		var mapOptions = {
			center: location,
			zoom: 13,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false,
			navigationControl: false,
			mapTypeControl: false,
			scaleControl: false,
			disableDefaultUI: false
		}
		if ( jQuery('body').hasClass('directory-theme') ) {
			mapOptions['styles'] = jQuery.parseJSON(my_ajax.map_style);
		}
		$map = new google.maps.Map(mapCanvas, mapOptions);

		$first_marker = new google.maps.Marker({
			position: myLatlng,
			map: $map,
			draggable: true
		});
		db_add_dragend_event( $first_marker );
	}

	function db_add_dragend_event( marker_obj ) {
		google.maps.event.addListener(marker_obj, "dragend", function (event) {
			jQuery("#listing_address_lat").val(this.getPosition().lat());
			jQuery("#listing_address_lng").val(this.getPosition().lng());
			jQuery('.db-set-address').addClass('dragged').click();
		});
	}
	if ( jQuery('#db-listing-map').length ) {
		db_start_geolocation();
	}
	jQuery(document).on("click", ".db-set-address", function() {
		var google_json_address;
		if ( !jQuery(this).hasClass('dragged') ) {
			google_json_address = encodeURIComponent( jQuery('#listing_address').val() );
		} else {
			google_json_address = encodeURIComponent( jQuery('#listing_address_lat').val()+','+jQuery('#listing_address_lng').val() );
		}
		jQuery.get('https://maps.googleapis.com/maps/api/geocode/json?address='+google_json_address+'&language=en', function( data ) {
			if ( data.status == 'OK' ) {
				$first_marker.setMap(null);
				var marker = new google.maps.Marker({ position: data.results['0'].geometry.location, map: $map, draggable: true });
				$first_marker = marker;
				db_add_dragend_event( $first_marker );

				jQuery('#listing_city, #listing_zip, #listing_neighborhood, #listing_state').val('');
				jQuery.each(data.results['0'].address_components, function( index, address_comp ) {
					if( ( address_comp.types[0] == "locality" && address_comp.types[1] == "political" ) || address_comp.types[0] == "postal_town" ) {
						jQuery('#listing_city').val( address_comp.long_name );
					}

					if( address_comp.types[0] == "country" && address_comp.types[1] == "political" ) {
						jQuery('[name="listing_country"]').val( address_comp.long_name );
						jQuery('[name="listing_country"]').parent().find('.dt-custom-select').val( address_comp.long_name );

						if ( !jQuery('[name="listing_country"]').parent().find('.dt-custom-select-item[data-value="'+address_comp.long_name+'"]').length ) {
							jQuery('[name="listing_country"]').parent().find('.dt-custom-select-items').append('<div class="dt-custom-select-item" data-value="'+address_comp.long_name+'">'+address_comp.long_name+'</div>');
						}

						jQuery('[name="listing_country"]').parent().find('.dt-custom-select-item[data-value="'+address_comp.long_name+'"]').addClass('active');
					}

					if( address_comp.types[0] == "postal_code" ) {
						jQuery('#listing_zip').val( address_comp.long_name );
					}

					if ( ( address_comp.types[0] == "administrative_area_level_1" && address_comp.types[1] == "political" ) || address_comp.types[0] == "neighborhood" && address_comp.types[1] == "political" ) {
						jQuery('#listing_neighborhood').val( address_comp.long_name );
					}

					if ( address_comp.types[0] == "administrative_area_level_2" && address_comp.types[1] == "political" ) {
						jQuery('#listing_state').val( address_comp.long_name );
					}
				});

				jQuery('#listing_address').val( data.results['0'].formatted_address );

				jQuery('#listing_address_lat').val(data.results['0'].geometry.location.lat);
				jQuery('#listing_address_lng').val(data.results['0'].geometry.location.lng);

				$map.setCenter(data.results['0'].geometry.location);
				jQuery('.db-set-address').removeClass('dragged');
			} else {
				if ( data.status == 'OVER_QUERY_LIMIT' ) {
					alert('You\'re over your API query limit!');
				} else if ( data.status == 'REQUEST_DENIED' ) {
					alert('Seems like your address request was denied by Google!');
				} else {
					alert('Your address couldn\'t be found');
				}
			}
		});
	});

	if ( jQuery('.db-find-listings').length ) {
		jQuery(document).keydown(function(e) {
			if ( e.keyCode == 13 && jQuery(e.target).closest('.db-main-search').length ) {
				jQuery('.db-find-listings').attr('data-page', '1');
				jQuery('.db-find-listings').click();
			}
		});
	}

	// Search listing map
	if ( jQuery('#db-main-search-map').length && !jQuery('#dt-main-listing-search').length ) {
		if ( jQuery('body').hasClass('page-template-template-listing_search') ) {
			jQuery('#db-main-search-map').height(jQuery('#dt-main-listing-search').outerHeight());
		}
		var mapCanvas = document.getElementById("db-main-search-map");
		var location = new google.maps.LatLng(db_main.default_location_lat, db_main.default_location_lng);
		var mapOptions = {
			center: location,
			zoom: 13,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			scrollwheel: false,
			navigationControl: false,
			mapTypeControl: false,
			scaleControl: false,
			disableDefaultUI: false
		}
		$search_map = new google.maps.Map(mapCanvas, mapOptions);
	}

	jQuery(document).on('click', '.db-delete-listing', function() {
		if ( confirm('Are you sure you want to delete this listing?') ) {
			var listing_row = jQuery(this).parent().parent();
			jQuery.ajax({
				type: 'POST',
				url: db_main.ajaxurl,
				data: { 
					'action': 'db_account_delete_listing',
					'listing_id': jQuery(this).attr('data-id')
				},
				success: function(data) {
					if ( jQuery.isNumeric(jQuery.parseJSON(data).save_response) ) {
						listing_row.remove();
					}
				}
			});
		}
	});

	if ( jQuery('.db-find-listings').length ) {
		if ( jQuery('.db-find-listings').hasClass('onload') ) {
			jQuery('.db-find-listings').click();
		} else if ( jQuery('.db-search-categories a').hasClass('onload') ) {
			jQuery('.db-search-categories a.onload').click();
		}
	}

	jQuery(document).on('submit', '#db-add-listing-form', function(e) {
		var form_validated = true;

		if ( jQuery('[name="login_user_email"]').length && !jQuery('[name="register_user_email"]').length && ( !jQuery('[name="login_user_email"]').val() || !jQuery('[name="login_user_password"]').val() ) ) {
			// Only login field present
			form_validated = false;
		} else if ( jQuery('[name="login_user_email"]').length && jQuery('[name="register_user_email"]').length ) {
			// Login and register field present
			if ( ( !jQuery('[name="login_user_email"]').val() || !jQuery('[name="login_user_password"]').val() ) && ( !jQuery('[name="register_user_email"]').val() || !jQuery('[name="register_user_password"]').val() ) ) {
				form_validated = false;
			}
		}

		if ( !form_validated ) {
			e.preventDefault();
			jQuery("html, body").animate({ scrollTop: 0 }, "slow");
			return false;
		}
	});

	if ( jQuery('#db-register-form').length ) {
		var password = jQuery('[name="register_user_password"]');
		var confirm_password = jQuery('[name="register_user_password_confirm"]');

		function db_validate_password() {
			if ( password.val() != confirm_password.val() ) {
				confirm_password.get(0).setCustomValidity("Passwords Doesn't Match");
			} else {
				confirm_password.get(0).setCustomValidity('');
			}
		}

		jQuery(document).on('change', '[name="register_user_password"]', db_validate_password);
		jQuery(document).on('input', '[name="register_user_password_confirm"]', db_validate_password);
	}



	var $idle_timer;
	jQuery(document).on('input', '[name="listing_city"]', function() {
		clearTimeout($idle_timer);
		var city_name = jQuery(this).val();
		var city_row = jQuery(this).parent();

		if ( jQuery(this).val().length >= 1 ) {
			$idle_timer = setTimeout(function() {
				jQuery.ajax({
					type: 'POST',
					url: db_main.ajaxurl,
					data: { 
						'action': 'db_city_autocomplete',
						'city_value': city_name
					},
					success: function( data ) {
						if ( !city_row.find('.db-row-autocomplete').length ) {
							city_row.append('<div class="db-row-autocomplete" data-active="listing_city"><div class="db-autocomplete-inner"><div class="db-autocomplete-items"></div><div class="db-autocomplete-scrollbar-wrapper"><span class="db-autocomplete-scrollbar"></span></div></div></div>');
						}

						city_row.find('.db-row-autocomplete .db-autocomplete-items').html('');

						if ( data != 'failed' ) {
							var parsed_data = jQuery.parseJSON( data );
							jQuery.each(parsed_data, function( index, value ) {
								city_row.find('.db-row-autocomplete .db-autocomplete-items').append('<span class="db-autocomplete-item">'+value+'</span>');
							});
						} else {
							city_row.find('.db-row-autocomplete .db-autocomplete-items').append('<span class="db-autocomplete-item not-active">Nothing found!</span>');
						}
						city_row.find('.db-row-autocomplete').addClass('active');

						if ( city_row.find('.db-autocomplete-items')[0].scrollHeight < 139 ) {
							city_row.find('.db-autocomplete-scrollbar').hide();
						} else {
							city_row.find('.db-autocomplete-scrollbar').show();
						}

						city_row.find('.db-autocomplete-items').bind('scroll', function() {
							var scrolled_percentage = jQuery(this).scrollTop()/(jQuery(this)[0].scrollHeight-jQuery(this).innerHeight())*100;
							var extra_scroll = jQuery(this).parent().parent().find('.db-autocomplete-scrollbar').height()*(scrolled_percentage/100);
							var scroll_height = 'calc('+scrolled_percentage+'% - '+extra_scroll+'px)';
							jQuery(this).parent().parent().find('.db-autocomplete-scrollbar').css('top', scroll_height);
						});

						city_row.find('.db-autocomplete-scrollbar').css('height', city_row.find('.db-autocomplete-items')[0].offsetHeight*(city_row.find('.db-autocomplete-items')[0].offsetHeight/city_row.find('.db-autocomplete-items')[0].scrollHeight));
					}
				});
			}, 500);
		} else {
			city_row.find('.db-row-autocomplete').removeClass('active');
		}
	});

	var $idle_timer2;
	jQuery(document).on('input', '.dt-header-search-inner #dt-search-listing_address', function() {
		clearTimeout($idle_timer2);
		var address_value = jQuery(this).val();
		var address_row = jQuery(this).parent();

		if ( jQuery(this).val().length >= 1 ) {
			$idle_timer2 = setTimeout(function() {
				jQuery.ajax({
					type: 'POST',
					url: db_main.ajaxurl,
					data: { 
						'action': 'db_address_autocomplete',
						'address_value': address_value
					},
					success: function( data ) {
						if ( !address_row.find('.db-row-autocomplete').length ) {
							address_row.append('<div class="db-row-autocomplete" data-active="listing_city"><div class="db-autocomplete-inner"><div class="db-autocomplete-items"></div><div class="db-autocomplete-scrollbar-wrapper"><span class="db-autocomplete-scrollbar"></span></div></div></div>');
						}

						address_row.find('.db-row-autocomplete .db-autocomplete-items').html('');

						if ( data != 'failed' ) {
							var parsed_data = jQuery.parseJSON( data );
							jQuery.each(parsed_data, function( index, value ) {
								address_row.find('.db-row-autocomplete .db-autocomplete-items').append('<span class="db-autocomplete-item">'+value+'</span>');
							});
						} else {
							address_row.find('.db-row-autocomplete .db-autocomplete-items').append('<span class="db-autocomplete-item not-active">Nothing found!</span>');
						}
						address_row.find('.db-row-autocomplete').addClass('active');

						if ( address_row.find('.db-autocomplete-items')[0].scrollHeight < 139 ) {
							address_row.find('.db-autocomplete-scrollbar').hide();
						} else {
							address_row.find('.db-autocomplete-scrollbar').show();
						}

						address_row.find('.db-autocomplete-items').bind('scroll', function() {
							var scrolled_percentage = jQuery(this).scrollTop()/(jQuery(this)[0].scrollHeight-jQuery(this).innerHeight())*100;
							var extra_scroll = jQuery(this).parent().parent().find('.db-autocomplete-scrollbar').height()*(scrolled_percentage/100);
							var scroll_height = 'calc('+scrolled_percentage+'% - '+extra_scroll+'px)';
							jQuery(this).parent().parent().find('.db-autocomplete-scrollbar').css('top', scroll_height);
						});

						address_row.find('.db-autocomplete-scrollbar').css('height', address_row.find('.db-autocomplete-items')[0].offsetHeight*(address_row.find('.db-autocomplete-items')[0].offsetHeight/address_row.find('.db-autocomplete-items')[0].scrollHeight));
					}
				});
			}, 500);
		} else {
			address_row.find('.db-row-autocomplete').removeClass('active');
		}
	});

	jQuery(document).on('click', '.db-autocomplete-item', function() {
		if ( !jQuery('.dt-header-search-inner').length ) {
			jQuery('[name="'+jQuery(this).parent().parent().parent().attr('data-active')+'"]').val( jQuery(this).text() );
		} else {
			jQuery('#dt-search-listing_address').val( jQuery(this).text() );
		}
		jQuery(this).parent().parent().parent().removeClass('active');
	});

	jQuery(document).on('click', '.db-show-checkout-terms', function() {
		jQuery(this).next().toggleClass('hidden');
	});
});