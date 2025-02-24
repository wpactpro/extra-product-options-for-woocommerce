/**
 * Epofw admin js.
 *
 * @version 1.0.0
 * @package Extra_Product_Options_For_WooCommerce
 */

(function ( $ ) {
	'use strict';
	initFunction();
	$( document ).ajaxComplete(
		function () {
			initFunction();
		}
	);

	function initFunction() {
		if ( $( '.epofw_datepicker' ).length ) {
			$( '.epofw_datepicker' ).datepicker( { dateFormat: 'dd-mm-yy' } );
		}

		if ( $( '.epofw_timepicker' ).length ) {
			$( '.epofw_timepicker' ).timepicker( { timeFormat: 'hh:mm:ss TT' } );
		}

		if ( $( '.epofw_colorpicker' ).length ) {
			$( '.epofw_colorpicker' ).wpColorPicker();
		}
	}

	function forAllFilter() {
		jQuery( 'li .epofw_data_condition' ).each(
			function () {
				var current_condition_val = $( this ).val();
				if ( 'product_qty' !== current_condition_val && 'date_picker' !== current_condition_val ) {
					if ( 'user_role' !== current_condition_val ) {
						selectFilter( '.epofw_condition_data_class_' + current_condition_val, 'epofw_get_data_based_on_cd', current_condition_val );
					} else {
						selectFilter2( '.epofw_condition_data_class_' + current_condition_val, 'epofw_get_data_based_on_cd', current_condition_val );
					}
				}
			}
		);
	}

	function cpoAllowSpecialCharacter( str ) {
		return str.replace( '&#8211;', '–' ).replace( '&gt;', '>' ).replace( '&lt;', '<' ).replace( '&#197;', 'Å' );
	}

	function selectFilter2( filterBasedOnClass, ajaxAction, current_val ) {
		jQuery( filterBasedOnClass ).each(
			function () {
				jQuery( filterBasedOnClass ).select2(
					{
						ajax: {
							url: epofw_var.ajaxurl,
							dataType: 'json',
							delay: 250,
							type: 'post',
							data: function ( params ) {
								return {
									value: params.term,
									current_condition: current_val,
									action: ajaxAction,
									get_data_based_on_cd_nonce: epofw_var.get_data_based_on_cd_nonce,
								};
							},
							processResults: function ( data ) {
								var options = [];
								if ( data ) {
									$.each(
										data,
										function ( index, text ) {
											options.push( { id: text[ 0 ], text: cpoAllowSpecialCharacter( text[ 1 ] ) } );
										}
									);
								}
								return {
									results: options
								};
							},
							cache: true
						},
					}
				);
			}
		);
	}

	function selectFilter( filterBasedOnClass, ajaxAction, current_val ) {
		jQuery( filterBasedOnClass ).each(
			function () {
				jQuery( filterBasedOnClass ).select2(
					{
						ajax: {
							url: epofw_var.ajaxurl,
							dataType: 'json',
							delay: 250,
							type: 'post',
							data: function ( params ) {
								return {
									value: params.term,
									current_condition: current_val,
									action: ajaxAction,
									get_data_based_on_cd_nonce: epofw_var.get_data_based_on_cd_nonce,
								};
							},
							processResults: function ( data ) {
								var options = [];
								if ( data ) {
									$.each(
										data,
										function ( index, text ) {
											options.push( { id: text[ 0 ], text: cpoAllowSpecialCharacter( text[ 1 ] ) } );
										}
									);
								}
								return {
									results: options
								};
							},
							cache: true
						},
						minimumInputLength: 3
					}
				);
			}
		);
	}

	/**
	 * Show hide field based on admin rule.
	 */
	function epofwShowHideField() {
		jQuery( '.accordion_cls' ).each(
			function () {
				var parentId = $( this ).attr( 'id' );
				$( '#' + parentId + ' .epofw_extra_field_inp .text-class' ).each(
					function () {
						var fieldID       = $( this ).attr( 'id' );
						var requiredField = $( '#' + parentId ).find( '.epofw_dependent_field' ).attr( 'data-required-field' );
						if ( requiredField ) {
								var requiredFieldID        = $( '#' + parentId ).find( '.epofw_dependent_field' ).attr( 'id' );
								var requiredFieldParseData = JSON.parse( requiredField );
								var matchRule              = [];
							if ( requiredFieldParseData ) {
								$.each(
									requiredFieldParseData,
									function ( index, value ) {
											var pattern = new RegExp( 'epofw_' + value[ 0 ] + '_[0-9]' );
										if ( pattern.test( fieldID ) ) {
											if ( 'equal_to' === value[ 1 ] ) {
												if ( value[ 2 ] === $( '#' + fieldID ).val() ) {
														matchRule.push( true );
												} else {
														matchRule.push( false );
												}
											}
											if ( 'not_equal_to' === value[ 1 ] ) {
												if ( value[ 2 ] === $( '#' + fieldID ).val() ) {
													matchRule.push( false );
												} else {
													matchRule.push( true );
												}
											}
										}
									}
								);
								if ( matchRule.length ) {
									if ( jQuery.inArray( true, matchRule ) !== -1 ) {
										$( '#' + requiredFieldID ).parent().parent().removeClass( 'epofw_dependent_field_hide' );
									} else {
										$( '#' + requiredFieldID ).parent().parent().addClass( 'epofw_dependent_field_hide' );
									}
								}
							}
						}
					}
				);
			}
		);
	}

	var AWS_ADMIN = {
		init: function () {
			$( '.accordion_ct_div' ).hide();
			forAllFilter();
			epofwShowHideField();
			$( '.tips, .help_tip, .woocommerce-help-tip' ).tipTip(
				{
					'attribute': 'data-tip',
					'fadeIn': 50,
					'fadeOut': 50,
					'delay': 200
				}
			);
			jQuery( document ).on( 'change', '#epofw_type', AWS_ADMIN.changeFieldType );
			jQuery( document ).on( 'click', '#add-new-opt', AWS_ADMIN.cloneOptions );
			jQuery( document ).on( 'click', '#remove-opt', AWS_ADMIN.removeOptions );
			jQuery( document ).on( 'change', '.epofw_data_condition', AWS_ADMIN.getDataBasedOnCondition );
			jQuery( document ).on( 'click', '.add_field_id', AWS_ADMIN.cloneFieldOptions );
			jQuery( document ).on( 'click', '.accordion_cls_title .accordion_a_cls', AWS_ADMIN.accordianACls );
			jQuery( document ).on( 'click', '.accordion_cls_title .accordion_a_cls_remove', AWS_ADMIN.removeAccordian );
			jQuery( document ).on( 'click', 'input[type="checkbox"].epofw-has-sub', AWS_ADMIN.enableSubField );
			jQuery( document ).on( 'click', '.epofw_desc_toogle', AWS_ADMIN.showEpofwDescription );
			jQuery( document ).on( 'change', '.epofw_options_chk_all', AWS_ADMIN.epofwOptionsChkAll );
			jQuery( document ).on( 'click', '.disable_all_options', AWS_ADMIN.disableAllOptions );
			jQuery( document ).on( 'click', '.epofw_options_chk', AWS_ADMIN.epofwSingleOptions );
			jQuery( document ).on( 'click', '.epofw_af_current_field_show_hide', AWS_ADMIN.epofwAfCurrentFieldShowHide );
			jQuery( document ).on( 'change', '.text-class', AWS_ADMIN.changeOnFieldInput );
		},
		changeOnFieldInput: function () {
			epofwShowHideField();
		},
		epofwAfCurrentFieldShowHide: function () {
			var parentId      = $( this ).closest( '.accordion_cls' ).attr( 'id' );
			var fieldParentId = jQuery( this ).parent().parent().attr( 'id' );
			if ( this.checked ) {
				$( '#' + parentId + ' .show_on_' + fieldParentId ).parent().parent().hide();
			} else {
				$( '#' + parentId + ' .show_on_' + fieldParentId ).parent().parent().show();
			}
		},
		epofwSingleOptions: function () {
			if ( jQuery( '.epofw_options_chk_all' ).is( ':checked' ) ) {
				return;
			}
			if ( jQuery( '.epofw_options_chk' ).is( ':checked' ) ) {
				$( '.disable_all_options' ).removeClass( 'hide' ).addClass( 'show' );
			} else {
				$( '.disable_all_options' ).removeClass( 'show' ).addClass( 'hide' );
			}
		},
		disableAllOptions: function () {
			var fieldIds = [];
			jQuery( '.accordion_cls' ).each(
				function () {
					if ( jQuery( this ).find( '.epofw_chk_data .epofw_options_chk' ).is( ':checked' ) ) {
						fieldIds.push( jQuery( this ).attr( 'data-id' ) );
					}
				}
			);
			jQuery.ajax(
				{
					type: 'post',
					url: epofw_var.ajaxurl,
					data: {
						action: 'epofw_disbale_field_options',
						get_post_id: epofw_var.get_post_id,
						field_ids: fieldIds,
						disable_option_nonce: epofw_var.disable_option_nonce,
					},
					success: function ( response ) {
						if ( response ) {
							if ( true === response.success ) {
								window.location.reload();
							} else {
								var pTag = document.createElement( 'p' );
								pTag.setAttribute( 'class', 'error epofw_disable_option_error' );
								var errorMessage = document.createTextNode( response.data.msg );
								pTag.appendChild( errorMessage );

								var elementTag = document.getElementsByClassName( 'addon_fields_header' )[0];
								elementTag.append( pTag );
							}
						}
					},
					error: function ( errormessage ) {
						console.log( errormessage );
					}
				}
			);
		},
		epofwOptionsChkAll: function () {
			if ( jQuery( this ).is( ':checked' ) ) {
				jQuery( '.accordion_cls' ).each(
					function () {
						$( '.epofw_chk_data .epofw_options_chk' ).prop( 'checked', true );
					}
				);
				$( '.disable_all_options' ).removeClass( 'hide' ).addClass( 'show' );
			} else {
				jQuery( '.accordion_cls' ).each(
					function () {
						$( '.epofw_chk_data .epofw_options_chk' ).removeAttr( 'checked' );
					}
				);
				$( '.disable_all_options' ).removeClass( 'show' ).addClass( 'hide' );
			}
		},
		showEpofwDescription: function () {
			$( this ).next( 'p.epofw_description' ).toggle();
		},
		enableSubField: function () {
			var parentId = $( this ).parent().parent().parent().parent().attr( 'id' );
			var nextEle  = $( this ).attr( 'data-nextfe' );
			if ( jQuery( this ).is( ':checked' ) ) {
				jQuery( '#' + parentId + ' #' + nextEle ).show();
			} else {
				jQuery( '#' + parentId + ' #' + nextEle ).hide();
			}
		},
		removeAccordian: function () {
			if ( confirm( 'Are you sure want to delete this field' ) ) {
				$( this ).parent().parent().remove();
			}
			return false;
		},
		accordianACls: function () {
			$( this ).parent().toggleClass( 'active' );
			$( this ).toggleClass( 'active' );
			if ( $( this ).hasClass( 'active' ) ) {
				$( this ).find( 'span.dashicons' ).removeClass( 'dashicons-arrow-right-alt2' ).addClass( 'dashicons-arrow-down-alt2' );
			} else {
				$( this ).find( 'span.dashicons' ).removeClass( 'dashicons-arrow-down-alt2' ).addClass( 'dashicons-arrow-right-alt2' );
			}
			$( this ).parent().next().slideToggle( 'fast' );
		},
		cloneFieldOptions: function () {
			var num = Math.floor( Math.random() * 1000000000 );

			// Get all elements with the class 'accordion_cls'.
			var accordions = document.getElementsByClassName( 'accordion_cls' );
			var totalAccordion = accordions.length;
			// Get the last accordion.
			var lastAccordion = accordions[totalAccordion - 1];
			// Clone the last accordion.
			var clone = lastAccordion.cloneNode( true );
			// Insert the cloned element after the original element.
			lastAccordion.parentNode.appendChild( clone );

			clone.setAttribute( 'id', 'accordion_' + num );
			clone.setAttribute( 'data-id', parseInt( lastAccordion.getAttribute( 'data-id' ) ) + 1 );
			clone.querySelector( '.addon_fields' ).setAttribute( 'id', 'addon_fields_' + num );
			clone.querySelector( '.addon_field' ).setAttribute( 'id', 'addon_field_' + num );
			clone.querySelector( '.addon_field' ).setAttribute( 'data-id', num );
			clone.querySelector( '.heading_nu_title span' ).textContent = totalAccordion + 1;
			var inputsName = clone.querySelectorAll( '.addon_field .text-class' );
			inputsName.forEach( function ( input ) {
				var inpElem = input;
				var inpElemName = inpElem.getAttribute( 'name' );
				var newName = inpElemName.replace( /\d+/, num );
				inpElem.setAttribute( 'name', newName );
			} );
			var inputsDefaultVal = clone.querySelectorAll( '.addon_field .default_num_class' );
			inputsDefaultVal.forEach( function ( input ) {
				var inpElem = input;
				var inpElemVal = inpElem.value;
				var newName = inpElemVal.replace( /\d+/, Math.floor( Math.random() * 1000000000 ) );
				inpElem.value = newName;
			} );
		},
		getDataBasedOnCondition: function () {
			var main_parent_attr_id   = $( this ).parent().parent().attr( 'id' );
			var main_parent_attr_key  = $( this ).parent().parent().attr( 'data-attr-key' );
			var current_condition_val = $( this ).val();
			var append_value_element;
			var $td_apsub_elem;

			if ( 0 === $( '#' + main_parent_attr_id + ' #epofw_condition_data_' + main_parent_attr_key ).length ) {
				if ( $( '#' + main_parent_attr_id + ' #epofw_condition_input_data_' + main_parent_attr_key ).length ) {
					$( '#' + main_parent_attr_id ).find( 'li.epofw_condition_field_data' ).html( '' );
				}
				if ( $( '#' + main_parent_attr_id + ' #epofw_condition_data_id_' + main_parent_attr_key ).length ) {
					$( '#' + main_parent_attr_id ).find( 'li.epofw_condition_field_data' ).html( '' );
				}
				append_value_element = document.getElementById( main_parent_attr_id ).getElementsByClassName( 'epofw_condition_field_data' )[ 0 ];
				$td_apsub_elem       = document.createElement( 'select' );
				$td_apsub_elem.setAttribute( 'class', 'epofw_condition_data_class_' + current_condition_val + ' epofw_condition_data_class multiselect2' );
				$td_apsub_elem.setAttribute( 'id', 'epofw_condition_data_id_' + main_parent_attr_key );
				$td_apsub_elem.setAttribute( 'name', 'epofw_data[additional_rule_data][' + main_parent_attr_key + '][value][]' );
				$td_apsub_elem.setAttribute( 'multiple', 'multiple' );

				var createDiv = document.createElement( 'div' );
				createDiv.setAttribute( 'class', 'epofw_all_selection_btn' );
				var createButton = document.createElement( 'button' );
				createButton.setAttribute( 'type', 'button' );
				createButton.setAttribute( 'class', 'button select_all_ad' );
				createButton.setAttribute( 'data-cnd', current_condition_val );
				var createButtonText = document.createTextNode( 'Select All' );
				createButton.appendChild( createButtonText );
				createDiv.appendChild( createButton );

				var createButton1 = document.createElement( 'button' );
				createButton1.setAttribute( 'type', 'button' );
				createButton1.setAttribute( 'class', 'button clear_all_ad' );
				createButton1.setAttribute( 'data-cnd', current_condition_val );
				var createButtonText1 = document.createTextNode( 'Clear All' );
				createButton1.appendChild( createButtonText1 );
				createDiv.appendChild( createButton1 );

				append_value_element.appendChild( $td_apsub_elem );
				append_value_element.appendChild( createDiv );

			}
			forAllFilter();
		},
		changeFieldType: function () {
			var current_val    = $( this ).val();
			var parent_id      = $( this ).parents().parents().parents().parents().attr( 'data-id' );
			var get_post_id    = $( this ).parents().parents().parents().parents().attr( 'data-post-id' );
			var main_parent_id = 'accordion_' + parent_id;
			jQuery.ajax(
				{
					type: 'post',
					url: epofw_var.ajaxurl,
					data: {
						action: 'epofw_change_field_basedon_type',
						current_val: current_val,
						parent_id: parent_id,
						get_post_id: get_post_id,
						change_field_nonce: epofw_var.change_field_nonce,
					},
					success: function ( html ) {
						$( '#' + main_parent_id + ' .fields_h2' ).remove( '' );
						$( '#' + main_parent_id + ' .general_field' ).remove();
						var parentElement = document.getElementById( main_parent_id );
						var copFtIdElement = parentElement.querySelector( '#cop_ft_id' );
						copFtIdElement.insertAdjacentHTML( 'afterend', html );
						if ( $( '.opt-li' ).length ) {
							var opt_li = parseInt( $( '.opt-li' ).length );
							if ( opt_li > 1 ) {
								$( '.opt-li:not(:first) .remove-opt-btn' ).show();
							} else {
								$( '.opt-li:first .remove-opt-btn' ).hide();
							}
						}
						$( '.accordion_cls input[type="checkbox"].epofw-has-sub' ).each(
							function () {
								var nextEle = $( this ).attr( 'data-nextfe' );
								jQuery( '#' + main_parent_id + ' #' + nextEle ).hide();
							}
						);
					},
					error: function ( errormessage ) {
						console.log( errormessage );
					}
				}
			);
		},
		cloneOptions: function () {
			var li_elem = this.parentElement.parentElement.querySelector( 'div.opt-li:last-child' );
			var num = parseInt( li_elem.id.match( /\d+/g ), 10 ) + 1;
			var clon_id = li_elem.cloneNode( true );
			clon_id.id = 'opt-li-' + num;
			if ( clon_id.querySelector( '.epofw-cs-colorswitcher' ) ) {
				var dataIdUn = clon_id.querySelector( '.epofw-cs-colorswitcher' ).id;
				$( '#' + dataIdUn ).wpColorPicker();
			}
			var inputs = clon_id.querySelectorAll( 'input' );
			inputs.forEach( function ( elem ) {
				var inpElem = elem;
				inpElem.id = 'select-opt-value-' + num;
				if ( inpElem.classList.contains( 'epofw-cs-colorswitcher' ) ) {
					inpElem.id = 'select-opt-epofw-cs-colorswitcher-' + num;
				}
			} );
			$( '.remove-opt-btn' ).show();
			li_elem.insertAdjacentElement( 'afterend', clon_id );
			$( '.opt-li:first .remove-opt-btn' ).hide();
			$( '.opt-li:not(:first) .remove-opt-btn' ).show();
		},
		removeOptions: function () {
			if ( 'sop' === $( this ).attr( 'attr' ) ) {
				$( this ).parent().parent().remove();
			} else {
				$( this ).parent().parent().remove();
			}
		}
	};
	$(
		function () {
			if ( $( '.epofw_hidden_value' ).length ) {
				$( '.epofw_hidden_value' ).parent().parent().hide();
			}
			if ( $( '.epofw_condition_data_class_date_picker' ).length ) {
				$( '.epofw_condition_data_class_date_picker' ).datepicker( { dateFormat: 'dd-mm-yy' } );
			}
			// $( '.addon_fields_accordian_data' ).sortable();
			$( '.addon_fields_accordian_data' ).sortable(
				{
					handle: '.sortable-icon',
					axis: 'y'
				}
			);
			$( '.nested_accordion_data' ).sortable(
				{
					handle: '.sortable-icon',
					axis: 'y'
				}
			);
			if ( $( '.epofw_colorpicker' ).length ) {
				$( '.epofw_colorpicker' ).wpColorPicker();
			}
			/*Start - Hide show checkbox*/
			$( '.accordion_cls input[type="checkbox"].epofw-has-sub' ).each(
				function () {
					var parentId = $( this ).parent().parent().parent().parent().attr( 'id' );
					var nextEle  = $( this ).attr( 'data-nextfe' );
					if ( jQuery( this ).is( ':checked' ) ) {
						jQuery( '#' + parentId + ' #' + nextEle ).show();
					} else {
						jQuery( '#' + parentId + ' #' + nextEle ).hide();
					}
				}
			);
			/*Stop - Hide show checkbox*/
			/*Start - Hide show checkbox below field*/
			$( '.accordion_cls .epofw_af_current_field_show_hide' ).each(
				function () {
					var parentId      = $( this ).closest( '.accordion_cls' ).attr( 'id' );
					var fieldParentId = jQuery( this ).parent().parent().attr( 'id' );
					if ( this.checked ) {
						$( '#' + parentId + ' .show_on_' + fieldParentId ).parent().parent().hide();
					} else {
						$( '#' + parentId + ' .show_on_' + fieldParentId ).parent().parent().show();
					}
				}
			);
			/*Stop - Hide show checkbox*/
			if ( $( '#epofw_custom_css' ).length > 0 ) {
				var content_mode = $( '#epofw_custom_css' ).attr( 'data-mode' );
				var options      = {
					lineNumbers: true,
					mode: content_mode,
					matchBrackets: true,
					autoCloseBrackets: true,
				};
				CodeMirror.fromTextArea( document.getElementById( 'epofw_custom_css' ), options );
			}
			AWS_ADMIN.init();
		}
	);
})( jQuery );
