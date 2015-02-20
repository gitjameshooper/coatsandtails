$(document).ready(function(){
	var clothes_page = $('body.admin.clothes').text();
	var clothes_add_imgs_page = $('body.admin.clothes.add-imgs').text();
	var clothes_edit_imgs_page = $('body.admin.clothes.edit-imgs').text();
	var frames_page = $('body.admin.frames').text();
	var frames_add_imgs_page = $('body.admin.frames.add-imgs').text();
	var frames_edit_imgs_page = $('body.admin.frames.edit-imgs').text();
	var promo_codes_page = $('body.admin.promo_codes').text();
	var promo_codes_add_page = $('body.admin.promo_codes.add').text();
	var promo_codes_edit_page = $('body.admin.promo_codes.edit').text();
	var merchandise_page = $('body.admin.merchandise').text();
	var merchandise_add_page = $('body.admin.merchandise.add').text();
	var merchandise_edit_page = $('body.admin.merchandise.edit').text();
	var merchandise_add_imgs_page = $('body.admin.merchandise.add-imgs').text();
	var merchandise_edit_imgs_page = $('body.admin.merchandise.edit-imgs').text();

	if(clothes_add_imgs_page.length > 0){
		$('a.append_img_dir').on('click', function(){
			appendImgInputField($(this).attr("data-target"));
		});
	}else if(clothes_edit_imgs_page.length > 0){
		$('a.trash').on('click', function(){
			removeImgInputField(this);
		});
		$('a.append_img_dir').on('click', function(){
			appendImgInputField($(this).attr("data-target"));
		});
	}else if(clothes_page.length > 0){
		$('a.edit').on('click', function(){
			window.top.location = window.init.base_url + "admin/clothes_edit.php?id=" + $(this).parent().parent().attr("data-id");
		});
		$('a.trash').on('click', function(){
			removeClotheEntry($(this).parent().parent().attr("data-id"));
		});
	}else if(frames_add_imgs_page.length > 0){
		$('a.append_img_dir').on('click', function(){
			appendImgInputField($(this).attr("data-target"));
		});
	}else if(frames_edit_imgs_page.length > 0){
		$('a.trash').on('click', function(){
			removeImgInputField(this);
		});
		$('a.append_img_dir').on('click', function(){
			appendImgInputField($(this).attr("data-target"));
		});
	}else if(frames_page.length > 0){
		$('a.edit').on('click', function(){
			window.top.location = window.init.base_url + "admin/frames_edit.php?id=" + $(this).parent().parent().attr("data-id");
		});
		$('a.trash').on('click', function(){
			removeFrameEntry($(this).parent().parent().attr("data-id"));
		});
	}else if((promo_codes_add_page.length > 0) || (promo_codes_edit_page.length > 0)){
		$('input[name=condition]').on('change', function(event, ui){
			$('#condition_limit').removeAttr('disabled');
			if($('input[name=condition]:checked').val() != '1'){
				$('#condition_limit').prop('disabled', true).attr('disabled', true);
			}
		});
		$('input[name=type]').on('change', function(event, ui){
			$('#discount_perc').removeAttr('disabled');
			$('#discount_flat').removeAttr('disabled');
			if($('input[name=type]:checked').val() == '1'){
				$('#discount_flat').prop('disabled', true).attr('disabled', true);
			}else if($('input[name=type]:checked').val() == '2'){
				$('#discount_perc').prop('disabled', true).attr('disabled', true);
			}else{
				$('#discount_perc').prop('disabled', true).attr('disabled', true);
				$('#discount_flat').prop('disabled', true).attr('disabled', true);
			}
		});
		$('input[name=applied_to]').on('change', function(event, ui){
			$('#applied_to_item_search').removeAttr('disabled');
			if($('input[name=applied_to]:checked').val() != '2'){
				$('#applied_to_item_search').prop('disabled', true).attr('disabled', true);
			}
		});
		$('input[name=starting]').on('change', function(event, ui){
			$('#starting_date').removeAttr('disabled');
			if($('input[name=starting]:checked').val() != '1'){
				$('#starting_date').prop('disabled', true).attr('disabled', true);
			}
		});
		$('input[name=ending]').on('change', function(event, ui){
			$('#ending_date').removeAttr('disabled');
			if($('input[name=ending]:checked').val() != '1'){
				$('#ending_date').prop('disabled', true).attr('disabled', true);
			}
		});
		$("#applied_to_item_search").typeahead({
			items: 10,
			source: function (query, process) {
				return $.ajax({
					url: 'services/get_by_title.php',
					type: 'post',
					data: {
						's': encodeURIComponent(query)
					},
					dataType: 'json',
					success: function (result) {
						var resultList = result.map(function(item) {
							var aItem = {
								id: item.id,
								name: item.title,
								type: item.type
							};
							return JSON.stringify(aItem);
						});
						return process(resultList);
					}
				});
			},
			matcher: function (obj) {
				var item = JSON.parse(obj);
				if(!item) return false;
				return ~item.name.toLowerCase().indexOf(this.query.toLowerCase())
			},
			sorter: function (items) {
			 var beginswith = [], caseSensitive = [], caseInsensitive = [], item;
				while (aItem = items.shift()) {
					var item = JSON.parse(aItem);
					if (!item.name.toLowerCase().indexOf(this.query.toLowerCase())) beginswith.push(JSON.stringify(item));
					else if (~item.name.indexOf(this.query)) caseSensitive.push(JSON.stringify(item));
					else caseInsensitive.push(JSON.stringify(item));
				}
				return beginswith.concat(caseSensitive, caseInsensitive)
			},
			highlighter: function (obj) {
				var item = JSON.parse(obj);
				var query = this.query.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, '\\$&')
				return item.name.replace(new RegExp('(' + query + ')', 'ig'), function ($1, match) {
					return '<strong>' + match + '</strong>'
				}) + ' (' + item.type + ')'
			},
			updater: function (obj) {
				var item = JSON.parse(obj);
				$('#applied_to_item').attr('value', item.id);
				$('#applied_to_item_type').attr('value', item.type);
				return item.name + ' (' + item.type + ')';
			}
		});
		$('#starting_date').datepicker().on('changeDate', function(ev){
			var st = $('#ending_date').val();
			var pattern = /(\d{2})\/(\d{2})\/(\d{4})/;
			var endDate = new Date(st.replace(pattern,'$3-$1-$2'));
			if(($('input[name=ending]:checked').val() == '1') && (ev.date.valueOf() > endDate.valueOf())){
				alert('The start date can not be greater then the end date');
			}else{
				startDate = new Date(ev.date);
				$('#startDate').text($('#starting_date').data('date'));
			}
			$('#starting_date').datepicker('hide');
		});
		$('#ending_date').datepicker().on('changeDate', function(ev){
			var st = $('#starting_date').val();
			var pattern = /(\d{2})\/(\d{2})\/(\d{4})/;
			var startDate = new Date(st.replace(pattern,'$3-$1-$2'));
			if(($('input[name=starting]:checked').val() == '1') && (ev.date.valueOf() < startDate.valueOf())){
				alert('The end date can not be less then the start date');
			}else{
				endDate = new Date(ev.date);
				$('#endDate').text($('#ending_date').data('date'));
			}
			$('#ending_date').datepicker('hide');
		});
		$(".twitter-typeahead").addClass('form-control');
	}else if(promo_codes_page.length > 0){
		$('a.edit').on('click', function(){
			window.top.location = window.init.base_url + "admin/promo_codes_edit.php?id=" + $(this).parent().parent().attr("data-id");
		});
		$('a.trash').on('click', function(){
			removePromoCodeEntry($(this).parent().parent().attr("data-id"));
		});
	}else if((merchandise_add_page.length > 0) || (merchandise_edit_page.length > 0)){
		$('a.add_category').on('click', function(){
			$('#category_title').val('');
			$('#save_new_category').on('click', function(){
				var category_title = $('#category_title').val();
				if(category_title.length == 0){
					alert('You can not add a blank category.')
				}else{
					addCategory(category_title);
				}
			});
		});
		$('.variant_entry a.trash').off('click');
		$('.variant_entry a.trash').on('click', function(){
			removeVariant(this);
		});
		$('a.add_variant').on('click', function(){
			restructureVariableIdentifiers();

			var i = $('.variant_entry').length;

			var payload = '<div id="variant_' + i + '" class="row variant_entry">'
					+ '<div class="col-sm-5">'
						+ '<input type="text" id="variable_label_' + i + '" name="variable_label_' + i + '" class="form-control variable_label" placeholder="The label of the variant" size="100" value="">'
					+ '</div>'
					+ '<div class="col-sm-3">'
						+ '<input type="number" id="variable_price_' + i + '" name="variable_price_' + i + '" class="form-control variable_price" placeholder="The price of the variant" size="10" step="0.01" min="0" value="">'
					+ '</div>'
					+ '<div class="col-sm-3">'
						+ '<input type="number" id="variable_availability_' + i + '" name="variable_availability_' + i + '" class="form-control variable_availability" placeholder="The availability of the variant" size="6" step="1" min="0" value="">'
					+ '</div>'
					+ '<div class="col-sm-1">'
						+ '<a href="javascript:void(0);" data-target="variant_' + i + '" class="btn btn-xs btn-default btn-icon trash">'
							+ '<span class="glyphicon glyphicon-trash"></span>'
						+ '</a>'
					+ '</div>'
				+ '</div>';
			$('.variant-host').prepend(payload);
			$('#variant_count').val($('.variant_entry').length);

			$('.variant_entry a.trash').off('click');
			$('.variant_entry a.trash').on('click', function(){
				removeVariant(this);
			});
		});
		$('a.submit').on('click', function(){
			var i = 0, d = $('.variant_entry').length, can_submit = true;
			if(d > 0){
				for(i; i < d; i++){
					var variant_price = $('#variable_price_' + i).val();
					var variant_availability = $('#variable_availability_' + i).val();
					if($('#variable_label_' + i).val().length == 0){
						alert('You need to specify the label of the variant.');
						can_submit = false;
						break;
					}else if(variant_price.length == 0){
						alert('You need to specify the price of the variant.');
						can_submit = false;
						break;
					}else if(isNaN(variant_price)){
						alert('The price of the variant must be a number.');
						can_submit = false;
						break;
					}else if(parseFloat(variant_price) <= 0){
						alert('The price of the variant must be a positive number.');
						can_submit = false;
						break;
					}else if(variant_availability.length == 0){
						alert('You need to specify the availability of the variant.');
						can_submit = false;
						break;
					}else if(isNaN(variant_availability)){
						alert('The availability of the variant must be a number.');
						can_submit = false;
						break;
					}else if(parseInt(variant_availability) <= 0){
						alert('The availability of the variant must be a positive number.');
						can_submit = false;
						break;
					}
				}
			}
			if(can_submit){
				document.merchandise_form.submit();
			}else{
				return false;
			}
		});
	}else if(merchandise_add_imgs_page.length > 0){
		$('a.append_img_dir').on('click', function(){
			appendImgInputField($(this).attr("data-target"));
		});
	}else if(merchandise_edit_imgs_page.length > 0){
		$('a.trash').on('click', function(){
			removeImgInputField(this);
		});
		$('a.append_img_dir').on('click', function(){
			appendImgInputField($(this).attr("data-target"));
		});
	}else if(merchandise_page.length > 0){
		$('a.edit').on('click', function(){
			window.top.location = window.init.base_url + "admin/merchandise_edit.php?id=" + $(this).parent().parent().attr("data-id");
		});
		$('a.trash').on('click', function(){
			removeMerchEntry($(this).parent().parent().attr("data-id"));
		});
	}
});

removeVariant = function(t){
	var v = $('input.variable_id', $(t).parent()).val();
	if(typeof v !== "undefined"){
		var req = confirm("Are you sure you want to delete this variant? Note that deletion will permanently remove this variant entry.");
		if(req){
			$.ajax({
				type:"POST",
				url:window.init.base_url + "admin/services/delete_variant.php",
				data:{
					id: v
				},
				cache:false
			});
			$(t).parent().parent().remove();
			$('#variant_count').val($('.variant_entry').length);
			restructureVariableIdentifiers();
		}
	}else{
		$(t).parent().parent().remove();
		$('#variant_count').val($('.variant_entry').length);
		restructureVariableIdentifiers();
	}
}

restructureVariableIdentifiers = function(){
	$('.variant_entry').each(function(i){
		$(this).attr('id', 'variant_' + i);
		$('.variable_label', this).attr('name', 'variable_label_' + i).attr('id', 'variable_label_' + i);
		$('.variable_price', this).attr('name', 'variable_price_' + i).attr('id', 'variable_price_' + i);
		$('.variable_availability', this).attr('name', 'variable_availability_' + i).attr('id', 'variable_availability_' + i);
		$('.trash', this).attr('data-target', 'variant_' + i);
		if(typeof $('.variable_id', this).val() !== "undefined"){
			$('.variable_id', this).attr('name', 'variable_id_' + i);
		}
	});
}

addCategory = function(title){
	$.ajax({
		type:"POST",
		url:window.init.base_url + "admin/services/add_category.php",
		data:{
			title: title
		},
		cache:false,
		success:function(h){
			if(h.result == 'success'){
				$('#add_category').modal('hide');
				$('#category').append('<option value="' + h.id + '">' + title + '</option>');
			}else if(h.result == 'error'){
				if(h.error_msg == 'not_logged'){
					window.location.reload();
				}else if(h.error_msg == 'found'){
					alert('This category already exists in the system.');
				}else{
					alert('An error occurred when adding this category to the system.');
				}
			}
		}
	});
}

extractor = function(query) {
	var result = /([^,]+)$/.exec(query);
	if(result && result[1])
		return result[1].trim();
	return '';
}

appendImgInputField = function(target){
	if(typeof target === "undefined"){
		target = '';
	}
	var frames_add_imgs_page = $('body.admin.frames.add-imgs').text();
	var frames_edit_imgs_page = $('body.admin.frames.edit-imgs').text();

	target_len = 0;

	if(target != ''){
		target_class_len = target.length
		target_last_instant = parseInt($("." + target).last().attr('id').substring(target_class_len + 1));
		payload = '<div class="col-sm-2" id="' + target + '_' + (target_last_instant + 1) + '_pusher"></div>'
			+ '<div class="col-sm-9">'
				+ '<input type="text" id="' + target + '_' + (target_last_instant + 1) + '" name="' + target + '_' + (target_last_instant + 1) + '" class="form-control ' + target + '" placeholder="The image directory url. E.g.: http://www.coatandtails.com/imgs/';

		if((frames_add_imgs_page.length > 0) || (frames_edit_imgs_page.length > 0)){
			payload += 'frames';
		}else{
			payload += 'clothes/dogs';
		}
		payload += '/132845469/" size="255" value="">'
			+ '</div>';
		payload_trash_1 = '<div class="col-sm-1">'
				+ '<a href="javascript:void(0);" data-target="';
		payload_trash_2 = '" class="btn btn-xs btn-default btn-icon trash">'
					+ '<span class="glyphicon glyphicon-trash"></span>'
				+ '</a>'
			+ '</div>';

		target_to_be_modified = $('.col-sm-10', $("." + target).parent().parent());
		if(target_to_be_modified.length == 1){
			$(target_to_be_modified).addClass('col-sm-9').removeClass('col-sm-10');
			$(target_to_be_modified).parent().append(payload_trash_1 + $('input', target_to_be_modified).attr('id') + payload_trash_2);
		}

		$("." + target).parent().parent().append(payload + payload_trash_1 + target + '_' + (target_last_instant + 1) + payload_trash_2);
		var p = [];
		$('.' + target).each(function(i){
			p.push($(this).attr('id'));
		});
		$("." + target + '_len').val(p.join());

		target_len = $.find('.' + target).length;
		if((target_len > 5) && ((frames_add_imgs_page.length > 0) || (frames_edit_imgs_page.length > 0))){
			$('.append_img_dir').parent().parent().hide();
		}

		$('a.trash').off('click');
		$('a.trash').on('click', function(){
			removeImgInputField(this);
		});
	}
}

removeImgInputField = function(target){
	t = $(target).attr("data-target");
	var frames_add_imgs_page = $('body.admin.frames.add-imgs').text();
	var frames_edit_imgs_page = $('body.admin.frames.edit-imgs').text();
	$(target).parent().remove();
	$("#" + t).parent().remove();
	$("#" + t + '_pusher').remove();
	var p = [];
	$('.' + t.substring(0, (t.length - 2))).each(function(i){
		console.log($(this));
		p.push($(this).attr('id'));
	});
	$("." + t.substring(0, (t.length - 2)) + '_len').val(p.join());
	if($.find('.' + t.substring(0, (t.length - 2))).length == 1){
		t_parent = $('.' + t.substring(0, (t.length - 2))).parent().parent();
		$('.col-sm-1', $(t_parent)).remove();
		$('.col-sm-9', $(t_parent)).addClass('col-sm-10').removeClass('col-sm-9');
	}
	if((frames_add_imgs_page.length > 0) || (frames_edit_imgs_page.length > 0)){
		$('.append_img_dir').parent().parent().show();
	}
}

removeClotheEntry = function(id){
	var req = confirm("Are you sure you want to delete this entry? Note that deletion will permanently remove the related image directory references, promotional codes and (if unique to this entry) the associations collection.");
	if(req){
		$.ajax({
			type:"POST",
			url:window.init.base_url + "admin/services/delete_clothe_entry.php",
			data:{
				id: id
			},
			cache:false,
			success:function(h){
				if(h.result == 'success'){
					window.location.reload();
				}else if(h.result == 'error'){
					if(h.error_msg == 'not_logged'){
						window.location.reload();
					}else if(h.error_msg == 'not_found'){
						window.location.reload();
					}else{
						alert('An error occurred when deleting this entry.');
					}
				}
			}
		});
	}
}

removeFrameEntry = function(id){
	var req = confirm("Are you sure you want to delete this entry? Note that deletion will permanently remove the related image directory references and promotional codes.");
	if(req){
		$.ajax({
			type:"POST",
			url:window.init.base_url + "admin/services/delete_frame_entry.php",
			data:{
				id: id
			},
			cache:false,
			success:function(h){
				if(h.result == 'success'){
					window.location.reload();
				}else if(h.result == 'error'){
					if(h.error_msg == 'not_logged'){
						window.location.reload();
					}else if(h.error_msg == 'not_found'){
						window.location.reload();
					}else{
						alert('An error occurred when deleting this entry.');
					}
				}
			}
		});
	}
}

removePromoCodeEntry = function(id){
	var req = confirm("Are you sure you want to delete this entry?");
	if(req){
		$.ajax({
			type:"POST",
			url:window.init.base_url + "admin/services/delete_promo_code_entry.php",
			data:{
				id: id
			},
			cache:false,
			success:function(h){
				if(h.result == 'success'){
					window.location.reload();
				}else if(h.result == 'error'){
					if(h.error_msg == 'not_logged'){
						window.location.reload();
					}else if(h.error_msg == 'not_found'){
						window.location.reload();
					}else{
						alert('An error occurred when deleting this entry.');
					}
				}
			}
		});
	}
}

removeMerchEntry = function(id){
	var req = confirm("Are you sure you want to delete this entry? Note that deletion will permanently remove the related image directory references and promotional codes.");
	if(req){
		$.ajax({
			type:"POST",
			url:window.init.base_url + "admin/services/delete_merch_entry.php",
			data:{
				id: id
			},
			cache:false,
			success:function(h){
				if(h.result == 'success'){
					window.location.reload();
				}else if(h.result == 'error'){
					if(h.error_msg == 'not_logged'){
						window.location.reload();
					}else if(h.error_msg == 'not_found'){
						window.location.reload();
					}else{
						alert('An error occurred when deleting this entry.');
					}
				}
			}
		});
	}
}