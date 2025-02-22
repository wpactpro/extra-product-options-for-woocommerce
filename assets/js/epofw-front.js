/**
 * Epofw front js.
 *
 * @version 1.0.0
 * @package Extra_Product_Options_For_WooCommerce
 */

( function ( $ ) {
	'use strict';
	var currencySymbol    = epofw_front_var.currency;
	var decimalSeparator  = epofw_front_var.decimal_separator;
	var thousandSeparator = epofw_front_var.thousand_separator;
	var decimals          = epofw_front_var.decimals;
	var position          = epofw_front_var.position;

	var AWS_Front = {
		init: function () {
			/* Start New */
			$( 'form.cart' ).submit(
				function () {
					var epofwPass = AWSF.checkValidationForEachFields();
					if ( jQuery.inArray( false, epofwPass ) !== -1 ) {
							return false;
					}
				}
			);
			/* End New */
			$( document ).click(
				function ( e ) {
					if ( ! $( e.target ).is( '.epofw_dft_colorpicker' ) ) {
							$( '.epofw_dft_colorpicker' ).iris( 'hide' );
					}
				}
			);
			$( '.epofw_dft_colorpicker' ).click(
				function () {
					$( '.epofw_dft_colorpicker' ).iris( 'hide' );
					$( this ).iris( 'show' );
					return false;
				}
			);
			if ( $( '.epofw_dft_multiselect' ).length ) {
				$( '.epofw_dft_multiselect' ).select2();
			}
			if ( $( '.epofw_dft_datepicker' ).length ) {
				$( '.epofw_dft_datepicker' ).each(
					function () {
						var fieldID = $( this ).attr( 'id' );
						var element = $( this ).closest( '.epofw_tr_se' ).attr( 'id' );
						var docElemnt = document.getElementById( element );
						var tdElement = docElemnt.querySelector( 'td.value' );
						var errorColor = '#ff0000';

						var $this                          = $( this );
						var getUniqueDivId     = $this.closest( '.epofw_addon_html' ).data( 'uqd-attr' );
						var fieldPrice                     = AWSF.epofwFieldsMatchParameter( $this, 'addon_price', '' );
						var fieldType                      = AWSF.epofwFieldsMatchParameter( $this, 'data_inp_type', '' );
						var inputfieldName                 = $( this ).attr( 'name' );
						var inputfieldNameReplaceWithValue = inputfieldName.replace( '[value]', '' );
						var inputfieldNameReplaced         = inputfieldNameReplaceWithValue.replace( '[]', '' );
						var labelName                      = $( this ).attr( 'data-label-name' );
						$( '#' + fieldID ).datepicker(
							{
								dateFormat: 'dd-mm-yy',
								onSelect: function ( dateText ) {
									if ( $( '#' + element + ' td .epofw_error' ).length > 0 ) {
										$( '#' + element + ' td .epofw_error' ).remove();
									}
									if ( ! AWSF.isValidDate( dateText ) ) {
										// Clear the input or display an error message.
										$( this ).val( '' );
										var errorElement = document.createElement( 'p' );
										errorElement.className = 'epofw_error';
										errorElement.style.color = errorColor;
										var errorMessage = document.createTextNode( epofw_front_var.datepicker_select_validation );
										errorElement.appendChild( errorMessage );
										tdElement.append( errorElement );
									} else {
										var trFieldName = labelName + ' - ' + dateText;
										var checkTr     = $( 'tr#tr_' + inputfieldNameReplaced ).length;
										if ( checkTr === 0 ) {
											var firstTr = AWSF.createTr( dateText, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
											$( '#addon_total #addon_subtotal' ).before( firstTr );
										} else {
											AWSF.addTrInAddonDetails( dateText, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
										}
										AWSF.calculateAddonPrice();
									}
								}
							}
						).on( 'change', function () {
							if ( $( '#' + element + ' td .epofw_error' ).length > 0 ) {
								$( '#' + element + ' td .epofw_error' ).remove();
							}
							var dateText = $( this ).val();
							if ( dateText !== '' && ! AWSF.isValidDate( dateText ) ) {
								var errorElement = document.createElement( 'p' );
								errorElement.className = 'epofw_error';
								errorElement.style.color = errorColor;
								var errorMessage = document.createTextNode( epofw_front_var.datepicker_change_validation );
								errorElement.appendChild( errorMessage );
								tdElement.append( errorElement );
								$( this ).val( '' ); // Clear the input field if an invalid date is entered.
							} else {
								var trFieldName = labelName + ' - ' + dateText;
								var checkTr     = $( 'tr#tr_' + inputfieldNameReplaced ).length;
								if ( checkTr === 0 ) {
									var firstTr = AWSF.createTr( dateText, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
									$( '#addon_total #addon_subtotal' ).before( firstTr );
								} else {
									AWSF.addTrInAddonDetails( dateText, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
								}
								AWSF.calculateAddonPrice();
							}
						} );
					}
				);
			}
			if ( $( '.epofw_dft_timepicker' ).length ) {
				$( '.epofw_dft_timepicker' ).each(
					function () {
						var fieldID = $( this ).attr( 'id' );
						var element = $( this ).closest( '.epofw_tr_se' ).attr( 'id' );
						var docElemnt = document.getElementById( element );
						var tdElement = docElemnt.querySelector( 'td.value' );
						var errorColor = '#ff0000';
						$( '#' + fieldID ).timepicker(
							{
								timeFormat: 'hh:mm:ss TT',
								onSelect: function ( timeText ) {
									if ( $( '#' + element + ' td .epofw_error' ).length > 0 ) {
										$( '#' + element + ' td .epofw_error' ).remove();
									}
									if ( ! AWSF.isValidTime( timeText ) ) {
										// Clear the input or display an error message.
										$( this ).val( '' );
										var errorElement = document.createElement( 'p' );
										errorElement.className = 'epofw_error';
										errorElement.style.color = errorColor;
										var errorMessage = document.createTextNode( epofw_front_var.timepicker_select_validation );
										errorElement.appendChild( errorMessage );
										tdElement.append( errorElement );
									}
								}
							}
						).on( 'change', function () {
							if ( $( '#' + element + ' td .epofw_error' ).length > 0 ) {
								$( '#' + element + ' td .epofw_error' ).remove();
							}
							var timeText = $( this ).val();
							if ( timeText !== '' && ! AWSF.isValidTime( timeText ) ) {
								var errorElement = document.createElement( 'p' );
								errorElement.className = 'epofw_error';
								errorElement.style.color = errorColor;
								var errorMessage = document.createTextNode( epofw_front_var.timepicker_change_validation );
								errorElement.appendChild( errorMessage );
								tdElement.append( errorElement );
								$( this ).val( '' ); // Clear the input field if an invalid date is entered.
							}
						} );
					}
				);
			}
			if ( $( '.epofw_dft_colorpicker' ).length ) {
				$( '.epofw_dft_colorpicker' ).each(
					function () {
						var $this = $( this );
						var getUniqueDivId = $this.closest( '.epofw_addon_html' ).data( 'uqd-attr' );
						var fieldPrice = AWSF.epofwFieldsMatchParameter( $this, 'addon_price', '' );
						var fieldType = AWSF.epofwFieldsMatchParameter( $this, 'data_inp_type', '' );
						var fieldID = $( this ).attr( 'id' );
						var inputfieldName = $( this ).attr( 'name' );
						var inputfieldNameReplaceWithValue = inputfieldName.replace( '[value]', '' );
						var inputfieldNameReplaced = inputfieldNameReplaceWithValue.replace( '[]', '' );
						var labelName = $( this ).attr( 'data-label-name' );

						var element = $( this ).closest( '.epofw_tr_se' ).attr( 'id' );
						var docElemnt = document.getElementById( element );
						var tdElement = docElemnt.querySelector( 'td.value' );
						var errorColor = '#ff0000';
						$( '#' + fieldID ).iris(
							{
								defaultColor: true,
								change: function ( event, ui ) {
									var color = ui.color.toString();
									if ( $( '#' + element + ' td .epofw_error' ).length > 0 ) {
										$( '#' + element + ' td .epofw_error' ).remove();
									}
									if ( color !== '' && ! AWSF.isValidColor( color ) ) {
										var errorElement = document.createElement( 'p' );
										errorElement.className = 'epofw_error';
										errorElement.style.color = errorColor;
										var errorMessage = document.createTextNode( epofw_front_var.colorpicker_select_validation );
										errorElement.appendChild( errorMessage );
										tdElement.append( errorElement );
										$( this ).iris( 'color', '' ); // Clear the color if an invalid color is selected.
									}

									var trFieldName = labelName + ' - ' + color;
									var checkTr = $( 'tr#tr_' + inputfieldNameReplaced ).length;
									if ( checkTr === 0 ) {
										var firstTr = AWSF.createTr( color, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
										var addonSubtotal = document.querySelector( '#addon_total #addon_subtotal' );
										addonSubtotal.insertAdjacentHTML( 'beforebegin', firstTr.outerHTML );
									} else {
										AWSF.addTrInAddonDetails( color, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
									}
									AWSF.calculateAddonPrice();
								},
								clear: function ( event ) {
									var element = jQuery( event.target ).siblings( '.wp-color-picker' )[0];
									if ( element ) {
										$( 'tr#tr_' + inputfieldNameReplaced ).remove();
										AWSF.calculateAddonPrice();
									}
								},
								// hide the color picker controls on load.
								hide: true,
								// show a group of common colors beneath the square.
								palettes: true
							}
						).on( 'change', function () {
							var color = $( this ).val();
							if ( $( '#' + element + ' td .epofw_error' ).length > 0 ) {
								$( '#' + element + ' td .epofw_error' ).remove();
							}
							if ( color !== '' && ! AWSF.isValidColor( color ) ) {
								var errorElement = document.createElement( 'p' );
								errorElement.className = 'epofw_error';
								errorElement.style.color = errorColor;
								var errorMessage = document.createTextNode( epofw_front_var.colorpicker_change_validation );
								errorElement.appendChild( errorMessage );
								tdElement.append( errorElement );
								$( this ).val( '' ); // Clear the color if an invalid color is selected.
							}
						} );
					}
				);
			}
			var productId  = AWSF.epofwGetProductId();
			var currentQty = $( '.cart .quantity input[name="quantity"]' ).val();
			AWSF.epofwCheckTable( productId, '', currentQty );
			$( document ).on( 'input', '.epofw_fields_table:visible input[type="text"], .epofw_fields_table:visible input[type="password"], .epofw_fields_table:visible textarea', AWS_Front.onKeyUpChangeAddon );
			$( document ).on( 'change', '.epofw_fields_table:visible input, .epofw_fields_table:visible textarea', AWS_Front.onKeyUpChangeAddon );
			$( document ).on( 'change', '.epofw_fields_table:visible select', AWS_Front.onKeyUpChangeSelectAddon );
			$( document ).on( 'change', '.variations_form .variations select', AWS_Front.getSelectedVariation );
			$( document ).on( 'change', '.cart.variations_form .quantity .qty', AWS_Front.getProductQty );
			$( document ).on( 'change', '.cart input[name="quantity"]', AWS_Front.updateProductPriceInAddonDetailsOnQtyChange );
		},
		isValidTime: function ( timeString ) {
			var timeRegex = /^(0?[1-9]|1[0-2]):[0-5][0-9]:[0-5][0-9] (AM|PM)$/i;
			return timeRegex.test( timeString );
		},
		isValidDate: function ( dateString ) {
			// Parse the date string and check if it's a valid date
			var dateFormat = 'dd-mm-yy'; // Date format should match the one used in the datepicker
			var dateParts = dateString.split( '-' );
			var day = parseInt( dateParts[0], 10 );
			var month = parseInt( dateParts[1], 10 ) - 1; // Month is zero-based
			var year = parseInt( dateParts[2], 10 );

			var date = new Date( year, month, day );

			return (
				date.getDate() === day &&
				date.getMonth() === month &&
				date.getFullYear() === year &&
				dateString === $.datepicker.formatDate( dateFormat, date )
			);
		},
		isValidColor: function ( colorString ) {
			var colorRegex = /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/;
			return colorRegex.test( colorString );
		},
		updateProductPriceInAddonDetailsOnQtyChange: function () {
			var productId   = $( 'input[name="product_id"]' ).val();
			var variationId = $( 'input[name="variation_id"]' ).val();
			if ( 'undefined' === typeof productId ) {
				productId = $( '.single_add_to_cart_button' ).val() || $( 'button[name="add-to-cart"]' ).val();
			}
			if ( 'undefined' === typeof productId ) {
				variationId = '';
			}
			var currentQty = $( '.variations_form .quantity input[name="quantity"]' ).val();
			AWSF.epofwCheckTable( productId, variationId, currentQty );
		},
		updateProductPriceInAddonDetails: function () {
			var qty        = $( '.quantity input[name="quantity"]' ).val();
			var addonPrice = $( '#addon_total #addon_prd_details .addon_price' ).attr( 'data-epofw-prd-price' );
			if ( $( 'form.cart' ).hasClass( 'bundle_form' ) && 1 < qty ) {
				addonPrice = $( '.bundle_price .price span.woocommerce-Price-amount.amount:last' ).text();
				addonPrice = addonPrice.replace( currencySymbol, '' );
			}
			var updatedAddonPrice = addonPrice;
			if ( 0 < qty ) {
				updatedAddonPrice = addonPrice * qty;
			}
			$( '#addon_total #addon_prd_details .addon_price' ).attr( 'data-addon-price', updatedAddonPrice );
			if ( undefined !== updatedAddonPrice ) {
				updatedAddonPrice = AWSF.number_format( updatedAddonPrice, decimals, decimalSeparator, thousandSeparator );
			}
			var newAddonPrice = AWSF.setCurrencyPosition( updatedAddonPrice );
			var addonPriceSpan = document.querySelector('#addon_prd_details .addon_price strong span');
			addonPriceSpan.textContent = newAddonPrice;
		},
		checkValidationForEachFields: function () {
			var epofwPass = [];
			$( '.epofw_fields_table:visible .epofw_td_value' ).each(
				function () {
					var required = AWSF.epofwFieldsMatchParameter( $( this ), 'required', 'logical_operation' );
					var inpType  = AWSF.epofwFieldsMatchParameter( $( this ), 'data_inp_type', 'logical_operation' );
					var fieldType;
					if ( 'radiogroup' === inpType ) {
							fieldType = 'radio';
					}
					if ( 'checkbox' === inpType ||
					'checkboxgroup' === inpType ) {
						fieldType = 'checkbox';
					}
					if ( 'text' === inpType ||
					'datepicker' === inpType ||
					'colorpicker' === inpType ||
					'timepicker' === inpType ) {
							fieldType = 'text';
					}
					if ( 'textarea' === inpType ||
					'number' === inpType ||
					'password' === inpType ||
					'select' === inpType ||
					'multiselect' === inpType ) {
							fieldType = inpType;
					}
					if ( required ) {
						if ( 'rd_status' in required ) {
							if ( 'on' === required.rd_status ) {
								var rd_text_color, rd_text;
								rd_text_color = '#ff0000';
								rd_text       = 'This is required field';

								epofwPass = AWSF.validateField( fieldType, rd_text_color, rd_text, this, epofwPass );
							}
						}
					}

				}
			);
			return epofwPass;
		},
		validateField: function ( fieldType, rd_text_color, rd_text, element, epofwPass ) {
			var isValid = true;

			switch ( fieldType ) {
				case 'radio':
				case 'checkbox':
					isValid = $( element ).find( 'input[type="' + fieldType + '"]' ).filter( ':checked' ).length > 0;
					break;
				case 'text':
				case 'textarea':
				case 'number':
				case 'password':
					isValid = $( element ).find( 'input[type="' + fieldType + '"]' ).val() !== '';
					break;
				case 'select':
					isValid = $( element ).find( 'select' ).val() !== '';
					break;
				case 'multiselect':
					isValid = $( element ).find( 'select > option:selected' ).length > 0;
					break;
				default:
					break;
			}

			if ( ! isValid ) {
				if ( $( element ).find( '.epofw_error' ).length < 1 ) {
					var errorElement = document.createElement( 'p' );
					errorElement.className = 'epofw_error';
					errorElement.style.color = rd_text_color;
					var errorMessage = document.createTextNode( rd_text );
					errorElement.appendChild( errorMessage );
					element.appendChild( errorElement );
				}
				epofwPass.push( false );
			} else {
				var errorToRemove = $( element ).find( '.epofw_error' );
				if ( errorToRemove.length > 0 ) {
					errorToRemove.remove();
				}
			}

			return epofwPass;
		},
		getProductQty: function () {
			var productId  = AWSF.epofwGetProductId();
			var currentVal = $( this ).val();
			if ( $( 'form.cart' ).hasClass( 'variations_form' ) ) {
				var variationData       = $( '.variations_form' ).data( 'product_variations' );
				var currentAttributes   = AWSF.getChosenAttributes();
				var matching_variations = AWSF.findMatchingVariations( variationData, currentAttributes.data );
				if ( matching_variations ) {
					if ( currentAttributes.count == currentAttributes.chosenCount ) {
						if ( matching_variations.hasOwnProperty( 0 ) ) {
							if ( $( '.epofw_fields_table' ).length && $( '.epofw_fields_table' ).is( ':visible' ) ) {
								var variationId                     = matching_variations[0].variation_id;
								var variationPrice                  = matching_variations[0].display_price;
								var variationPriceWithFormat        = variationPrice.toFixed( decimals );
								var variationPriceWithFormatReplace = variationPriceWithFormat.replace( '.', decimalSeparator );
								$( '#addon_prd_details .addon_price' ).attr( 'data-addon-price', variationPrice );
								$( '#addon_prd_details .addon_price' ).attr( 'data-epofw-prd-price', variationPrice );
								var variablePrice = AWSF.setCurrencyPosition( variationPriceWithFormatReplace );
								var variablePriceSpan = document.querySelector( '#addon_prd_details .addon_price strong span' );
								variablePriceSpan.textContent = variablePrice;
								AWSF.calculateAddonPrice();
								AWSF.epofwCheckTable( productId, variationId, currentVal );
							}
						}
					} else {
						AWSF.epofwCheckTable( productId, '', currentVal );
					}
				}
			} else {
				AWSF.epofwCheckTable( productId, '', currentVal );
			}
		},
		getSelectedVariation: function () {
			var currentQty          = $( '.variations_form .quantity input[name="quantity"]' ).val();
			var productId           = $( 'input[name="product_id"]' ).val();
			var variationData       = $( '.variations_form' ).data( 'product_variations' );
			var currentAttributes   = AWSF.getChosenAttributes();
			var matching_variations = AWSF.findMatchingVariations( variationData, currentAttributes.data );
			if ( matching_variations ) {
				if ( currentAttributes.count == currentAttributes.chosenCount ) {
					if ( matching_variations.hasOwnProperty( 0 ) ) {
						if ( $( '.epofw_fields_table' ).length ) {
							var variationId    = matching_variations[0].variation_id;
							var variationPrice = matching_variations[0].display_price;
							$( '#addon_prd_details .addon_price' ).attr( 'data-epofw-prd-price', variationPrice );
							var variationPriceWithFormat        = variationPrice.toFixed( decimals );
							var variationPriceWithFormatReplace = variationPriceWithFormat.replace( '.', decimalSeparator );
							$( '#addon_prd_details .addon_price' ).attr( 'data-addon-price', variationPrice );
							var variablePrice = AWSF.setCurrencyPosition( variationPriceWithFormatReplace );
							var variablePriceSpan = document.querySelector( '#addon_prd_details .addon_price strong span' );
							variablePriceSpan.textContent = variablePrice;
							AWSF.calculateAddonPrice();
							AWSF.epofwCheckTable( productId, variationId, currentQty );
						}
					}
				} else {
					AWSF.epofwCheckTable( productId, '', currentQty );
				}
			}
		},
		onKeyUpChangeAddon: function () {
			var getUniqueDivId = $( this ).closest( '.epofw_addon_html' ).data( 'uqd-attr' );
			var qty            = $( '.quantity input[name="quantity"]' ).val();
			AWSF.epofwDisplayFiledsDataAndDisplay( $( this ), qty, getUniqueDivId );
		},
		onKeyUpChangeSelectAddon: function () {
			var getUniqueDivId = $( this ).closest( '.epofw_addon_html' ).data( 'uqd-attr' );
			var qty            = $( '.quantity input[name="quantity"]' ).val();
			AWSF.epofwDisplayAnotherFiledsDataAndDisplay( $( this ), qty, getUniqueDivId );
		},
		addonPriceChangeToDecimalForCalc: function ( fieldPrice ) {
			var addonPrice = fieldPrice;
			fieldPrice     = fieldPrice.toString();
			if ( fieldPrice.indexOf( decimalSeparator ) != -1 ) {
				addonPrice = fieldPrice.replace( decimalSeparator, '.' );
			}
			return addonPrice;
		},
		changeAddonDetailsIfTrExists: function ( fieldID, trFieldName, fieldPriceForAddonAttr, fieldPrice, getUniqueDivId ) {
			var trElement = document.getElementById( 'tr_' + fieldID );
			if ( trElement ) {
				var tdElement = trElement.querySelector( 'td:first-child' );
				if ( tdElement ) {
					var dvElement = tdElement.querySelector( 'div#dv_' + fieldID );
					if ( dvElement ) {
						dvElement.textContent = trFieldName;
					}
				}
			}
			// Addon field Qty.
			var currentQuantity = $( '#' + fieldID + '_afq' ).val();
			if ( currentQuantity ) {
				fieldPrice = fieldPrice * currentQuantity;
			}
			if ( undefined !== fieldPrice ) {
				fieldPrice = AWSF.number_format( fieldPrice, decimals, decimalSeparator, thousandSeparator );
			}
			$( 'tr#tr_' + fieldID ).attr( 'data-udi', getUniqueDivId );
			var trElement1 = document.getElementById( 'tr_' + fieldID );
			if ( trElement1 ) {
				var tdElements = trElement1.getElementsByTagName( 'td' );
				var lastTdElement = tdElements[tdElements.length - 1];
				if ( lastTdElement ) {
					lastTdElement.textContent = AWSF.setCurrencyPosition( fieldPrice );
				}
			}
			var addonPrice = AWSF.addonPriceChangeToDecimalForCalc( fieldPrice );
			$( 'tr#tr_' + fieldID ).find( 'td:last' ).attr( 'data-addon-price', addonPrice );
			$( 'tr#tr_' + fieldID ).find( 'td:last' ).attr( 'data-addon-og-price', fieldPriceForAddonAttr );
		},
		createTr: function ( fieldValue, fieldID, trFieldName, fieldPrice, fieldImage, fieldType, getUniqueDivId ) {
			var firstTr = document.createElement( 'tr' );
			firstTr.setAttribute( 'id', 'tr_' + fieldID );
			firstTr.setAttribute( 'class', 'addon_item' );
			firstTr.setAttribute( 'data-udi', getUniqueDivId );
			var firstTd      = document.createElement( 'td' );
			var firstTrTdDiv = document.createElement( 'div' );
			firstTrTdDiv.setAttribute( 'id', 'dv_' + fieldID );
			var firstTrTdSpan = document.createElement( 'span' );
			firstTrTdSpan.setAttribute( 'class', 'span_field_lable' );
			// For colorpicker.
			if ( 'colorpicker' === fieldType ) {
				var trFieldNameReplace = trFieldName.replace( fieldValue, '' );
				trFieldName            = trFieldNameReplace;
			}
			var firstTrTdSpanText = document.createTextNode( trFieldName );
			firstTrTdSpan.appendChild( firstTrTdSpanText );
			// For colorpicker.
			if ( 'colorpicker' === fieldType ) {
				var firstTrTdSpan2 = document.createElement( 'span' );
				firstTrTdSpan2.setAttribute( 'style', 'color: ' + fieldValue + '; font-size:20px; padding: 0;line-height: 0' );
				var firstTrTdSpan2Text = document.createTextNode( '■' );
				firstTrTdSpan2.appendChild( firstTrTdSpan2Text );

				var firstTrTdBlankText = document.createTextNode( ' ' );
				firstTrTdSpan2.appendChild( firstTrTdBlankText );

				var firstTrTdLabel = document.createElement( 'label' );
				firstTrTdLabel.setAttribute( 'class', 'label_field_lable' );
				var firstTrTdLabelText = document.createTextNode( fieldValue );
				firstTrTdLabel.appendChild( firstTrTdLabelText );

				firstTrTdSpan.appendChild( firstTrTdSpan2 );
				firstTrTdSpan.appendChild( firstTrTdLabel );
			}
			firstTrTdDiv.appendChild( firstTrTdSpan );
			firstTd.appendChild( firstTrTdDiv );
			var firstTrSecondTd = document.createElement( 'td' );
			firstTrSecondTd.setAttribute( 'class', 'addon_price' );
			var originalAddonPrice = AWSF.addonPriceChangeToDecimalForCalc( fieldPrice );
			// Addon field Qty.
			var currentQuantity = $( '#' + fieldID + '_afq' ).val();
			if ( currentQuantity ) {
				fieldPrice = fieldPrice * currentQuantity;
			}
			var addonPrice = AWSF.addonPriceChangeToDecimalForCalc( fieldPrice );
			firstTrSecondTd.setAttribute( 'data-addon-price', addonPrice );
			firstTrSecondTd.setAttribute( 'data-addon-og-price', originalAddonPrice );
			if ( undefined !== fieldPrice ) {
				fieldPrice = AWSF.number_format( fieldPrice, decimals, decimalSeparator, thousandSeparator );
			}
			var firstSecondTdText;
			fieldPrice        = AWSF.setCurrencyPosition( fieldPrice );
			firstSecondTdText = document.createTextNode( fieldPrice );
			firstTrSecondTd.appendChild( firstSecondTdText );
			firstTr.appendChild( firstTd );
			firstTr.appendChild( firstTrSecondTd );
			return firstTr;
		},
		setCurrencyPosition: function ( fieldPrice ) {
			if ( 'left_space' == position ) {
				if ( fieldPrice.indexOf( '-' ) != -1 ) {
					fieldPrice = fieldPrice.replace( '-', '' );
					fieldPrice = '-' + currencySymbol + ' ' + fieldPrice;
				} else {
					fieldPrice = currencySymbol + ' ' + fieldPrice;
				}
			} else if ( 'left' == position ) {
				if ( fieldPrice.indexOf( '-' ) != -1 ) {
					fieldPrice = fieldPrice.replace( '-', '' );
					fieldPrice = '-' + currencySymbol + fieldPrice;
				} else {
					fieldPrice = currencySymbol + fieldPrice;
				}
			} else if ( 'right_space' == position ) {
				if ( fieldPrice.indexOf( '-' ) != -1 ) {
					fieldPrice = fieldPrice.replace( '-', '' );
					fieldPrice = '-' + fieldPrice + ' ' + currencySymbol;
				} else {
					fieldPrice = fieldPrice + ' ' + currencySymbol;
				}
			} else if ( 'right' == position ) {
				if ( fieldPrice.indexOf( '-' ) != -1 ) {
					fieldPrice = fieldPrice.replace( '-', '' );
					fieldPrice = '-' + fieldPrice + currencySymbol;
				} else {
					fieldPrice = fieldPrice + currencySymbol;
				}
			}
			return fieldPrice;
		},
		addTrInAddonDetails: function ( fieldValue, fieldID, trFieldName, fieldPrice, fieldImage, fieldType, getUniqueDivId ) {
			var firstTr;
			var mainTableID = $( '#addon_total' );
			if ( '' !== fieldValue ) {
				var checkTr = mainTableID.find( 'tr#tr_' + fieldID ).length;
				if ( 0 === checkTr ) {
					firstTr = AWSF.createTr( fieldValue, fieldID, trFieldName, fieldPrice, fieldImage, fieldType, getUniqueDivId );
				} else {
					if ( mainTableID.find( '#dv_' + fieldID ).length ) {
						mainTableID.find( '#dv_' + fieldID ).remove();
					}
					var mainTr       = document.getElementById( 'tr_' + fieldID );
					var firstTd      = mainTr.getElementsByTagName( 'td' )[0];
					var firstTrTdDiv = document.createElement( 'div' );
					firstTrTdDiv.setAttribute( 'id', 'dv_' + fieldID );
					var firstTrTdSpan = document.createElement( 'span' );
					firstTrTdSpan.setAttribute( 'class', 'span_field_lable' );
					// For colorpicker.
					if ( 'colorpicker' === fieldType ) {
						var trFieldNameReplace = trFieldName.replace( fieldValue, '' );
						trFieldName            = trFieldNameReplace;
					}
					var firstTrTdSpanText = document.createTextNode( trFieldName );
					firstTrTdSpan.appendChild( firstTrTdSpanText );
					// For colorpicker.
					if ( 'colorpicker' === fieldType ) {
						var firstTrTdSpan2 = document.createElement( 'span' );
						firstTrTdSpan2.setAttribute( 'style', 'color: ' + fieldValue + '; font-size:20px; padding: 0;line-height: 0' );
						var firstTrTdSpan2Text = document.createTextNode( '■' );
						firstTrTdSpan2.appendChild( firstTrTdSpan2Text );

						var firstTrTdBlankText = document.createTextNode( ' ' );
						firstTrTdSpan2.appendChild( firstTrTdBlankText );

						var firstTrTdLabel = document.createElement( 'label' );
						firstTrTdLabel.setAttribute( 'class', 'label_field_lable' );
						var firstTrTdLabelText = document.createTextNode( fieldValue );
						firstTrTdLabel.appendChild( firstTrTdLabelText );

						firstTrTdSpan.appendChild( firstTrTdSpan2 );
						firstTrTdSpan.appendChild( firstTrTdLabel );
					}
					firstTrTdDiv.appendChild( firstTrTdSpan );
					firstTd.appendChild( firstTrTdDiv );
					var secondTd           = mainTr.getElementsByTagName( 'td' )[1];
					var originalAddonPrice = AWSF.addonPriceChangeToDecimalForCalc( fieldPrice );
					// Addon field Qty.
					var currentQuantity = $( '#' + fieldID + '_afq' ).val();
					if ( currentQuantity ) {
						fieldPrice = fieldPrice * currentQuantity;
					}
					if ( fieldPrice ) {
						var formattedPrice = fieldPrice;
						if ( undefined !== fieldPrice ) {
							formattedPrice = AWSF.number_format( fieldPrice, decimals, decimalSeparator, thousandSeparator );
						}
						var fieldPriceDisplay = AWSF.setCurrencyPosition( formattedPrice );
						secondTd.textContent  = fieldPriceDisplay;
					}
					var thirdTd    = mainTr.getElementsByTagName( 'td' )[1];
					var addonPrice = AWSF.addonPriceChangeToDecimalForCalc( fieldPrice );
					thirdTd.setAttribute( 'data-addon-price', addonPrice );
					thirdTd.setAttribute( 'data-addon-og-price', originalAddonPrice );
				}
				var addonTotalRow = document.getElementById( 'addon_total' );
				var addonSubtotalRow = document.getElementById( 'addon_subtotal' );
				if ( addonTotalRow && addonSubtotalRow && firstTr ) {
					addonSubtotalRow.insertAdjacentHTML( 'beforebegin', firstTr.outerHTML );
				}
			} else {
				mainTableID.find( 'tr#tr_' + fieldID ).remove();
			}
		},
		number_format: function ( number, decimals, dec_point, thousands_point ) {
			if ( number == null ) {
				throw new TypeError( 'number is not valid' );
			}
			number = number.toString();
			// Need when use space as thousand separator.
			number         = ( number + '' ).replace( /[^0-9+\-Ee.]/g, '' );
			var n          = ! isFinite( +number ) ? 0 : +number,
				prec       = ! isFinite( +decimals ) ? 0 : Math.abs( decimals ),
				sep        = ( typeof thousands_point === 'undefined' ) ? ',' : thousands_point,
				dec        = ( typeof dec_point === 'undefined' ) ? '.' : dec_point,
				s          = '',
				toFixedFix = function ( n, prec ) {
					var k = Math.pow( 10, prec );
					return '' + Math.round( n * k ) / k;
				};
			// Fix for IE parseFloat(0.55).toFixed(0) = 0.
			s = ( prec ? toFixedFix( n, prec ) : '' + Math.round( n ) ).split( '.' ); // '.'
			if ( s[0].length > 3 ) {
				s[0] = s[0].replace( /\B(?=(?:\d{3})+(?!\d))/g, sep );
			}
			if ( ( s[1] || '' ).length < prec ) {
				s[1]  = s[1] || '';
				s[1] += new Array( prec - s[1].length + 1 ).join( '0' );
			}
			return s.join( dec );
		},
		calculateAddonPrice: function () {
			AWSF.updateProductPriceInAddonDetails();
			var checkHidden = [];
			$( '.epofw_fields_table:visible' ).each(
				function () {
					var $this = $( this );
					if ( 'display: none;' !== $.trim( $( $this ).attr( 'style' ) ) ) {
							checkHidden.push( true );
					}
				}
			);
			var checkData = checkHidden.includes( true );
			if ( true === checkData ) {
				if ( $( '#addon_total tr.addon_item' ).length === 0 ) {
					$( '#addon_total' ).hide();
				} else {
					$( '#addon_total' ).removeClass( 'addon_total_hd' );
					$( '#addon_total' ).show();
					var addonSubtotal = 0;
					$( '.epofw_addon_totals #addon_total:visible:not(.addon_total_hd) .addon_price' ).each(
						function () {
							addonSubtotal = parseFloat( addonSubtotal ) + parseFloat( $( this ).attr( 'data-addon-price' ) );
						}
					);

					if ( undefined !== addonSubtotal ) {
						addonSubtotal = AWSF.number_format( addonSubtotal, decimals, decimalSeparator, thousandSeparator );
					}
					var addonSubtotalElement = document.getElementById( 'addon_subtotal' );
					if ( addonSubtotalElement ) {
						var tdElements = addonSubtotalElement.getElementsByTagName( 'td' );
						var lastTdElement = tdElements[tdElements.length - 1];
						if ( lastTdElement ) {
							var strongElement = lastTdElement.querySelector( 'strong' );
							if ( strongElement ) {
								strongElement.textContent = AWSF.setCurrencyPosition( addonSubtotal );
							}
						}
					}

				}
			}
		},
		getFieldInputBasedOnType: function ( get_field_type ) {
			var fieldInput = '';
			if ( 'select' === get_field_type || 'multiselect' === get_field_type ) {
				fieldInput = 'select';
			} else if (
				'radiogroup' === get_field_type
			) {
				fieldInput = 'input[type="radio"]:checked';
			} else if (
				'checkboxgroup' === get_field_type ||
				'checkbox' === get_field_type ) {
				fieldInput = 'input[type="checkbox"]:checked';
			} else if (
				'text' === get_field_type ||
				'password' === get_field_type ||
				'hidden' === get_field_type ||
				'number' === get_field_type ||
				'datepicker' === get_field_type ||
				'colorpicker' === get_field_type ||
				'timepicker' === get_field_type
			) {
				fieldInput = 'input[type="text"]';
			} else if ( 'textarea' === get_field_type ) {
				fieldInput = 'textarea';
			}
			return fieldInput;
		},
		findMatchingVariations: function ( variations, attributes ) {
			var matching         = [];
			var variationsLength = variations.length;

			for ( var i = 0; i < variationsLength; i++ ) {
				var variation = variations[ i ];
				if ( AWSF.isMatch( variation.attributes, attributes ) ) {
					matching.push( variation );
				}
			}
			return matching;
		},
		isMatch: function ( variation_attributes, attributes ) {
			var match = true;
			for ( var attr_name in variation_attributes ) {
				if ( variation_attributes.hasOwnProperty( attr_name ) ) {
					var val1 = variation_attributes[attr_name];
					var val2 = attributes[attr_name];// attributes.
					if ( val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2 ) {
						match = false;
					}
				}
			}
			return match;
		},
		getChosenAttributes: function () {
			var data   = {};
			var count  = 0;
			var chosen = 0;
			$( '.variations_form' ).find( '.variations select' ).each(
				function () {
					var attribute_name = $( this ).data( 'attribute_name' ) || $( this ).attr( 'name' );
					var value          = $( this ).val() || '';
					if ( value.length > 0 ) {
							chosen++;
					}
					count++;
					data[attribute_name] = value;
				}
			);
			return {
				'count': count,
				'chosenCount': chosen,
				'data': data
			};
		},
		epofwMatchParameter: function ( epofwData, productId, variationId, qty, trIds ) {
			var matchArray = [];
			matchArray.push( true );
			var epofwDataLength = epofwData.length;
			for ( var i = 0; i < epofwDataLength; i++ ) {
				var variation      = epofwData[i];
				var epofwOperator  = variation.opt;
				var epofwCondition = variation.cnd;
				var checkProductId, match, checkData;
				var epofwValue = variation.val;
				if ( 'prdvar' === epofwCondition || 'qty' === epofwCondition || 'dp' === epofwCondition ) {
					if ( 'prdvar' === epofwCondition ) {
						checkProductId = variationId;
					} else if ( 'qty' === epofwCondition ) {
						checkProductId = qty;
					} else if ( 'dp' === epofwCondition ) {
						var fullDate      = new Date();
						var twoDigitMonth = ( ( fullDate.getMonth().length + 1 ) === 1 ) ? ( fullDate.getMonth() + 1 ) : '0' + ( fullDate.getMonth() + 1 );
						var twoDigitDate  = ( '0' + fullDate.getDate() ).slice( -2 );
						var currentDate   = twoDigitDate + '-' + twoDigitMonth + '-' + fullDate.getFullYear();
						checkProductId    = currentDate;
					} else {
						checkProductId = productId;
					}
					checkProductId = checkProductId.toString();
					if ( checkProductId ) {
						if ( 'dp' === epofwCondition ) {
							var str       = epofwValue.toString();
							var result    = [ str[ 0 ] + str[ 1 ] ];
							var strLength = str.length;
							for ( var x = 2; x < strLength; x++ ) {
								if ( x <= 4 ) {
									if ( str[ x ] % 2 === 0 ) {
										result.push( '-', str[ x ] );
									} else {
										result.push( str[ x ] );
									}
								} else {
									result.push( str[ x ] );
								}
							}
							var resultArray = [ result.join( '' ) ];
							epofwValue      = resultArray;
						} else {
							epofwValue = variation.val.toString();
						}
						if ( 'iet' === epofwOperator ) {
							checkData = epofwValue.includes( checkProductId );
							if ( true === checkData ) {
								match = true;
							} else {
								match = false;
							}
						} else if ( 'net' === epofwOperator ) {
							checkData = epofwValue.includes( checkProductId );
							if ( true === checkData ) {
								match = true;
							} else {
								match = false;
							}
						}
						matchArray.push( match );
						if ( 'qty' === epofwCondition || 'dp' === epofwCondition ) {
							var epofwValueLength = epofwValue.length;
							for ( var j = 0; j < epofwValueLength; j++ ) {
								if ( 'lt' === epofwOperator ) {
									if ( epofwValue[j] > checkProductId ) {
										match = true;
									} else {
										match = false;
									}
								} else if ( 'let' === epofwOperator ) {
									if ( epofwValue[j] >= checkProductId ) {
										match = true;
									} else {
										match = false;
									}
								} else if ( 'gt' === epofwOperator ) {
									if ( epofwValue[j] < checkProductId ) {
										match = true;
									} else {
										match = false;
									}
								} else if ( 'get' === epofwOperator ) {
									if ( epofwValue[j] <= checkProductId ) {
										match = true;
									} else {
										match = false;
									}
								}
							}
							matchArray.push( match );
						}
					} else {
						match = false;
						matchArray.push( match );
					}
				}
			}
			if ( $.inArray( false, matchArray ) >= 0 ) {
				$( trIds ).each(
					function ( index, trValue ) {
						$( '#tr_' + trValue ).remove();
						AWSF.calculateAddonPrice();
					}
				);
				return false;
			} else {
				$( trIds ).each(
					function () {
						AWSF.calculateAddonPrice();
					}
				);
				return true;
			}
		},
		epofwFieldsMatchParameter: function ( $this, key, action ) {
			var epofwData;
			if ( 'logical_operation' === action ) {
				epofwData = $this.attr( 'data-epofw_sa' );
			} else {
				epofwData = $this.parent().closest( '.epofw_td_value' ).attr( 'data-epofw_sa' );
			}
			if ( epofwData ) {
				var epofwDataJson = JSON.parse( epofwData );
				return epofwDataJson[0][key];
			}
		},
		epofwCheckTable: function ( productId, variationId, qty ) {
			$( '.epofw_fields_table' ).each(
				function () {
					var $this          = $( this );
					var getEopfwAttr   = $( this ).data( 'epofw_attr' );
					var getUniqueDivId = $( this ).closest( '.epofw_addon_html' ).data( 'uqd-attr' );
					var trIds          = [];
					$( this ).find( '.epofw_tr_se:visible' ).each(
						function () {
							trIds.push( $( this ).find( 'input, select, textarea' ).attr( 'id' ) );
						}
					);
					var matchData = AWSF.epofwMatchParameter( getEopfwAttr, productId, variationId, qty, trIds );
					if ( true === matchData ) {
						if ( ( $this ).hasClass( 'epofw_field_qty_hd' ) ) {
							$this.removeClass( 'epofw_field_qty_hd' );
						}
						if ( ( $this ).hasClass( 'epofw_field_dnl' ) ) {
							$this.removeClass( 'epofw_field_dnl' );
						}
						AWSF.epofwGetFieldData( $this, qty, getUniqueDivId );
						AWSF.calculateAddonPrice();
						$this.show();
					} else {
						AWSF.epofwGetFieldData( $this, qty, getUniqueDivId );
						$( '#addon_total tr[data-udi="' + getUniqueDivId + '"]' ).each(
							function () {
								$( '#' + $( this ).attr( 'id' ) ).remove();
							}
						);
						AWSF.calculateAddonPrice();
						$this.hide();
					}
				}
			);
		},
		getFieldPriceBasedOnPriceOptions: function ( fieldValue, fieldPriceType, fieldPrice ) {
			fieldPrice = fieldPrice;
			return AWSF.addonPriceChangeToDecimalForCalc( fieldPrice );
		},
		epofwGetFieldData: function ( thisData, qty, getUniqueDivId ) {
			$( thisData ).find( '.epofw_tr_se:visible input, .epofw_tr_se:visible textarea' ).each(
				function () {
					AWSF.epofwDisplayFiledsDataAndDisplay( $( this ), qty, getUniqueDivId );
				}
			);
			$( thisData ).find( '.epofw_tr_se:visible select' ).each(
				function () {
					AWSF.epofwDisplayAnotherFiledsDataAndDisplay( $( this ), qty, getUniqueDivId );
				}
			);
		},
		epofwMatchOptionsBasedOnCheckedValue: function ( fieldOptions, fieldValue ) {
			if ( fieldOptions.hasOwnProperty( fieldValue ) ) {
				return fieldOptions[fieldValue];
			}
		},
		epofwDisplayFiledsDataAndDisplay: function ( $this, qty, getUniqueDivId ) {
			if ( $this.closest( '.epofw_tr_se' ).is( ':hidden' ) ) {
				return;
			}
			var dataInpType = AWSF.epofwFieldsMatchParameter( $this, 'data_inp_type', '' );
			if ( 'select' === dataInpType || 'multiselect' === dataInpType ) {
				return;
			}
			var fieldType = AWSF.epofwFieldsMatchParameter( $this, 'data_inp_type', '' );
			var fieldName, fieldValue, fieldPrice, fieldPriceType, fieldID, trFieldName, firstTr,
				trID, getFieldData, inputfieldName, inputfieldNameReplaceWithValue,
				inputfieldNameReplaced, fieldOptions;
			qty = $( '.quantity input[name="quantity"]' ).val();
			if ( 'checkbox' === fieldType ) {
				fieldID                   = $this.attr( 'id' );
				var multiSelectValueArray = {};
				$( $( 'input[name="' + $this.attr( 'name' ) + '"]:checked' ) ).each(
					function () {
						fieldValue   = $( this ).val();
						fieldOptions = AWSF.epofwFieldsMatchParameter( $( this ), 'options', '' );
						getFieldData = AWSF.epofwMatchOptionsBasedOnCheckedValue( fieldOptions, fieldValue );
						if ( getFieldData ) {
								fieldPriceType = getFieldData[1];
								fieldPrice     = AWSF.getFieldPriceBasedOnPriceOptions( fieldValue, fieldPriceType, getFieldData[2] );
						}
						multiSelectValueArray[fieldValue] = fieldPrice;
					}
				);
				var multiSelectPrice = 0;
				var multiFieldValue  = [];
				for ( var key in multiSelectValueArray ) {
					multiFieldValue.push( key );
					multiSelectPrice = parseFloat( multiSelectPrice ) + parseFloat( multiSelectValueArray[key] );
				}
				if ( multiFieldValue ) {
					fieldValue = multiFieldValue.join();
				}
				fieldPrice                     = multiSelectPrice;
				fieldName                      = $this.attr( 'data-label-name' );
				trFieldName                    = fieldName + ' - ' + fieldValue;
				inputfieldName                 = $this.attr( 'name' );
				inputfieldNameReplaceWithValue = inputfieldName.replace( '[value]', '' );
				inputfieldNameReplaced         = inputfieldNameReplaceWithValue.replace( '[]', '' );
				if ( '' !== fieldValue ) {
					if ( $( 'tr#tr_' + inputfieldNameReplaced ).length === 0 ) {
						firstTr = AWSF.createTr( fieldValue, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
					} else {
						AWSF.changeAddonDetailsIfTrExists( inputfieldNameReplaced, trFieldName, multiSelectPrice, fieldPrice, getUniqueDivId );
					}
					var addonTotalRow = document.getElementById( 'addon_total' );
					var addonSubtotalRow = document.getElementById( 'addon_subtotal' );
					if ( addonTotalRow && addonSubtotalRow && firstTr ) {
						addonSubtotalRow.insertAdjacentHTML( 'beforebegin', firstTr.outerHTML );
					}
				} else {
					$( 'tr#tr_' + inputfieldNameReplaced ).remove();
				}
			} else if ( 'checkboxgroup' === fieldType ) {
				fieldValue                     = '';
				inputfieldName                 = $this.attr( 'name' );
				inputfieldNameReplaceWithValue = inputfieldName.replace( '[value]', '' );
				inputfieldNameReplaced         = inputfieldNameReplaceWithValue.replace( '[]', '' );
				if ( $this.is( ':checked' ) ) {
					fieldValue   = $this.val();
					fieldOptions = AWSF.epofwFieldsMatchParameter( $this, 'options', '' );
					getFieldData = AWSF.epofwMatchOptionsBasedOnCheckedValue( fieldOptions, fieldValue );
					if ( getFieldData ) {
						fieldPriceType = getFieldData[1];
						fieldPrice     = AWSF.getFieldPriceBasedOnPriceOptions( fieldValue, fieldPriceType, getFieldData[2] );

						fieldName = $this.attr( 'data-label-name' );
						trID      = $this.parent().parent().parent().attr( 'id' );
						$( '#' + trID + ' .epofw_field_checkboxgroup' ).prop( 'checked', false );
						$this.prop( 'checked', true );
						fieldID     = $this.attr( 'id' );
						trFieldName = fieldName + ' - ' + fieldValue;
						AWSF.addTrInAddonDetails( fieldValue, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
					}
				} else {
					$( 'tr#tr_' + inputfieldNameReplaced ).remove();
				}
			} else if ( 'radiogroup' === fieldType ) {
				fieldValue                     = '';
				inputfieldName                 = $this.attr( 'name' );
				inputfieldNameReplaceWithValue = inputfieldName.replace( '[value]', '' );
				inputfieldNameReplaced         = inputfieldNameReplaceWithValue.replace( '[]', '' );
				if ( $this.is( ':checked' ) ) {
					fieldValue   = $this.val();
					fieldOptions = AWSF.epofwFieldsMatchParameter( $this, 'options', '' );
					getFieldData = AWSF.epofwMatchOptionsBasedOnCheckedValue( fieldOptions, fieldValue );
					if ( getFieldData ) {
						fieldPriceType = getFieldData[1];
						fieldPrice     = AWSF.getFieldPriceBasedOnPriceOptions( fieldValue, fieldPriceType, getFieldData[2] );

						fieldName   = $this.attr( 'data-label-name' );
						fieldID     = $this.attr( 'id' );
						trFieldName = fieldName + ' - ' + fieldValue;
						AWSF.addTrInAddonDetails( fieldValue, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
					}
				}
			} else if ( 'html' === fieldType ) {
				fieldID        = $this.attr( 'id' );
				fieldName      = AWSF.epofwFieldsMatchParameter( $this, 'data-label-name', '' );
				fieldValue     = $this.val();
				fieldPrice     = AWSF.epofwFieldsMatchParameter( $this, 'addon_price', '' );
				fieldPriceType = AWSF.epofwFieldsMatchParameter( $this, 'addon_price_type', '' );
				fieldPrice     = AWSF.getFieldPriceBasedOnPriceOptions( fieldValue, fieldPriceType, fieldPrice );
				trFieldName    = fieldName + ' - ' + fieldValue;
				if ( fieldValue ) {
					AWSF.addTrInAddonDetails( fieldValue, fieldID, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
				}
			} else {
				if ( 'undefined' === typeof fieldType ) {
					return;
				}
				// Show Addon Field Quantity Box.
				fieldID                        = $this.attr( 'id' );
				fieldName                      = $this.attr( 'data-label-name' );
				fieldValue                     = $this.val();
				inputfieldName                 = $this.attr( 'name' );
				inputfieldNameReplaceWithValue = inputfieldName.replace( '[value]', '' );
				inputfieldNameReplaced         = inputfieldNameReplaceWithValue.replace( '[]', '' );
				fieldPrice                     = AWSF.epofwFieldsMatchParameter( $this, 'addon_price', '' );
				fieldPriceType                 = AWSF.epofwFieldsMatchParameter( $this, 'addon_price_type', '' );
				fieldPrice                     = AWSF.getFieldPriceBasedOnPriceOptions( fieldValue, fieldPriceType, fieldPrice );
				trFieldName                    = fieldName + ' - ' + fieldValue;
				AWSF.addTrInAddonDetails( fieldValue, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
			}
			AWSF.calculateAddonPrice();
		},
		epofwMultiSelectData: function ( $this, fieldName, fieldValue, fieldType, fieldPrice, trFieldName, firstTr, fieldID, fieldOptions, qty, getUniqueDivId ) {
			if ( $this.closest( '.epofw_tr_se' ).is( ':hidden' ) ) {
				return;
			}
			var selectionsData = $( '#' + $this.attr( 'id' ) ).select2( 'data' );
			if ( selectionsData ) {
				var multiSelectValueArray = {};
				$( selectionsData ).each(
					function ( index, value ) {
						var getMultiSelectFieldData = AWSF.epofwMatchOptionsBasedOnCheckedValue( fieldOptions, value.id );
						if ( getMultiSelectFieldData ) {
								var fieldPriceType              = getMultiSelectFieldData[1];
								var multiSelectOptionPrice      = AWSF.getFieldPriceBasedOnPriceOptions( fieldValue, fieldPriceType, getMultiSelectFieldData[2] );
								multiSelectValueArray[value.id] = multiSelectOptionPrice;
						}
					}
				);
				var multiSelectPrice = 0;
				var multiFieldValue  = [];
				for ( var key in multiSelectValueArray ) {
					multiFieldValue.push( key );
					multiSelectPrice = parseFloat( multiSelectPrice ) + parseFloat( multiSelectValueArray[key] );
				}
				if ( multiFieldValue ) {
					fieldValue = multiFieldValue.join();
				}
				fieldPrice  = multiSelectPrice;
				trFieldName = fieldName + ' - ' + fieldValue;
				if ( 'All' === $.trim( fieldValue ) ) {
					$( '#' + fieldID + ' > option' ).prop( 'selected', 'selected' );
					$( '#' + fieldID ).trigger( 'change' );
				}
				var inputfieldName                 = $this.attr( 'name' );
				var inputfieldNameReplaceWithValue = inputfieldName.replace( '[value]', '' );
				var inputfieldNameReplaced         = inputfieldNameReplaceWithValue.replace( '[]', '' );
				if ( '' !== fieldValue ) {
					if ( $( 'tr#tr_' + inputfieldNameReplaced ).length === 0 ) {
						firstTr = AWSF.createTr( fieldValue, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
					} else {
						AWSF.changeAddonDetailsIfTrExists( inputfieldNameReplaced, trFieldName, multiSelectPrice, fieldPrice, getUniqueDivId );
					}
					var addonTotalRow = document.getElementById( 'addon_total' );
					var addonSubtotalRow = document.getElementById( 'addon_subtotal' );
					if ( addonTotalRow && addonSubtotalRow && firstTr ) {
						addonSubtotalRow.insertAdjacentHTML( 'beforebegin', firstTr.outerHTML );
					}
				} else {
					$( 'tr#tr_' + inputfieldNameReplaced ).remove();
				}
				AWSF.calculateAddonPrice();
			}
		},
		epofwDisplayAnotherFiledsDataAndDisplay: function ( $this, qty, getUniqueDivId ) {
			if ( $this.closest( '.epofw_tr_se' ).is( ':hidden' ) ) {
				return;
			}
			var fieldType = AWSF.epofwFieldsMatchParameter( $this, 'data_inp_type', '' );
			var fieldName = $this.parent().children().attr( 'data-label-name' );
			if ( undefined === fieldName ) {
				fieldName = $this.parent().parent().children().children().attr( 'data-label-name' );
			}
			var fieldID                        = $this.attr( 'id' );
			var inputfieldName                 = $this.attr( 'name' );
			var inputfieldNameReplaceWithValue = inputfieldName.replace( '[value]', '' );
			var inputfieldNameReplaced         = inputfieldNameReplaceWithValue.replace( '[]', '' );
			var checkTr                        = $( 'tr#tr_' + inputfieldNameReplaced ).length;
			var trFieldName, firstTr, fieldOptions, fieldValue, fieldPrice, fieldPriceType, fieldPriceForAddonAttr;
			if ( 'multiselect' === fieldType ) {
				fieldOptions = AWSF.epofwFieldsMatchParameter( $this, 'options', '' );
				fieldValue   = '';
				$( '#' + $this.attr( 'id' ) ).on(
					'select2:select',
					function () {
						AWSF.epofwMultiSelectData( $this, fieldName, fieldValue, fieldType, fieldPrice, trFieldName, firstTr, fieldID, fieldOptions, qty, getUniqueDivId );
					}
				);
				$( '#' + $this.attr( 'id' ) ).on(
					'select2:unselect',
					function () {
						AWSF.epofwMultiSelectData( $this, fieldName, fieldValue, fieldType, fieldPrice, trFieldName, firstTr, fieldID, fieldOptions, qty, getUniqueDivId );
					}
				);
			} else if ( 'select' === fieldType ) {
				fieldValue       = $this.val();
				fieldOptions     = AWSF.epofwFieldsMatchParameter( $this, 'options', '' );
				var getFieldData = AWSF.epofwMatchOptionsBasedOnCheckedValue( fieldOptions, fieldValue );
				if ( getFieldData ) {
					fieldPriceType         = getFieldData[1];
					fieldPriceForAddonAttr = getFieldData[2];
					fieldPrice             = AWSF.getFieldPriceBasedOnPriceOptions( fieldValue, fieldPriceType, getFieldData[2] );
					if ( '' !== fieldValue && undefined !== fieldValue ) {
						trFieldName = fieldName + ' - ' + fieldValue;
					}
				}
				if ( '' !== fieldValue ) {
					if ( checkTr === 0 ) {
						firstTr = AWSF.createTr( fieldValue, inputfieldNameReplaced, trFieldName, fieldPrice, '', fieldType, getUniqueDivId );
					} else {
						AWSF.changeAddonDetailsIfTrExists( inputfieldNameReplaced, trFieldName, fieldPriceForAddonAttr, fieldPrice, getUniqueDivId );
					}
					var addonTotalRow = document.getElementById( 'addon_total' );
					var addonSubtotalRow = document.getElementById( 'addon_subtotal' );
					if ( addonTotalRow && addonSubtotalRow && firstTr ) {
						addonSubtotalRow.insertAdjacentHTML( 'beforebegin', firstTr.outerHTML );
					}
				} else {
					$( 'tr#tr_' + inputfieldNameReplaced ).remove();
				}
				AWSF.calculateAddonPrice();
			}
		},
		epofwGetProductId: function () {
			var productId;
			if ( $( 'form.cart' ).hasClass( 'variations_form' ) ) {
				productId = $( 'input[name="product_id"]' ).val();
			}
			if ( $( 'form.cart' ).hasClass( 'bundle_form' ) ) {
				productId = $( 'input[name="add-to-cart"]' ).val();
			} else {
				productId = $( 'button[name="add-to-cart"]' ).val();
			}
			return productId;
		},
		epofwGetFieldsExtraAttr: function ( $this ) {
			return $this.parent().closest( '.epofw_td_value' ).attr( 'data-epofw_sa' );
		},
	};
	$(
		function () {
			AWS_Front.init();
		}
	);
	window.AWSF = AWS_Front;
} )( jQuery );
