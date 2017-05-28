/**
 * main.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2015, Codrops
 * http://www.codrops.com
 */
(function() {

	var docElem = window.document.documentElement,
		// transition end event name
		transEndEventNames = { 'WebkitTransition': 'webkitTransitionEnd', 'MozTransition': 'transitionend', 'OTransition': 'oTransitionEnd', 'msTransition': 'MSTransitionEnd', 'transition': 'transitionend' },
		transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
		element_text_classes = '.site-navigation > div > ul > li > a, .dt-module-front-title, .dt-module-background-title, .dt-header-search .dt-search-row label, .dt-featured-listings-image-meta > span, .dt-featured-listings-title, .dt-featured-listings-description, .dt-popular-cities .dt-popular-city-item, .dt-quote-item, .dt-quote-author, .dt-quote-author-position, .dt-how-front-title, .dt-how-background-title, p.dt-how-content, .dt-blog-item-tag, .dt-blog-item-date, .dt-blog-item-title, .dt-blog-item-author, .dt-blog-item-author a, .dt-blog-item-category, .dt-footer-copyright, .footer-menu-wrapper > div > ul li a, .db-single-listing-category, .single-listing-title, #page p, #page h1, #page h2, #page h3, #page h4, #page h5, #page h6, .db-amenities-overflow, .db-review-title, .db-rating-text, .db-single-contact-item, .db-single-category a, .db-single-title, .db-post-meta, .db-post-meta a, .comment-author, .comment-date, .db-field-row-label, .db-single-opening-hours span, .dt-header-categories .dt-header-category-item, ul.nav-menu li a, .like-thumb-liked';

	function scrollX() { return window.pageXOffset || docElem.scrollLeft; }
	function scrollY() { return window.pageYOffset || docElem.scrollTop; }
	function getOffset(el) {
		var offset = el.getBoundingClientRect();
		return { top : offset.top + scrollY(), left : offset.left + scrollX() };
	}

	function dragMoveListener(event) {
		var target = event.target,
			// keep the dragged position in the data-x/data-y attributes
			x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
			y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

		// translate the element
		target.style.transform = target.style.webkitTransform = 'translate(' + x + 'px, ' + y + 'px)';
		target.style.zIndex = 10000;

		// update the posiion attributes
		target.setAttribute('data-x', x);
		target.setAttribute('data-y', y);
	}

	function revertDraggable(el) {
		el.style.transform = el.style.webkitTransform = 'none';
		el.style.zIndex = 1;
		el.setAttribute('data-x', 0);
		el.setAttribute('data-y', 0);
	}

	function init() {
		// target elements with the "drag-element" class
		interact('.drag-element').draggable({
			// enable inertial throwing
			inertia: true,
			// call this function on every dragmove event
			onmove: dragMoveListener,
			onend: function (event) {
				if(!classie.has(event.target, 'drag-element--dropped') && !classie.has(event.target, 'drag-element--dropped-text')) {
					revertDraggable(event.target);
				}
			}
		});

		// enable draggables to be dropped into this
		interact('.paint-area, .dt-module-front-title, .dt-module-background-title, .dt-header-search .dt-search-row label, .dt-header-search-submit, .dt-featured-listings-image-note, .dt-featured-listings-image-meta > span, .dt-featured-listings-title, .dt-featured-listings-description, .dt-popular-cities .dt-popular-city-item, .dt-quote-item, .dt-quote-author, .dt-quote-author-position, .dt-how-front-title, .dt-how-background-title, p.dt-how-content, .dt-blog-item-tag, .dt-blog-item-date, .dt-blog-item-title, .dt-blog-item-author, .dt-blog-item-author a, .dt-blog-item-category, .dt-footer-copyright, .footer-menu-wrapper > div > ul li a, .dt-featured-listings-data, .dt-blog-item-bottom, .db-single-listing-category, .single-listing-title, #page p, #page h1, #page h2, #page h3, #page h4, #page h5, #page h6, .db-amenities-overflow, .db-review-title, .db-rating-text, .db-single-contact-item, .db-single-listing-side-container, .db-single-listing-main, .db-single-category a, .db-single-title, .db-post-meta, .db-post-meta a, body.single .entry-content, .comments-container, .comment-author, .comment-date, .db-field-row-label, .db-single-opening-hours span, .dt-header-categories .dt-header-category-item, ul.nav-menu li a, .like-thumb-liked, button, input[type="submit"]').dropzone({
			// only accept elements matching this CSS selector
			accept: '.drag-element',
			// Require a 45% element overlap for a drop to be possible
			overlap: 0.10,
			ondragenter: function (event) {
				classie.add(event.target, 'paint-area--highlight');
			},
			ondragleave: function (event) {
				classie.remove(event.target, 'paint-area--highlight');
			},
			ondrop: function (event) {
				var type = 'area';
				if(classie.has(event.target, 'paint-area--text') || jQuery(event.target).is(element_text_classes)) {
					type = 'text';
				}

				var draggableElement = event.relatedTarget;

				// call ajax to update choice
				var customizerElementID = jQuery(event.target).attr('id');
				var customizerElementClass = jQuery(event.target).removeClass('paint-area--highlight paint--active active').attr('class');
				var customizerParentElementID = jQuery(event.target).parent().attr('id');
				var customizerParentElementClass = '.'+jQuery(event.target).parent().removeClass('paint-area--highlight paint--active active').attr('class');
				var elementType = type;
				var customizerColor = draggableElement.getAttribute('data-color');
				var elementTag = jQuery(event.target).prop('tagName').toLowerCase();
				var current_element = jQuery(event.target);
				var valid_path = '';

				if (( typeof customizerElementID === 'undefined' || customizerElementID == 'undefined' || customizerElementID == '' )
					&& ( typeof customizerElementClass === 'undefined' || customizerElementClass == 'undefined' || customizerElementClass == '' ) ) {
					// no class and id
					valid_path = elementTag;
					var has_attribute = false;
					var loop_element = '';
					valid_path = checkParentElements(current_element, valid_path);
				} else if ( typeof customizerElementID === 'undefined' || customizerElementID == 'undefined' || customizerElementID == '' ) {
					// has class
					valid_path = '.'+jQuery(event.target).attr('class').split(' ').join('.');
					valid_path = checkParentElements(jQuery(event.target), valid_path);
				} else {
					// has id
					valid_path = '#'+jQuery(event.target).attr('id');
					valid_path = checkParentElements(jQuery(event.target), valid_path);
				}

				jQuery('.customizer').addClass('disabled');
				valid_path = valid_path.replace('. ',' ').replace('..','.');

				console.log(valid_path);

				if ( valid_path.indexOf(".next.page-numbers") >= 0 || valid_path.indexOf(".prev.page-numbers") >= 0 ) {
					elementType = 'area';
				}

				classie.add(draggableElement, type === 'text' ? 'drag-element--dropped-text' : 'drag-element--dropped');

				var onEndTransCallbackFn = function(ev) {
					this.removeEventListener( transEndEventName, onEndTransCallbackFn );
					if( type === 'area' ) {
						paintArea(event.dragEvent, event.target, draggableElement.getAttribute('data-color'), valid_path);
					}
					setTimeout(function() {
						revertDraggable(draggableElement);
						classie.remove(draggableElement, type === 'text' ? 'drag-element--dropped-text' : 'drag-element--dropped');
					}, type === 'text' ? 0 : 250);
				};
				if( type === 'text' ) {
					paintArea(event.dragEvent, event.target, draggableElement.getAttribute('data-color'), valid_path);
				}
				draggableElement.querySelector('.drop').addEventListener(transEndEventName, onEndTransCallbackFn);

				jQuery.ajax({
					type: 'POST',
					url: my_ajax.ajaxurl,
					data: {"action": "update_whitelab_customizer", path: 'body '+valid_path, element: customizerElementID, parent: customizerParentElementID, type: elementType, color: customizerColor, tag: elementTag },
					success: function(response) {
						jQuery('.customizer').removeClass('disabled');
						var path = valid_path;

						if ( path.indexOf('menu-item-') >= 0 ) {
							var old_style = jQuery('#directory-style-inline-css').html();
							var current_color = jQuery('.menu-item a').css('color');
							var new_style = '.site-navigation > div > ul > li > a:after { background-color:'+current_color+'; }.site-navigation > div > ul > li:hover > a {color:#fff !important;}';

							jQuery('#directory-style-inline-css').html(old_style+new_style);
						} else if ( path.indexOf('more-link') >= 0 ) {
							var old_style = jQuery('#directory-style-inline-css').html();
							var current_color = jQuery('article.hentry .more-link').css('color');
							var new_style = 'article.hentry .more-link:hover {border-color:'+current_color+';background-color:'+current_color+';color:#fff !important;}';

							jQuery('#directory-style-inline-css').html(old_style+new_style);
						} else if ( path.indexOf('post-edit-link') >= 0 ) {
							var old_style = jQuery('#directory-style-inline-css').html();
							var current_color = jQuery('article.hentry .post-edit-link').css('color');
							var new_style = 'article.hentry .post-edit-link:hover {border-color:'+current_color+';background-color:'+current_color+';color:#fff !important;}';

							jQuery('#directory-style-inline-css').html(old_style+new_style);
						} else if ( path.indexOf('page-numbers.current') >= 0 ) {
							var old_style = jQuery('#directory-style-inline-css').html();
							var current_color = jQuery('page-numbers.current').css('color');
							var new_style = '.pagination.loop-pagination .page-numbers.current {border-color:'+current_color+';background-color:'+current_color+';}.pagination a:hover{border-color:'+current_color+';background-color:'+current_color+';}';

							jQuery('#directory-style-inline-css').html(old_style+new_style);
						} else if ( path.indexOf('comment-reply-link') >= 0 ) {
							var old_style = jQuery('#directory-style-inline-css').html();
							var current_color = jQuery('.comments-container .comment-reply-link').css('color');
							var new_style = '.comments-container .comment-reply-link:hover {border-color:'+current_color+';background-color:'+current_color+';color:#fff !important;}';

							jQuery('#directory-style-inline-css').html(old_style+new_style);
						} else if ( path.indexOf('like-thumb-liked') >= 0 ) {
							var old_style = jQuery('#directory-style-inline-css').html();
							var current_color = jQuery('.like-thumb-liked').css('color');
							var new_style = '.like-thumb-liked #My-account {fill:'+current_color+';}';

							jQuery('#directory-style-inline-css').html(old_style+new_style);
						} else if ( path.indexOf('dt-blog-item-category') >= 0 ) {
							var old_style = jQuery('#directory-style-inline-css').html();
							var current_color = jQuery('.dt-blog-item-category').css('color');
							var new_style = '.dt-blog-item-category:before {border-color:'+current_color+';}';

							jQuery('#directory-style-inline-css').html(old_style+new_style);
						} else if ( path.indexOf('db-single-listing-category') >= 0 ) {
							var old_style = jQuery('#directory-style-inline-css').html();
							var current_color = jQuery('.db-single-listing-category').css('color');
							var new_style = '.db-single-listing-category:before {border-color:'+current_color+';}';

							jQuery('#directory-style-inline-css').html(old_style+new_style);
						}

						return false;
					}
				});
			},
			ondropdeactivate: function (event) {
				// remove active dropzone feedback
				classie.remove(event.target, 'paint-area--highlight');
			}
		});

		// reset colors
		document.querySelector('button.reset-button').addEventListener('click', resetColors);
	}

	function hexToRgb(hex) {
		// Expand shorthand form (e.g. "03F") to full form (e.g. "0033FF")
		var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
		hex = hex.replace(shorthandRegex, function(m, r, g, b) {
			return r + r + g + g + b + b;
		});

		var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
		return result ? {
			r: parseInt(result[1], 16),
			g: parseInt(result[2], 16),
			b: parseInt(result[3], 16)
		} : null;
	}

	function checkParentElements(element, path) {
		var loop_element = '';
		var valid_path = path;
		loop_element = element.parent();
		while ( true ) {
			if (( typeof loop_element.attr('id') === 'undefined' || loop_element.attr('id') == 'undefined' || loop_element.attr('id') == '' )
				&& ( typeof loop_element.attr('class') === 'undefined' || loop_element.attr('class') == 'undefined' || loop_element.attr('class') == '' ) ) {
				// only tag, set tag at path and move forward
				valid_path = loop_element.prop('tagName').toLowerCase()+' '+valid_path;
				loop_element = loop_element.parent();
				continue;
			} else if ( typeof loop_element.attr('id') == 'undefined' ) {
				// has class
				valid_path = '.'+loop_element.attr('class').split(' ').join('.')+' '+valid_path;
				break;
			} else {
				// has id
				if ( loop_element.attr('id').indexOf("menu-item-") >= 0 && loop_element.parent().attr('class') == 'nav-menu' ) {
					valid_path = "[id^='menu-item-']"+' '+valid_path;
				} else if ( loop_element.attr('id').indexOf("menu-item-") >= 0 && loop_element.parent().attr('class') == 'footer-menu' ) {
					valid_path = ".footer-menu [id^='menu-item-']"+' '+valid_path;
				} else if ( loop_element.attr('id').indexOf("widget-") >= 0 ) {
					valid_path = "[id^='widget-']"+' '+valid_path;
				} else if ( loop_element.attr('id').indexOf("post-") >= 0 ) {
					valid_path = "[id^='post-']"+' '+valid_path;
				} else {
					customizerParentElementID = '#'+jQuery(event.target).parent().attr('id');
					valid_path = '#'+loop_element.attr('id')+' '+valid_path;
				}
				break;
			}
		}

		return valid_path;
	}

	function paintArea(ev, el, color, eclass) {
		var type = 'area';
		if(classie.has(el, 'paint-area--text') || jQuery(el).is(element_text_classes)) {
			type = 'text';
		}

		if ( eclass.indexOf(".next.page-numbers") >= 0 || eclass.indexOf(".prev.page-numbers") >= 0 ) {
			type = 'area';
		}

		if( type === 'area' ) {
			// create SVG element
			var dummy = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
			dummy.setAttributeNS(null, 'version', '1.1');
			dummy.setAttributeNS(null, 'width', '100%');
			dummy.setAttributeNS(null, 'height', '100%');
			dummy.setAttributeNS(null, 'class', 'paint');

			var g = document.createElementNS('http://www.w3.org/2000/svg', 'g');
			g.setAttributeNS(null, 'transform', 'translate(' + Number(ev.pageX - getOffset(el).left) + ', ' + Number(ev.pageY - getOffset(el).top) + ')');

			var circle = document.createElementNS("http://www.w3.org/2000/svg", "circle");
			circle.setAttributeNS(null, 'cx', 0);
			circle.setAttributeNS(null, 'cy', 0);
			circle.setAttributeNS(null, 'r', Math.sqrt(Math.pow(el.offsetWidth,2) + Math.pow(el.offsetHeight,2)));
			circle.setAttributeNS(null, 'fill', color);

			dummy.appendChild(g);
			g.appendChild(circle);
			el.appendChild(dummy);
		}

		setTimeout(function() {
			classie.add(el, 'paint--active');

			if( type === 'text' ) {
				el.style.color = color;
				jQuery(eclass).css('color', color);
				var onEndTransCallbackFn = function(ev) {
					if( ev.target != this ) return;
					this.removeEventListener( transEndEventName, onEndTransCallbackFn );
					classie.remove(el, 'paint--active');
				};

				el.addEventListener(transEndEventName, onEndTransCallbackFn);
			}
			else {
				if ( jQuery(el).attr('type') == 'submit' ) {
					jQuery(el).css('background-color', color);
				};

				var onEndTransCallbackFn = function(ev) {
					if( ev.target != this || ev.propertyName === 'fill-opacity' ) return;
					this.removeEventListener(transEndEventName, onEndTransCallbackFn);
					// set the color
					el.style.backgroundColor = color;
					jQuery(eclass).css('background-color', color);
					// remove SVG element
					el.removeChild(dummy);

					setTimeout(function() { classie.remove(el, 'paint--active'); }, 25);
				};

				circle.addEventListener(transEndEventName, onEndTransCallbackFn);
			}
		}, 25);
	}

	function resetColors() {
		if ( confirm('All your customizations are going to be deleted permanently') ) {
			jQuery.ajax({
				type: 'POST',
				url: my_ajax.ajaxurl,
				data: {"action": "delete_directory_customizer" },
				success: function(response) {
					location.reload();
					return false;
				}
			});
		};
	}

	init();

})();