( function ($) {
	'use strict';
	$(document).ajaxComplete(
		function () {
			if ($('.epofw_datepicker').length) {
				$('.epofw_datepicker').datepicker({ dateFormat: 'dd-mm-yy' });
			}
			if ($('.epofw_timepicker').length) {
				$('.epofw_timepicker').timepicker(
					{
						timeFormat: 'hh:mm:ss tt'
					}
				);
			}
			if ($('.epofw_colorpicker').length) {
				$('.epofw_colorpicker').wpColorPicker();
			}
		}
	);
	
	function forAllFilter () {
		jQuery('li .epofw_data_condition').each(
			function () {
				var current_condition_val = $(this).val();
				selectFilter('.epofw_condition_data_class_' + current_condition_val, 'epofw_get_data_based_on_cd', current_condition_val);
			}
		);
	}
	
	function cpoAllowSpecialCharacter (str) {
		return str.replace('&#8211;', '–').replace('&gt;', '>').replace('&lt;', '<').replace('&#197;', 'Å');
	}
	
	function selectFilter (filterBasedOnClass, ajaxAction, current_val) {
		jQuery(filterBasedOnClass).each(
			function () {
				jQuery(filterBasedOnClass).select2(
					{
						ajax: {
							url: epofw_var.ajaxurl,
							dataType: 'json',
							delay: 250,
							type: 'post',
							data: function (params) {
								return {
									value: params.term,
									current_condition: current_val,
									action: ajaxAction
								};
							},
							processResults: function (data) {
								var options = [];
								if (data) {
									$.each(
										data,
										function (index, text) {
											options.push({ id: text[0], text: cpoAllowSpecialCharacter(text[1]) });
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
	
	var AWS_ADMIN = {
		init: function () {
			//$( '#price_extra' ).hide();
			$('.accordion_ct_div').hide();
			forAllFilter();
			$('.tips, .help_tip, .woocommerce-help-tip').tipTip(
				{
					'attribute': 'data-tip',
					'fadeIn': 50,
					'fadeOut': 50,
					'delay': 200
				}
			);
			jQuery(document).on('change', '#epofw_type', AWS_ADMIN.changeFieldType);
			jQuery(document).on('click', '#add-new-opt', AWS_ADMIN.cloneOptions);
			jQuery(document).on('click', '#remove-opt', AWS_ADMIN.removeOptions);
			jQuery(document).on('change', '.epofw_data_condition', AWS_ADMIN.getDataBasedOnCondition);
			jQuery(document).on('click', '.add_field_id', AWS_ADMIN.cloneFieldOptions);
			jQuery(document).on('click', '.accordion_cls_title .accordion_a_cls', AWS_ADMIN.accordianACls);
			jQuery(document).on('click', '.accordion_cls_title .accordion_a_cls_remove', AWS_ADMIN.removeAccordian);
			jQuery(document).on('click', '#enable_price_extra input[type="checkbox"]', AWS_ADMIN.enablePrice);
			jQuery(document).on('click', '#enable_title_extra input[type="checkbox"]', AWS_ADMIN.enableTitleExtra);
			jQuery(document).on('click', '#enable_subtitle_extra input[type="checkbox"]', AWS_ADMIN.enableSubTitleExtra);
		},
		enableSubTitleExtra: function () {
			var parentId = $(this).parent().parent().parent().parent().attr('id');
			if (jQuery(this).is(':checked')) {
				jQuery('#' + parentId + ' #subtitle_extra').show();
			} else {
				jQuery('#' + parentId + ' #subtitle_extra').hide();
			}
		},
		enableTitleExtra: function () {
			var parentId = $(this).parent().parent().parent().parent().attr('id');
			if (jQuery(this).is(':checked')) {
				jQuery('#' + parentId + ' #title_extra').show();
			} else {
				jQuery('#' + parentId + ' #title_extra').hide();
			}
		},
		enablePrice: function () {
			var parentId = $(this).parent().parent().parent().parent().attr('id');
			if (jQuery(this).is(':checked')) {
				jQuery('#' + parentId + ' #price_extra').show();
			} else {
				jQuery('#' + parentId + ' #price_extra').hide();
			}
		},
		removeAccordian: function () {
			if (confirm('Are you sure want to delete this field')) {
				$(this).parent().parent().remove();
			}
			return false;
		},
		accordianACls: function () {
			$(this).parent().toggleClass('active');
			$(this).toggleClass('active');
			if ($(this).hasClass('active')) {
				$(this).find('span.dashicons').removeClass('dashicons-arrow-right-alt2').addClass('dashicons-arrow-down-alt2');
			} else {
				$(this).find('span.dashicons').removeClass('dashicons-arrow-down-alt2').addClass('dashicons-arrow-right-alt2');
			}
			$(this).parent().next().slideToggle('fast');
		},
		cloneFieldOptions: function () {
			var li_elem = $(this).parents().find('.accordion_cls:last');
			var li_elem_num = $(this).parents().find('.accordion_cls').length + 1;
			var num = Math.floor(Math.random() * 1000000000);
			//console.log('num' + num);
			var clon_id = li_elem.clone().prop('id', 'accordion_' + num);
			li_elem.after(clon_id);
			clon_id.find('h3.ui-accordion-header').attr('id', 'ui-id-' + num);
			clon_id.find('h3.ui-accordion-header').html('Field ' + num);
			clon_id.find('h3 span.ui-accordion-header-icon').attr('class', 'ui-accordion-header-icon ui-icon ui-icon-triangle-' + num + '-e');
			clon_id.find('div.ui-accordion-content').attr('aria-labelledby', 'ui-id-' + num);
			clon_id.find('.addon_fields').attr('id', 'addon_fields_' + num);
			clon_id.find('.addon_field').attr('id', 'addon_field' + num);
			clon_id.find('.addon_field').attr('data-id', num);
			clon_id.find('.heading_nu_title span').html(li_elem_num);
			var inputsName = clon_id.find('.addon_field .text-class');
			$.each(
				inputsName,
				function (index, elem) {
					var inpElem = $(elem);
					var inpELemName = inpElem.attr('name');
					var newName = inpELemName.replace(/\d+/, num);
					inpElem.attr('name', newName);
				}
			);
			var inputsDefaultVal = clon_id.find('.addon_field .default_num_class');
			$.each(
				inputsDefaultVal,
				function (index, elem) {
					var inpElem = $(elem);
					var inpELemVal = inpElem.val();
					var newName = inpELemVal.replace(/\d+/, Math.floor(Math.random() * 1000000000));
					inpElem.val(newName);
				}
			);
		},
		getDataBasedOnCondition: function () {
			$('.multiselect2').select2('destroy');
			var current_condition_val = $(this).val();
			$(this).parents().find('li .multiselect2').attr('class', 'epofw_condition_data_class_' + current_condition_val + ' epofw_' + current_condition_val + '_condition_data_class multiselect2');
			forAllFilter();
			$(this).parents().find('li .multiselect2').val(null).trigger('change.select2');
		},
		changeFieldType: function () {
			var current_val = $(this).val();
			var parent_id = $(this).parents().parents().parents().parents().attr('data-id');
			var main_parent_id = 'accordion_' + parent_id;
			jQuery.ajax(
				{
					type: 'post',
					url: epofw_var.ajaxurl,
					data: {
						action: 'epofw_change_field_basedon_type',
						current_val: current_val,
						parent_id: parent_id,
					},
					success: function (html) {
						$('#' + main_parent_id + ' .fields_h2').remove('');
						$('#' + main_parent_id + ' .general_field').remove();
						$('#' + main_parent_id + ' #cop_ft_id').after(html);
						if ($('.opt-li').length) {
							var opt_li = parseInt($('.opt-li').length);
							if (opt_li > 1) {
								$('.opt-li:not(:first) .remove-opt-btn').show();
							} else {
								$('.opt-li:first .remove-opt-btn').hide();
							}
						}
						$('#' + main_parent_id + ' #title_extra').hide();
						$('#' + main_parent_id + ' #subtitle_extra').hide();
						$('#' + main_parent_id + ' #price_extra').hide();
					},
					error: function (errormessage) {
					}
				}
			);
		},
		cloneOptions: function () {
			var li_elem = $(this).parent().parent().find('li:last');
			var num = parseInt(li_elem.prop('id').match(/\d+/g), 10) + 1;
			var clon_id = li_elem.clone().prop('id', 'opt-li-' + num);
			var inputs = clon_id.find('input');
			$.each(
				inputs,
				function (index, elem) {
					var inpElem = $(elem);
					inpElem.prop('id', 'select-opt-value-' + num);
				}
			);
			$('.remove-opt-btn').show();
			li_elem.after(clon_id);
			var opt_li = parseInt($('.opt-li').length);
			$('.opt-li:first .remove-opt-btn').hide();
			$('.opt-li:not(:first) .remove-opt-btn').show();
		},
		removeOptions: function () {
			$(this).parent().remove();
		}
	};
	$(
		function () {
			var current_post_id = epofw_var.get_post_id;
			if ($('.addon_fields_accordian_data').length) {
				$('.addon_fields_accordian_data').sortable();
			}
			if ($('.epofw_datepicker').length) {
				$('.epofw_datepicker').datepicker({ dateFormat: 'dd-mm-yy' });
			}
			if ($('.epofw_timepicker').length) {
				$('.epofw_timepicker').timepicker(
					{
						timeFormat: 'hh:mm:ss tt'
					}
				);
			}
			if ($('.epofw_colorpicker').length) {
				$('.epofw_colorpicker').wpColorPicker();
			}
			/*Start - Hide show checkbox*/
			$('.accordion_cls #enable_title_extra input[type="checkbox"]').each(
				function () {
					var parentId = $(this).parent().parent().parent().parent().attr('id');
					var elemId = $(this).parent().parent().parent().attr('id');
					elemId = $.trim(elemId.replace('enable_', ''));
					if ($($(this)).is(':checked')) {
						$('#' + parentId + ' #' + elemId).show();
					} else {
						$('#' + parentId + ' #' + elemId).hide();
					}
				}
			);
			$('.accordion_cls #enable_subtitle_extra input[type="checkbox"]').each(
				function () {
					var parentId = $(this).parent().parent().parent().parent().attr('id');
					var elemId = $(this).parent().parent().parent().attr('id');
					elemId = $.trim(elemId.replace('enable_', ''));
					if ($($(this)).is(':checked')) {
						$('#' + parentId + ' #' + elemId).show();
					} else {
						$('#' + parentId + ' #' + elemId).hide();
					}
				}
			);
			$('.accordion_cls #enable_price_extra input[type="checkbox"]').each(
				function () {
					var parentId = $(this).parent().parent().parent().parent().attr('id');
					var elemId = $(this).parent().parent().parent().attr('id');
					elemId = $.trim(elemId.replace('enable_', ''));
					if ($($(this)).is(':checked')) {
						$('#' + parentId + ' #' + elemId).show();
					} else {
						$('#' + parentId + ' #' + elemId).hide();
					}
				}
			);
			/*Stop - Hide show checkbox*/
			AWS_ADMIN.init();
		}
	);
} )(jQuery);
