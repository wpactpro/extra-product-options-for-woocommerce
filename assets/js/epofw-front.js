( function ($) {
	'use strict';
	let currencySymbol = epofw_front_var.currency;
	let decimalSeparator = epofw_front_var.decimal_separator;
	let thousandSeparator = epofw_front_var.thousand_separator;
	let decimals = epofw_front_var.decimals;
	let position = epofw_front_var.position;
	
	function createTr (fieldID, trFieldName, fieldPrice) {
		var firstTr = document.createElement('tr');
		firstTr.setAttribute('id', fieldID);
		firstTr.setAttribute('class', 'addon_item');
		
		var firstTrTd = document.createElement('td');
		var firstTdText = document.createTextNode(trFieldName);
		firstTrTd.appendChild(firstTdText);
		
		var firstTrSecondTd = document.createElement('td');
		firstTrSecondTd.setAttribute('class', 'addon_price');
		firstTrSecondTd.setAttribute('data-addon-price', fieldPrice);
		if (undefined !== fieldPrice) {
			fieldPrice = number_format(fieldPrice, decimals, decimalSeparator, thousandSeparator);
		}
		var firstSecondTdText;
		if ( 'left_space' == position ) {
			firstSecondTdText = document.createTextNode(currencySymbol + ' ' + fieldPrice);
		} else if ( 'left' == position ) {
			firstSecondTdText = document.createTextNode(currencySymbol + fieldPrice);
		} else if ( 'right_space' == position ) {
			firstSecondTdText = document.createTextNode(fieldPrice + ' ' + currencySymbol);
		} else if ( 'right' == position ) {
			firstSecondTdText = document.createTextNode(fieldPrice + currencySymbol );
		}
		firstTrSecondTd.appendChild(firstSecondTdText);
		
		firstTr.appendChild(firstTrTd);
		firstTr.appendChild(firstTrSecondTd);
		return firstTr;
	}
	
	function number_format (number, decimals, dec_point, thousands_point) {
		if (number == null) {
			throw new TypeError('number is not valid');
		}
		number = number.toString();
		// Need when use space as thousand separator
		number = ( number + '' ).replace(/[^0-9+\-Ee.]/g, '');
		var n = !isFinite(+number) ? 0 : +number,
			prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
			sep = ( typeof thousands_point === 'undefined' ) ? ',' : thousands_point,
			dec = ( typeof dec_point === 'undefined' ) ? '.' : dec_point,
			s = '',
			toFixedFix = function (n, prec) {
				var k = Math.pow(10, prec);
				return '' + Math.round(n * k) / k;
			};
		// Fix for IE parseFloat(0.55).toFixed(0) = 0;
		s = ( prec ? toFixedFix(n, prec) : '' + Math.round(n) ).split('.'); //'.'
		if (s[0].length > 3) {
			s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
		}
		if (( s[1] || '' ).length < prec) {
			s[1] = s[1] || '';
			s[1] += new Array(prec - s[1].length + 1).join('0');
		}
		return s.join(dec);
	}
	
	function calculateAddonPrice () {
		if ($('#addon_total tr.addon_item').length === 0) {
			$('#addon_total').hide();
		} else {
			$('#addon_total').show();
		}
		var addonSubtotal = 0;
		$('#addon_total tr td.addon_price').each(
			function () {
				addonSubtotal = parseFloat(addonSubtotal) + parseFloat($(this).attr('data-addon-price'));
			}
		);
		if (undefined !== addonSubtotal) {
			addonSubtotal = number_format(addonSubtotal, decimals, decimalSeparator, thousandSeparator);
		}
		var fieldPriceWithCurrency;
		if ( 'left_space' == position ) {
			fieldPriceWithCurrency = currencySymbol + ' ' + addonSubtotal;
		} else if ( 'left' == position ) {
			fieldPriceWithCurrency = currencySymbol + addonSubtotal;
		} else if ( 'right_space' == position ) {
			fieldPriceWithCurrency = addonSubtotal + ' ' + currencySymbol;
		} else if ( 'right' == position ) {
			fieldPriceWithCurrency = addonSubtotal + currencySymbol;
		}
		$('#addon_subtotal td:last strong').html(fieldPriceWithCurrency );
		
	}
	
	function addTrInAddonDetails (fieldValue, fieldID, trFieldName, fieldPrice) {
		var firstTr;
		if ('' !== fieldValue) {
			var checkTr = $('tr#' + fieldID).length;
			if (0 === checkTr) {
				firstTr = createTr(fieldID, trFieldName, fieldPrice);
			} else {
				$('tr#' + fieldID).find('td:first').html(trFieldName);
				var fieldPriceWithCurrency;
				if ( 'left_space' == position ) {
					fieldPriceWithCurrency = currencySymbol + ' ' + fieldPrice;
				} else if ( 'left' == position ) {
					fieldPriceWithCurrency = currencySymbol + fieldPrice;
				} else if ( 'right_space' == position ) {
					fieldPriceWithCurrency = fieldPrice + ' ' + currencySymbol;
				} else if ( 'right' == position ) {
					fieldPriceWithCurrency = fieldPrice + currencySymbol;
				}
				$('tr#' + fieldID).find('td:last').html(fieldPriceWithCurrency );
				$('tr#' + fieldID).find('td:last').attr('data-addon-price', fieldPrice);
			}
			$('#addon_total #addon_subtotal').before(firstTr);
		} else {
			$('tr#' + fieldID).remove();
		}
	}
	
	function findMatchingVariations (variations, attributes) {
		var matching = [];
		for (var i = 0; i < variations.length; i++) {
			var variation = variations[i];
			if (isMatch(variation.attributes, attributes)) {
				matching.push(variation);
			}
		}
		return matching;
	}
	
	function isMatch (variation_attributes, attributes) {
		var match = true;
		for (var attr_name in variation_attributes) {
			if (variation_attributes.hasOwnProperty(attr_name)) {
				var val1 = variation_attributes[attr_name];
				var val2 = attributes[attr_name];//attributes;
				if (val1 !== undefined && val2 !== undefined && val1.length !== 0 && val2.length !== 0 && val1 !== val2) {
					match = false;
				}
			}
		}
		return match;
	}
	
	function getChosenAttributes () {
		var data = {};
		var count = 0;
		var chosen = 0;
		$('.variations_form').find('.variations select').each(function () {
			var attribute_name = $(this).data('attribute_name') || $(this).attr('name');
			var value = $(this).val() || '';
			if (value.length > 0) {
				chosen++;
			}
			count++;
			data[attribute_name] = value;
		});
		return {
			'count': count,
			'chosenCount': chosen,
			'data': data
		};
	}
	
	var AWS_Front = {
		init: function () {
			$(document).click(function (e) {
				if (!$(e.target).is(".epofw_dft_colorpicker")) {
					$('.epofw_dft_colorpicker').iris('hide');
				}
			});
			$('.epofw_dft_colorpicker').click(function (event) {
				$('.epofw_dft_colorpicker').iris('hide');
				$(this).iris('show');
				return false;
			});
			if ($('.epofw_dft_multiselect').length) {
				$('.epofw_dft_multiselect').select2();
			}
			if ($('.epofw_dft_datepicker').length) {
				$('.epofw_dft_datepicker').each(
					function () {
						var fieldID = $(this).attr('id');
						$('#' + fieldID).datepicker(
							{
								dateFormat: 'dd-mm-yy',
							}
						);
					}
				);
			}
			if ($('.epofw_dft_timepicker').length) {
				$('.epofw_dft_timepicker').each(
					function () {
						var fieldID = $(this).attr('id');
						$('#' + fieldID).timepicker(
							{
								timeFormat: 'hh:mm:ss TT',
							}
						);
					}
				);
			}
			if ($('.epofw_dft_colorpicker').length) {
				$('.epofw_dft_colorpicker').each(
					function () {
						var fieldID = $(this).attr('id');
						var fieldPrice = $(this).attr('addon_price');
						var labelName = $(this).attr('data-label-name');
						$('#' + fieldID).iris(
							{
								change: function (event, ui) {
									var color = ui.color.toString();
									var trFieldName = labelName + ' - ' + color;
									var checkTr = $('tr#' + fieldID).length;
									if (checkTr === 0) {
										var firstTr = createTr(fieldID, trFieldName, fieldPrice);
										$('#addon_total #addon_subtotal').before(firstTr);
									} else {
										$('tr#' + fieldID).find('td:first').html(trFieldName);
									}
									calculateAddonPrice();
								},
								clear: function (event) {
									var element = jQuery(event.target).siblings('.wp-color-picker')[0];
									var color = '';
									if (element) {
										$('tr#' + fieldID).remove();
										calculateAddonPrice();
									}
								}
							}
						);
					}
				);
			}

			$(document).on('change', '.epofw_fields_table input, .epofw_fields_table textarea', AWS_Front.onKeyUpChangeAddon);
			$(document).on('change', '.epofw_fields_table select', AWS_Front.onKeyUpChangeSelectAddon);
			$(document).on('change', '.variations_form .variations select', AWS_Front.getSelectedVariation);
		},
		getSelectedVariation: function () {
			var variationData = $('.variations_form').data('product_variations');
			var currentAttributes = getChosenAttributes();
			var matching_variations = findMatchingVariations(variationData, currentAttributes.data);
			if (matching_variations) {
				if (currentAttributes.count == currentAttributes.chosenCount) {
					if (matching_variations.hasOwnProperty(0)) {
						var variationPrice = matching_variations[0].display_price;
						var variationPriceWithFormat = variationPrice.toFixed(decimals);
						var variationPriceWithFormatReplace = variationPriceWithFormat.replace('.', decimalSeparator);
						$('#addon_prd_details .addon_price').attr('data-addon-price', variationPrice);
						$('#addon_prd_details .addon_price strong span').html(
							'<span class="woocommerce-Price-currencySymbol">' + currencySymbol + '</span>' + variationPriceWithFormatReplace
						);
						calculateAddonPrice();
					}
				}
			}
		},
		onKeyUpChangeAddon: function () {
			var fieldType = $(this).attr('data-inp-type');
			var fieldName;
			var fieldValue;
			var fieldPrice;
			var fieldPriceType;
			var fieldID;
			var trFieldName;
			var firstTr;
			if ('checkbox' === fieldType) {
				fieldName = $(this).attr('data-label-name');
				fieldValue = $(this).val();
				fieldPrice = $(this).attr('addon_price');
				fieldID = $(this).attr('id');
				trFieldName = fieldName + ' - ' + fieldValue;
				if ($(this).is(':checked')) {
					addTrInAddonDetails(fieldValue, fieldID, trFieldName, fieldPrice);
				} else {
					$('tr#' + fieldID).remove();
				}
			} else if ('checkboxgroup' === fieldType) {
				var trID = $(this).parent().parent().parent().attr('id');
				$('#' + trID + ' .epofw_field_checkboxgroup').prop('checked', false);
				$(this).prop('checked', true);
				fieldName = $(this).attr('data-label-name');
				fieldValue = $(this).val();
				fieldID = $(this).attr('id');
				var fieldInpName = $(this).attr('name');
				trFieldName = fieldName + ' - ' + fieldValue;
				var fieldValue = $('input[name=' + fieldInpName + ']:checked').val();
				fieldPrice = $('input[name=' + fieldInpName + ']:checked').attr('addon_price');
				if (undefined !== fieldPrice) {
					fieldPrice = number_format(fieldPrice, decimals, decimalSeparator, thousandSeparator);
				} else {
					fieldPrice = 0;
				}
				addTrInAddonDetails(fieldValue, fieldID, trFieldName, fieldPrice);
			} else if ('radiogroup' === fieldType) {
				fieldName = $(this).attr('data-label-name');
				fieldValue = $(this).val();
				fieldID = $(this).attr('id');
				var fieldInpName = $(this).attr('name');
				trFieldName = fieldName + ' - ' + fieldValue;
				var fieldValue = $('input[name=' + fieldInpName + ']:checked').val();
				fieldPrice = $('input[name=' + fieldInpName + ']:checked').attr('addon_price');
				if (undefined !== fieldPrice) {
					fieldPrice = number_format(fieldPrice, decimals, decimalSeparator, thousandSeparator);
				} else {
					fieldPrice = 0;
				}
				addTrInAddonDetails(fieldValue, fieldID, trFieldName, fieldPrice);
			} else {
				fieldName = $(this).attr('data-label-name');
				fieldValue = $(this).val();
				fieldPrice = $(this).attr('addon_price');
				fieldPriceType = $(this).attr('addon_price_type');
				if (undefined !== fieldPrice) {
					fieldPrice = number_format(fieldPrice, decimals, decimalSeparator, thousandSeparator);
				} else {
					fieldPrice = 0;
				}
				fieldID = $(this).attr('id');
				trFieldName = fieldName + ' - ' + fieldValue;
				
				addTrInAddonDetails(fieldValue, fieldID, trFieldName, fieldPrice);
			}
			calculateAddonPrice();
		},
		onKeyUpChangeSelectAddon: function () {
			var fieldName = $(this).parent().children().attr('data-label-name');
			if (undefined === fieldName) {
				fieldName = $(this).parent().parent().children().children().attr('data-label-name');
			}
			var fieldValue = $(this).val();
			var fieldPrice;
			var fieldID = $(this).attr('id');
			var trFieldName = fieldName + ' - ' + fieldValue;
			var checkTr = $('tr#' + fieldID).length;
			var firstTr;
			var fieldType = $(this).attr('data-inp-type');
			if ('multiselect' === fieldType) {
				if ('All' === $.trim(fieldValue)) {
					$('#' + fieldID + ' > option').prop('selected', 'selected');
					$('#' + fieldID + ' > option').prop('selected', 'selected');
					$('#' + fieldID).trigger('change');
				}
				var multiselectFieldPrice = 0;
				$('#' + fieldID + ' :selected').map(function (i, el) {
					multiselectFieldPrice = parseFloat(multiselectFieldPrice) + parseFloat($(el).attr('addon_price'));
				}).get();
				
				fieldPrice = multiselectFieldPrice;
			} else {
				fieldPrice = $('option:selected', this).attr('addon_price');
				if (undefined !== fieldPrice) {
					fieldPrice = number_format(fieldPrice, decimals, decimalSeparator, thousandSeparator);
				} else {
					fieldPrice = 0;
				}
			}
			if ('' !== fieldValue) {
				if (checkTr === 0) {
					firstTr = createTr(fieldID, trFieldName, fieldPrice);
				} else {
					$('tr#' + fieldID).find('td:first').html(trFieldName);
					$('tr#' + fieldID).find('td:last').html(currencySymbol + fieldPrice);
					$('tr#' + fieldID).find('td:last').attr('data-addon-price', fieldPrice);
				}
				$('#addon_total #addon_subtotal').before(firstTr);
			} else {
				$('tr#' + fieldID).remove();
			}
			calculateAddonPrice();
		}
	};
	$(
		function () {
			AWS_Front.init();
		}
	);
} )(jQuery);
