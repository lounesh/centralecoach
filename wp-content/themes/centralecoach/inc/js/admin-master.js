// Admin Javascript
jQuery( document ).ready( function( $ ) {

	// Choose layout
	$("#vh_layouts img").click(function() {
		$(this).parent().parent().find(".selected").removeClass("selected");
		$(this).addClass("selected");
	});

	$('.rpp_show-expert-options').live('change', function(){
		if( $(this).is(':checked') ) {
			$(this).parent().parent().find('.rpp_expert-panel').show();
		} else {
			$(this).parent().parent().find('.rpp_expert-panel').hide();
		}
	});

	jQuery(document).on('click', '.directory-rating-dismiss', function() {
		jQuery.ajax({
			type: 'POST',
			url: ajaxurl,
			data: { 
				'action': 'directory_dismiss_notice'
			},
			success: function(data) {
				jQuery('.directory-rating-notice').remove();
			}
		});
	});

	/**
	 * ----------------------------------------------------------------------
	 * Theme installation wizard action:
	 * 2. Import demo content
	 */

	$("#do_demo-import").click(function(event) {
		event.preventDefault();

		// Do not run multiply times
		if ( ! $("#theme-setup-step-2").hasClass('step-completed') ) {
			// Do not run before step 1
			if ( $("#theme-setup-step-1").hasClass('step-completed') ) {
				// Do not run before step 2
				// if ( $("#theme-setup-step-2").hasClass('step-completed') ) {

					$("#theme-setup-step-2").addClass('loading');
					$.ajax({
						// type: "POST",
						cache: false,
						url: location.protocol + '//' + location.host + location.pathname + "?importcontent=alldemocontent",
						success: function(response){
							$("#theme-setup-step-2").removeClass('loading');

							// config process failed
							if ( $(response).find(".ajax-request-error").length > 0 ) {
								$(".vhman-message.quick-setup .step-demoimport .error").css('display', 'inline-block');
								$(".vhman-message.quick-setup").after('<div class="error-log-window" style="display:none"></div>');
								$(".error-log-window").append( $(response).find(".ajax-log") );

								$('.vhman-message.quick-setup .step-demoimport .error-log-window').css('display','inline-block');

							// config process succeeded
							} else {
								$(".vhman-message.quick-setup .step-demoimport").addClass("step-completed");

								// update option "WHITELAB_THEMENAME . '_democontent_imported'"
								// with 'true' value
								$.ajax({
									cache: false,
									url: location.protocol + '//' + location.host + location.pathname + "?demoimport=completed",
								});
							}
						},

					}); //ajax

				// } else {
				// 	$( "#theme-setup-step-2" ).effect( "bounce", 1000);
				// }
			} else {
				$( "#theme-setup-step-1" ).effect( "bounce", 1000);
			}
		}
	});

	jQuery( document ).ready( function( $ ) {
		jQuery(document).on('click', '.whitelab-load-notice .notice-dismiss', function() {
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: { 
					'action': 'whitelab_dismiss_admin_notice'
				}
			});
		});
	});

	jQuery(document).on('click', '.whitelab-add-sidebar', function() {
		add_sidebar(jQuery('#sidebar_name').val(), jQuery('#sidebar_type').val());
	});

	jQuery(document).on('click', '.add-sidebar-button', function() {
		add_sidebar_link();
	});

	jQuery(document).on('click', '.whitelab-remove-sidebar', function() {
		remove_sidebar_link(jQuery(this).parent().parent().find('td').first().text(),jQuery(this).parent().parent().index()+1);
	});

	function add_sidebar( sidebar_name, sidebar_type ) {
		if (sidebar_name != null && sidebar_name != '' && sidebar_type != null && sidebar_type != '') {
			jQuery.ajax({
				type: "POST",
				url: ajaxurl,
				data: { action: "add_sidebar", sidebar_name: sidebar_name, sidebar_type: sidebar_type }
			}).done(function( msg ) {
				location.reload();
			});
			
			return true;
		} else {
			alert('Please enter Sidebar Name');

			return false;
		}
	}

	function remove_sidebar( sidebar_name, num, sidebar_type ) {
		jQuery.ajax({
				type: "POST",
				url: ajaxurl,
				data: { action: "remove_sidebar", sidebar_name: sidebar_name, row_number: num }
			}).done(function( msg ) {
				location.reload();
			});

		return true;
	}

	function remove_sidebar_link(name,num){
		answer = confirm("Are you sure you want to remove " + name + "?\nThis will remove any widgets you have assigned to this sidebar.");
		if(answer){
			remove_sidebar(name,num);
		}else{
			return false;
		}
	}

	function add_sidebar_link() {
		jQuery('#sbg_table tr:last').after('<tr><td><b>Sidebar Name:</b><br /><input type="text" name="sidebar_name" id="sidebar_name" /></td><td><b>Sidebar Type:</b><br /><select name="sidebar_type" id="sidebar_type"><option value="normal">Normal</option></select></td><td></td><td class="align-center"><a href="javascript:void(0)" class="whitelab-add-sidebar" title="Remove this sidebar">save</a></td></tr>');
		jQuery('.add-sidebar-button').attr("disabled", "disabled");
	}

	jQuery('.wp-list-table.plugins tbody tr').each(function() {
		if ( jQuery(this).find('.row-actions .update').length ) {
			jQuery(this).addClass('update');
			if ( jQuery(this).hasClass('active') ) {
				var extra_class = ' active';
			} else {
				var extra_class = '';
			}
			var plugin_name = jQuery(this).find('.plugin-title strong').text();
			var update_url = jQuery(this).find('.row-actions .update a').attr('href')
			jQuery(this).after('<tr class="plugin-update-tr'+extra_class+'"><td colspan="3" class="plugin-update colspanchange"><div class="update-message notice inline notice-warning notice-alt"><p>There is a new version of '+plugin_name+' available, <a href="'+update_url+'">update now</a>.</p></div></td></tr>');
		}
	});
});