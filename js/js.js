window.log=function(){log.history=log.history||[];log.history.push(arguments);if(this.console){console.log(Array.prototype.slice.call(arguments))}};

var timer, logged_h = 0;

$(document).ready(function(){
	if(document.domain !== '127.0.0.1'){
		setTimeout(function(){
			(function (d, t) {
			  var bh = d.createElement(t), s = d.getElementsByTagName(t)[0];
			  bh.type = 'text/javascript';
			  bh.src = '//www.bugherd.com/sidebarv2.js?apikey=ue1kbm4yfprhszxxbrunvg';
			  s.parentNode.insertBefore(bh, s);
		  })(document, 'script');
		},200);
	}

	var f_page = $('body.f').text();
	var home_page = $('body.main').text();
	var quiz_page = $('body.quiz').text();
	var quiz_res_page = $('body.quiz_res').text();
	var prod_page = $('body.prod').text();
	var photo_draw_page = $('body.photo_draw').text();
	var clothes_page = $('body.clothes').text();
	var collections_page = $('body.collections').text();
	var frame_page = $('body.frame').text();
	var upload_page = $('body.upload').text();
	var cart_page = $('body.cart').text();

	if(f_page.length > 0){
		$('.dropdown-menu>li>a').mouseover(function(){
			if(typeof $(this).attr('data-img') !== "undefined"){
				var img_src = $(this).attr('data-img')
				$('.cover-banner > img', $(this).parent().parent()).attr('src', img_src);
				$('.cover-banner', $(this).parent().parent()).show();
			}
		});
	}
	if((clothes_page.length > 0) && !window.can_leave){
		blockExist();
	}else if((frame_page.length > 0) || (upload_page.length > 0)){
		blockExist();
	}
	if((photo_draw_page.length > 0) || (clothes_page.length > 0) || (frame_page.length > 0) || (upload_page.length > 0)){
		$('#start_over').off('click');
		$('#start_over').on('click', function(){
			removePortraitInfo();
		});
	}
	if(home_page.length > 0){
		// $('#home-carousel').carousel();

		$('.home-carousel-control').click(function(){
			if($(this).hasClass('l')){
				movePrevHomeCar($(this));
			}else if($(this).hasClass('r')){
				moveNextHomeCar($(this));
			}
		});
	}else if(quiz_page.length > 0){
		$('.sliders').slider({
			min: -2,
			max: 2,
			value: 0
		});

		$('.continue').click(function(){
			if(!$('input[name=gender]').is(':checked')){
				alert('Select the gender of your pet.');
				return false;
			}
			if(!$('input[name=animal]').is(':checked')){
				alert('Select the type of animal your pet is.');
				return false;
			}
			document.quiz_form.submit();
		});
	}else if(prod_page.length > 0){
		if(window.variants.length > 1){
			$("#variants").on('change', function() {
				var new_target_variant = $(this).val();
				window.target_variant = parseInt(new_target_variant);

				$('h3.price').html('<span class="currency_sign">$</span>' + window.variants[$('#variants>option:selected').attr('data-i')].price);
			});
		}

		$('.add-to-cart').click(function(){
			if(typeof $('#variants>option:selected').val() !== "undefined"){
				$.ajax({
					type: "POST",
					url: window.init.base_url + "services/add_to_cart.php",
					data: {
						id: $(this).attr('data-id'),
						variant: $('#variants>option:selected').val()
					},
					cache: false,
					success:function(h){
						if(h.result == 'success'){
							if($('#cart_modal').text().length > 0){
								$('#cart_modal').remove();
							}
							var payload = '<div class="modal fade" id="cart_modal" tabindex="-1" role="dialog" aria-hidden="true">'
									+ '<div class="modal-dialog  modal-sm">'
										+ '<div class="modal-content">'
											+ '<div class="modal-header">'
												+ '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
												+ '<h4 class="modal-title">My Cart</h4>'
												+ '<div class="modal-subtitle">Cart Subtotal: $' + h.cart_total + '</div>'
											+ '</div>'
											+ '<div class="modal-body">'
												+ '<div class="row">'
												  + '<div class="col-md-12">'
													  + '<div class="alert alert-success">' + h.title + ' was added to the cart.</div>'
													+ '</div>'
												+ '</div>'
											+ '</div>'
											+ '<div class="modal-footer">'
												+ '<a href="' + window.init.base_url + "cart.php" + '" class="btn btn-primary">Go To Cart</a>'
												+ '<button type="button" class="btn btn-default" data-dismiss="modal">Continue Shopping</button>'
											+ '</div>'
										+ '</div>'
									+ '</div>'
								+ '</div>';
							$('body').append(payload);
							$('#cart_modal').modal('show');
						}else if(h.result == 'error'){
							if(h.error_msg == 'out_of_stock'){
								alert('This item is out of stock.');
							}else if(h.error_msg == 'not_enough_available'){
								alert('There are not enough in stock to add another in your cart.');
							}else{
								alert('An error occurred when attempting to add this item to your cart.');
							}
						}
					}
				});
			}
		});
	}else if(quiz_res_page.length > 0){
		var result_gender = window.target_quiz.substring(0, 1);
		var result_animal = window.target_quiz.substring(1, 2);
		var possessive_genders = {"F":"her", "M":"his"};
		var animals = {"D":"dog", "C":"cat"};
		$('#share_facebook').click(function(){
			window.open("http://www.facebook.com/share.php?u=" + encodeURIComponent(window.init.base_url + 'quiz.php?q=' + window.target_quiz) + "&t=" + encodeURIComponent("If my " + animals[result_animal] + " wore clothes, this would be " + possessive_genders[result_gender] + " outfit. What would yours wear?"));
		});
		$('#share_twitter').click(function(){
			window.open("http://twitter.com/home?status=" + encodeURIComponent("If my " + animals[result_animal] + " wore clothes, this would be " + possessive_genders[result_gender] + " outfit. What would yours wear? ") + encodeURIComponent(window.init.base_url + 'quiz.php?q=' + window.target_quiz));
		});
	}else if(clothes_page.length > 0){
		adjustHeight('clothe');
		$('.clothe-carousel-control').click(function(){
			if($(this).hasClass('l')){
				movePrev($(this));
			}else if($(this).hasClass('r')){
				moveNext($(this));
			}
		});
		$('.continue').click(function(){
			var a = $('#a').val();
			var bg = $('#background').val();
			var pet_name = $('#pet_name').val();
			var label1 = $('#label1').val();
			var label2 = $('#label2').val();
			var label3 = $('#label3').val();
			var label4 = $('#label4').val();

			if(pet_name.length > 0){
				$.ajax({
					type: "POST",
					url: window.init.base_url + "services/add_pet_to_order.php",
					data: {
						a: a,
						bg: bg,
						pet_name: pet_name,
						label1: label1,
						label2: label2,
						label3: label3,
						label4: label4
					},
					cache: false,
					success:function(h){
						if(h.result == 'success'){
							if($('#cart_modal').text().length > 0){
								$('#cart_modal').remove();
							}
							if(h.pet_count == 4){
								window.top.location = window.init.base_url + "frame.php";
							}else{
								var payload = '<div class="modal fade" id="cart_modal" tabindex="-1" role="dialog" aria-hidden="true">'
										+ '<div class="modal-dialog  modal-sm">'
											+ '<div class="modal-content">'
												+ '<div class="modal-header">'
													+ '<h4 class="modal-title">Do you want to add another pet to this portrait?</h4>'
													+ '<small>You can add up to 4.</small>'
												+ '</div>'
												+ '<div class="modal-footer">'
													+ '<a href="' + window.init.base_url + "collections.php" + '" class="btn btn-primary">Yes</a>'
													+ '<a href="' + window.init.base_url + "photo_draw.php" + '" class="btn">Nope, continue</a>'
												+ '</div>'
											+ '</div>'
										+ '</div>'
									+ '</div>';
								$('body').append(payload);
								$('#cart_modal').modal({
									backdrop: 'static',
									keyboard: false
								});
								$('#cart_modal').modal('show');
							}
						}else if(h.result == 'error'){
							if(h.error_msg == 'collection_not_found'){
								alert('This collection was not found.');
							}else if(h.error_msg == 'not_added'){
								alert('You cannot have two pets with the same name.');
							}else{
								alert('An error occurred when attempting to add this item to your cart.');
							}
						}
					}
				});
			}else{
				alert('Provide the pet\'s name.');
			}
		});
	}else if(collections_page.length > 0){
		$('.collections-target').click(function(){
			var id = $(this).data('id');
			$.ajax({
				type: "POST",
				url: window.init.base_url + "services/store_pet.php",
				data: {
					id: id
				},
				cache: false,
				success:function(h){
					if(h.result == 'success'){
						window.top.location = window.init.base_url + "clothes.php?id=" + id;
						// if(h.mode_known){
						// 	window.top.location = window.init.base_url + "clothes.php?id=" + id;
						// }else{
						// 	window.top.location = window.init.base_url + "photo_draw.php";
						// }
					}else if(h.result == 'error'){
						alert('An error occurred when attempting to store your collection preference.');
					}
				}
			});
		});
	}else if(frame_page.length > 0){
		adjustHeight('frame');
		initFrame();
		var items = window.frame_availability.items;
		if(items.length > 1){
			$('.frame-carousel-control').show();
		}
		$('.frame-carousel-control').click(function(){
			if($(this).hasClass('l')){
				movePrevFrame();
			}else if($(this).hasClass('r')){
				moveNextFrame();
			}
		});
		$('.continue').click(function(){
			if(items[window.curr_frame].sizes[window.curr_size].availability > 0){
				$.ajax({
					type: "POST",
					url: window.init.base_url + "services/add_frame_to_order.php",
					data: {
						id: items[window.curr_frame].id,
						size: window.curr_size
					},
					cache: false,
					success:function(h){
						if(h.result == 'success'){
							window.top.location = window.init.base_url + "upload.php";
						}else if(h.result == 'error'){
							if(h.error_msg == 'frame_not_found'){
								alert('This frame was not found.');
							}else if(h.error_msg == 'frame_not_available'){
								alert('The selected frame size is not available in stock.');
							}else{
								alert('An error occurred when attempting to add this frame to your cart.');
							}
						}
					}
				});
			}else{
				alert('The selected frame size is not available in stock.');
			}
		});
	}else if(cart_page.length > 0){
		if(($('#portrait_size_host').html() != null) && ($('#portrait_size_host').html().length > 0)){
			if(!window.cart['size_found']){
				$('#portrait_size_host').show();
			}
			$("#portrait_size").change(function() {
				var target_size = $('option:selected', this).val();
				var i = 0;
				for(i; i < window.cart['items'].length; i++){
					if(window.cart['items'][i]['type'] == 'portrait'){
						var target_price = window.portrait_prices[target_size];
						var new_pirce = parseFloat((target_price + ((target_price * 0.75) * (window.cart['items'][i]['pet_count'] - 1))).toFixed(2));

						window.cart['items'][i]['price'] = new_pirce;
						window.cart['items'][i]['first_pet'] = target_price;
						$('#portrait_0 .price').html('$' + new_pirce);
						break;
					}
				}
				calculateTotal();
			});
		}
		$(".amount").off('change');
		$(".amount").on('change', function() {
			var new_amount = $(this).val();
			var item = $(this).parent().parent().attr('data-item');
			var id = $(this).parent().parent().attr('data-item-id');
			if(new_amount == ''){
				new_amount = 1;
			}
			if(isNaN(new_amount)){
				alert("The amount must be a number.");
				new_amount = 1;
			}else if(new_amount < 1){
				alert("The amount must be a positive number of one or more.");
				new_amount = 1;
			}else{
				new_amount = parseInt(new_amount);
			}

			var i = 0;
			for(i; i < window.cart['items'].length; i++){
				if((window.cart['items'][i]['type'] == item) && (window.cart['items'][i]['id'] == id)){
					if(((window.cart['items'][i]['type'] == 'portrait') || (window.cart['items'][i]['type'] == 'merch')) && (new_amount > window.cart['items'][i]['available'])){
						new_amount = window.cart['items'][i]['available'];
						alert('There are only ' + new_amount + ' available in stock.');
					}else if(((window.cart['items'][i]['type'] == 'frame')) && (new_amount > window.cart['items'][i]['available_' + window.cart['items'][i]['size']])){
						new_amount = window.cart['items'][i]['available_' + window.cart['items'][i]['size']];
						alert('There are only ' + new_amount + ' available in stock in this size.');
					}else{
						window.cart['items'][i]['amount'] = new_amount;
					}
					break;
				}
			}

			$(this).val(new_amount);
			calculateTotal();
		});
		$('a.trash').click(function(){
			var item = $(this).attr('data-item');
			var id = $(this).attr('data-item-id');
			if(((item != "merch") && (item != "frame") && (item != "portrait")) || (typeof id === "undefined")){
				alert('An error occurred when attempting to remove this item from your cart.');
			}else{
				$.ajax({
					type: "POST",
					url: window.init.base_url + "services/remove_from_cart.php",
					data: {
						item: item,
						id: id
					},
					cache: false,
					success:function(h){
						if(h.result == 'success'){
							var i = 0;
							for(i; i < window.cart['items'].length; i++){
								if((window.cart['items'][i]['type'] == item) && (window.cart['items'][i]['id'] == id)){
									window.cart['total'] -= (window.cart['items'][i]['price'] * window.cart['items'][i]['amount']);
									window.cart['items'].splice(i, 1);
									break;
								}
							}
							if(window.cart['items'].length > 0){
								if(($('#portrait_size_host').html() != null) && ($('#portrait_size_host').html().length > 0)){
									var i = 0;
									var frame_found = false;
									for(i; i < window.cart['items'].length; i++){
										if(window.cart['items'][i]['type'] == 'frame'){
											frame_found = true;
											break;
										}
									}
									if(!frame_found){
										$('#portrait_size_host').show();
									}
								}
								calculateTotal();
								$('#' + item + '_' + id).remove();
							}else{
								$('.cart-table-host').html('<div class="alert alert-danger">You do not have any items pending in the cart.</div>');
							}
							console.log('cool');
						}else if(h.result == 'error'){
							if(h.error_msg == 'out_of_stock'){
								alert('This item is out of stock.');
							}else if(h.error_msg == 'not_enough_available'){
								alert('There are not enough in stock to add another in your cart.');
							}else{
								alert('An error occurred when attempting to remove this item from your cart.');
							}
						}
					}
				});
			}
		});
		$('a.checkout').click(function(){
			if(window.cart['items'].length == 0){
				alert('You do not have any items in your cart.');
			}else{
				calculateTotals();
				$('.cart-table-host').hide();
				$('.checkout-table-host').show();
			}
		});

		$('#billing_same_as_shipping').on('change', function(){
			checkShippingBillingAddress();
		});

		$('#pick_up').on('change', function(){
			if($('#pick_up').is(':checked')){
				$('#billing_same_as_shipping').attr('checked', 'checked');
				$('#billing_same_as_shipping_host').hide();
				checkShippingBillingAddress();
			}else{
				$('#billing_same_as_shipping_host').show();
			}
			calculateTotals();
		});

		$('#apply-coupon').click(function(){
			var provided_coupon = $('#coupon').val();
			if(provided_coupon.length > 0){
				$.ajax({
					type: "POST",
					url: window.init.base_url + "services/check_coupon.php",
					data: {
						coupon: provided_coupon
					},
					cache: false,
					success:function(h){
						if(h.result == 'success'){
							window.cart['discount'] = h.data;
						}else if(h.result == 'error'){
							window.cart['discount'] = '';
							if(h.error_msg == 'not_found'){
								alert('This coupon was not found in the system or is no longer available.');
							}else{
								alert('An error occurred when attempting to check the provided coupon.');
							}
						}
						calculateTotals();
					}
				});
			}else{
				alert('Provide a coupon code.');
			}
		});

		$('input[name=payment_method]').on('change', function(){
			$('.cc-info').hide();
			if($('input[name=payment_method]:checked').val() == '1'){
				$('.cc-info').show();
			}
		});
		$('#country').on('change', function(){
			calculateTotals();
		});
		$('a.place-order').click(function(){

			var first_name = $('#first_name').val();
			var last_name = $('#last_name').val();
			var email = $('#email').val();
			var phone = $('#phone').val();
			var address_1 = $('#address_1').val();
			var address_2 = $('#address_2').val();
			var country = $('#country').val();
			var city = $('#city').val();
			var zip_code = $('#zip_code').val();
			var state = $('#state').val();

			var billing_same_as_shipping = $('#billing_same_as_shipping').is(':checked');
			var billing_same_as_shipping_val = 1;
			if(!$('#billing_same_as_shipping').is(':checked')){
				billing_same_as_shipping_val = 0;
			}

			var shipping_first_name = $('#shipping_first_name').val();
			var shipping_last_name = $('#shipping_last_name').val();
			var shipping_phone = $('#shipping_phone').val();
			var shipping_address_1 = $('#shipping_address_1').val();
			var shipping_address_2 = $('#shipping_address_2').val();
			var shipping_country = $('#shipping_country').val();
			var shipping_city = $('#shipping_city').val();
			var shipping_zip_code = $('#shipping_zip_code').val();
			var shipping_state = $('#shipping_state').val();

			var company = $('#shipping_company').val();

			var card_type = $('#card_type').val();
			var payment_method = $('input[name=payment_method]:checked').val();
			var name_on_card = $('#name_on_card').val();
			var cc_num = $('#cc_num').val();
			var ccv_num = $('#ccv_num').val();
			var expiration_m = $('#expiration_m').val();
			var expiration_y = $('#expiration_y').val();


			var pick_up = $('#pick_up').is(':checked');
			var pick_up_val = 1;
			if(!$('#pick_up').is(':checked')){
				pick_up_val = 0;
			}

			var coupon = $('#coupon').val();
			var comment = $('#comment').val();
			var agree_t_c = $('#agree_t_c').is(':checked');

			if(first_name.length == 0){
				alert('Provide your first name.');
				return false;
			}
			if(last_name.length == 0){
				alert('Provide your last name.');
				return false;
			}
			if(email.length == 0){
				alert('Provide your email address.');
				return false;
			}
			if(address_1.length == 0){
				alert('Provide your address.');
				return false;
			}
			if(country.length == 0){
				alert('Select your country.');
				return false;
			}
			if(city.length == 0){
				alert('Provide your city.');
				return false;
			}
			if((state.length == 0) && (country == 'us')){
				alert('Select your state.');
				return false;
			}
			if(!$('#billing_same_as_shipping').is(':checked')){
				if(shipping_first_name.length == 0){
					alert('Provide your shipping first name.');
					return false;
				}
				if(shipping_last_name.length == 0){
					alert('Provide your shipping last name.');
					return false;
				}
				if(shipping_address_1.length == 0){
					alert('Provide your shipping address.');
					return false;
				}
				if(shipping_country.length == 0){
					alert('Select your shipping country.');
					return false;
				}
				if(shipping_city.length == 0){
					alert('Provide your shipping city.');
					return false;
				}
				if((shipping_state.length == 0) && (shipping_country == 'us')){
					alert('Select your shipping state.');
					return false;
				}
			}
			if(payment_method == '1'){
				if(card_type.length == 0){
					alert('Select the type of credit card that will be used.');
					return false;
				}
				if(name_on_card.length == 0){
					alert('Provide the credit card holder\'s name.');
					return false;
				}
				if(cc_num.length == 0){
					alert('Provide the credit card number.');
					return false;
				}
				if(expiration_m.length == 0){
					alert('Select the credit card expiration month.');
					return false;
				}
				if(expiration_y.length == 0){
					alert('Select the credit card expiration year.');
					return false;
				}
			}
			if(!agree_t_c){
				alert('You must read and agree to the terms and conditions.');
				return false;
			}

			if(payment_method == '0'){ // pay via paypal
				window.cart['order_details'] = {
					first_name: first_name,
					last_name: last_name,
					email: email,
					phone: phone,
					address_1: address_1,
					address_2: address_2,
					country: country,
					city: city,
					zip_code: zip_code,
					state: state,
					billing_same_as_shipping: billing_same_as_shipping_val,
					shipping_first_name: shipping_first_name,
					shipping_last_name: shipping_last_name,
					shipping_phone: shipping_phone,
					shipping_address_1: shipping_address_1,
					shipping_address_2: shipping_address_2,
					shipping_country: shipping_country,
					shipping_city: shipping_city,
					shipping_zip_code: shipping_zip_code,
					shipping_state: shipping_state,
					company: company,
					card_type: card_type,
					name_on_card: name_on_card,
					cc_num: cc_num,
					ccv_num: ccv_num,
					expiration_m: expiration_m,
					expiration_y: expiration_y,
					pick_up: pick_up_val,
					comment: comment,
					coupon: coupon
					};

				$.ajax({
					type: "POST",
					url: window.init.base_url + "services/paypal_payment.php",
					data: {
						total: window.cart['total'],
						shipping: window.cart['shipping_total'],
						discount: window.cart['discount_total'],
						d: JSON.stringify(window.cart)
					},
					cache: false,
					success:function(h){
						if(h.result == 'success'){
							$('body').html(h.data);
							document.f.submit();
						}else if(h.result == 'error'){
							alert('An error occurred when handling the payment for the order.');
						}
					}
				});
			}else if(payment_method == '1'){ // pay via cc
				$.ajax({
					type: "POST",
					url: window.init.base_url + "services/cc_payment.php",
					data: {
						total: window.cart['total'],
						shipping: window.cart['shipping_total'],
						discount: window.cart['discount_total'],
						first_name: first_name,
						last_name: last_name,
						email: email,
						phone: phone,
						address_1: address_1,
						address_2: address_2,
						country: country,
						city: city,
						zip_code: zip_code,
						state: state,
						billing_same_as_shipping: billing_same_as_shipping_val,
						shipping_first_name: shipping_first_name,
						shipping_last_name: shipping_last_name,
						shipping_phone: shipping_phone,
						shipping_address_1: shipping_address_1,
						shipping_address_2: shipping_address_2,
						shipping_country: shipping_country,
						shipping_city: shipping_city,
						shipping_zip_code: shipping_zip_code,
						shipping_state: shipping_state,
						company: company,
						card_type: card_type,
						name_on_card: name_on_card,
						cc_num: cc_num,
						ccv_num: ccv_num,
						expiration_m: expiration_m,
						expiration_y: expiration_y,
						pick_up: pick_up_val,
						comment: comment,
						coupon: coupon,
						d: JSON.stringify(window.cart)
					},
					cache: false,
					success:function(h){
						if(h.result == 'success'){
							$('.cart-section>.row').html('<div class="col-sm-12"><div class="alert alert-success">Your order was successfully processed.</div></div>');
						}else if(h.result == 'error'){
							alert('An error occurred when handling the payment for the order. ' + h.error_msg);
							// window.top.location = window.init.base_url;
						}
					}
				});
			}

		});
	}
	$('#contact_link').click(function(){
		var dir = $(this).data('dir');
		if($('#overlay_modal').text().length > 0){
			$('#overlay_modal').remove();
		}
		var payload = '<div class="modal fade contact-modal" id="overlay_modal" tabindex="-1" role="dialog" aria-hidden="true">'
				+ '<div class="modal-dialog">'
					+ '<div class="modal-content">'
						+ '<div class="modal-header">'
							+ '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
							+ '<h4 class="modal-title t_c_title">Send a Message</h4>'
						+ '</div>'
						+ '<div class="modal-body">'
							+ '<form class="form-horizontal" method="POST" role="form">'
								+ '<div class="row">'
									+ '<div class="col-sm-10 col-sm-offset-1">'
										+ '<div class="row">'
											+ '<div class="col-sm-12">'
												+ '<div class="form-group">'
													+ '<label for="message_name" class="col-sm-12 control-label">Name</label>'
													+ '<div class="col-sm-12">'
														+ '<input type="text" id="message_name" name="message_name" class="form-control" size="60" value="">'
													+ '</div>'
												+ '</div>'
											+ '</div>'
											+ '<div class="col-sm-12">'
												+ '<div class="form-group">'
													+ '<label for="message_email" class="col-sm-12 control-label">Email</label>'
													+ '<div class="col-sm-12">'
														+ '<input type="text" id="message_email" name="message_email" class="form-control" size="255" value="">'
													+ '</div>'
												+ '</div>'
											+ '</div>'
											+ '<div class="col-sm-12">'
												+ '<div class="form-group">'
													+ '<label for="message_message" class="col-sm-12 control-label">Message</label>'
													+ '<div class="col-sm-12">'
														+ '<textarea id="message_message" name="message_message" class="form-control" rows="5"></textarea>'
													+ '</div>'
												+ '</div>'
											+ '</div>'
										+ '</div>'
										+ '<div class="row footer-row">'
											+ '<div class="col-sm-3 pull-right">'
												+ '<a href="javascript:void(0);" class="btn btn-lg btn-block btn-inverted btn-negative" id="send_message">Send</a>'
											+ '</div>'
										+ '</div>'
									+ '</div>'
								+ '</div>'
							+ '</form>'
						+ '</div>'
					+ '</div>'
				+ '</div>'
			+ '</div>';
		$('body').append(payload);
		$('#overlay_modal').modal('show');
		$('#send_message').off('click');
		$('#send_message').on('click', function(){
			var message_name = $('#message_name').val();
			var message_email = $('#message_email').val();
			var message_message = $('#message_message').val();
			if(message_name.length == 0){
				alert('Provide your name.');
			}else if(message_email.length == 0){
				alert('Provide your email.');
			}else if(message_message.length == 0){
				alert('Provide a message.');
			}else{
				$.ajax({
					type: "POST",
					url: window.init.base_url + "services/send_message.php",
					data: {
						name: message_name,
						email: message_email,
						message: message_message
					},
					cache: false,
					success:function(h){
						if(h.result == 'success'){
							$('.modal-header').remove();
							$('.modal-body').html('<div class="alert alert-success">The message was successfully sent.</div>');
							setTimeout(function(){
								$('#overlay_modal').modal('hide');
								setTimeout(function(){
									$('#overlay_modal').remove();
									$('.modal-backdrop').remove();
								},1000);
							},4000);
						}else if(h.result == 'error'){
							alert('An error occurred when attempting to send your message.');
						}
					}
				});
			}
		});
	});
	$('.t_c').click(function(){
		var dir = $(this).data('dir');
		if($('#overlay_modal').text().length > 0){
			$('#overlay_modal').remove();
		}
		$.ajax({
			url: window.init.base_url + "services/get_t_and_c.php",
			success:function(h){
				var payload = '<div class="modal fade" id="overlay_modal" tabindex="-1" role="dialog" aria-hidden="true">'
						+ '<div class="modal-dialog modal-sm">'
							+ '<div class="modal-content">'
								+ '<div class="modal-header">'
									+ '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
									+ '<h4 class="modal-title t_c_title">Terms & Conditions</h4>'
								+ '</div>'
								+ '<div class="modal-body">' + h.data + '</div>'
							+ '</div>'
						+ '</div>'
					+ '</div>';
				$('body').append(payload);
				$('#overlay_modal').modal('show');
			}
		});
	});
});

blockExist = function(){
	$('.navbar a[role="menuitem"],#cart_link,.navbar-brand').each(function(){
		var curr_target = $(this).attr('href');
		var curr_id = $(this).attr('id');
		if(curr_id != "contact_link"){
			$(this).off('click');
			$(this).attr('href','javascript:void(0);');
			$(this).on('click', function(){
				var conf = confirm('Are you sure you want to leave this page? If you do, your selections will be removed.');
				if(conf){
					$.ajax({
						url: window.init.base_url + "services/remove_portrait_info.php",
						cache: false,
						success:function(h){
							if(h.result == 'success'){
								window.location.href = curr_target;
							}else if(h.result == 'error'){
								alert('An error occurred when attempting to remove your portrait selections from the system.');
							}
						}
					});
				}
			});
		}
	});
}

removePortraitInfo = function(){
	var conf = confirm('Are you sure you want to start over? If you do, your portrait selections will be removed.');
	if(conf){
		$.ajax({
			url: window.init.base_url + "services/remove_portrait_info.php",
			cache: false,
			success:function(h){
				if(h.result == 'success'){
					window.location.href = window.init.base_url + "collections.php";
				}else if(h.result == 'error'){
					alert('An error occurred when attempting to remove your portrait selections from the system.');
				}
			}
		});
	}
}

checkShippingBillingAddress = function(){
	$('.shipping-control').hide();
	if(!$('#billing_same_as_shipping').is(':checked')){

		$('#shipping_first_name').val($('#first_name').val());
		$('#shipping_last_name').val($('#last_name').val());
		$('#shipping_phone').val($('#phone').val());
		$('#shipping_address_1').val($('#address_1').val());
		$('#shipping_address_2').val($('#address_2').val());
		$('#shipping_country').val($('#country').val());
		$('#shipping_city').val($('#city').val());
		$('#shipping_zip_code').val($('#zip_code').val());
		$('#shipping_state').val($('#state').val());

		$('.shipping-control').show();
	}
}

calculateTotals = function(){
	calculateTotal();
	var target_shipping = $('#country').val();
	if(target_shipping != 'US'){
		target_shipping = 'international';
	}else{
		target_shipping = 'us';
	}
	var applied_to = '';
	var free_shipping = false;
	var perc_discount_on = 0;
	var flat_discount_on = 0;
	var total_discount = 0;
	if(window.cart['discount'] != ''){
		var condition = false;
		if((window.cart['discount']['condition'] == '1') && (window.cart['total'] >= parseFloat(window.cart['discount']['condition_limit']))){ // Must meet minimum purchase
			condition = true;
		}else if(window.cart['discount']['condition'] == '0'){ // if anything is ordered
			condition = true;
		}
		if(condition){
			if(window.cart['discount']['type'] == '0'){ // free shipping
				if(window.cart['discount']['applied_to'] == '1'){ // everything incl. shipping
					free_shipping = true;
				}
			}else if(window.cart['discount']['type'] == '1'){ // percentage discount
				perc_discount_on = parseFloat(window.cart['discount']['discount']);
			}else if(window.cart['discount']['type'] == '2'){ // flat discount
				flat_discount_on = parseFloat(window.cart['discount']['discount']);
			}

			if(window.cart['discount']['applied_to'] == '0'){ // everything excl. shipping
				applied_to = 'all-ship';
			}else if(window.cart['discount']['applied_to'] == '1'){ // everything incl. shipping
				applied_to = 'all+ship';
			}else if(window.cart['discount']['applied_to'] == '2'){ // specific product
				applied_to = window.cart['discount']['applied_to_item_type'] + '_' + window.cart['discount']['applied_to_item_id'];
			}
		}
	}
	var shipping_total = 0;
	var found_frame = false;
	var i = 0;
	for(i; i < window.cart['items'].length; i++){
		window.cart['items'][i]['total'] = (window.cart['items'][i]['price'] * window.cart['items'][i]['amount']);
	}
	var i = 0;
	for(i; i < window.cart['items'].length; i++){
		if(window.cart['items'][i]['type'] == 'frame'){
			found_frame = true;
			item_shipping = (window.shipping_prices[target_shipping][window.cart['items'][i]['size']] * window.cart['items'][i]['amount']);
			if(free_shipping){ // no shipping
				item_shipping = 0;
			}
			shipping_total += item_shipping;
			window.cart['items'][i]['total'] += item_shipping;
		}
	}
	if(!found_frame){
		for(i; i < window.cart['items'].length; i++){
			if(window.cart['items'][i]['type'] == 'portrait'){
				if(window.shipping_prices[target_shipping][window.cart['items'][i]['size']] > shipping_total){
					item_shipping = window.shipping_prices[target_shipping][window.cart['items'][i]['size']];
					if(free_shipping){ // no shipping
						item_shipping = 0;
					}
					shipping_total = item_shipping;
					window.cart['items'][i]['total'] += item_shipping;
				}
			}
		}
		if((shipping_total == 0) && !free_shipping){
			shipping_total = window.shipping_prices[target_shipping]['no_frame'];
		}
	}
	window.cart['pick_up'] = 0;
	if($('#pick_up').is(':checked')){
		shipping_total = 0;
		window.cart['pick_up'] = 1;
	}
	window.cart['shipping_total'] = parseFloat(shipping_total.toFixed(2));
	var taxes_total = (window.cart['total'] * (window.cart['tax_perc'] / 100));
	var grand_total = (window.cart['total'] + window.cart['shipping_total'] + taxes_total);
	if(applied_to == 'all+ship'){ // discount on all including shipping
		if(flat_discount_on != 0){
			if(flat_discount_on >= grand_total){
				grand_total = 0;
			}else{
				grand_total = (grand_total - flat_discount_on);
			}
		}else if(perc_discount_on != 0){
			grand_total = (grand_total - ((grand_total / 100) * perc_discount_on));
		}
	}else if(applied_to == 'all-ship'){ // discount on all including shipping
		if(flat_discount_on != 0){
			if(flat_discount_on >= window.cart['total']){
				window.cart['total'] = 0;
			}else{
				window.cart['total'] = (window.cart['total'] - flat_discount_on);
			}
		}else if(perc_discount_on != 0){
			window.cart['total'] = (window.cart['total'] - ((window.cart['total'] / 100) * perc_discount_on));
		}
		$('.subtotal-host>.subtotal').html('$' + window.cart['total']);
		taxes_total = (window.cart['total'] * (window.cart['tax_perc'] / 100));
		grand_total = (window.cart['total'] + window.cart['shipping_total'] + taxes_total);
	}else{ // discount on a specific item
		if(window.cart['discount']['applied_to_item_type'] == 'frame'){ // discount on a specific frame
			var i = 0;
			for(i; i < window.cart['items'].length; i++){
				if((window.cart['items'][i]['type'] == 'frame') && (window.cart['items'][i]['id'] == window.cart['discount']['applied_to_item_id'])){
					if(flat_discount_on != 0){
						item_price = (window.cart['items'][i]['price'] * window.cart['items'][i]['amount']);
						item_discount = 0
						if(flat_discount_on >= item_price){
							item_discount = item_price;
						}else{
							item_discount = flat_discount_on;
						}
						window.cart['total'] = (window.cart['total'] - item_discount);
					}else if(perc_discount_on != 0){
						item_price = (window.cart['items'][i]['price'] * window.cart['items'][i]['amount']);
						item_discount = (item_price - ((item_price / 100) * perc_discount_on));
						window.cart['total'] = (window.cart['total'] - item_discount);
					}
					break;
				}
			}
		}else if(window.cart['discount']['applied_to_item_type'] == 'clothe'){ // discount on a specific clothe
			var i = 0;
			for(i; i < window.cart['items'].length; i++){
				if((window.cart['items'][i]['type'] == 'clothe') && (window.cart['items'][i]['clothe'] == window.cart['discount']['applied_to_item_id'])){
					if(flat_discount_on != 0){
						item_price = (window.cart['items'][i]['price'] * window.cart['items'][i]['amount']);
						item_discount = 0
						if(flat_discount_on >= item_price){
							item_discount = item_price;
						}else{
							item_discount = flat_discount_on;
						}
						window.cart['total'] = (window.cart['total'] - item_discount);
					}else if(perc_discount_on != 0){
						item_price = (window.cart['items'][i]['price'] * window.cart['items'][i]['amount']);
						item_discount = (item_price - ((item_price / 100) * perc_discount_on));
						window.cart['total'] = (window.cart['total'] - item_discount);
					}
					break;
				}
			}
		}else if(window.cart['discount']['applied_to_item_type'] == 'merchandise'){ // discount on a specific merchandise
			var i = 0;
			for(i; i < window.cart['items'].length; i++){
				if((window.cart['items'][i]['type'] == 'merch') && (window.cart['items'][i]['id'] == window.cart['discount']['applied_to_item_id'])){
					if(flat_discount_on != 0){
						item_price = (window.cart['items'][i]['price'] * window.cart['items'][i]['amount']);
						item_discount = 0
						if(flat_discount_on >= item_price){
							item_discount = item_price;
						}else{
							item_discount = flat_discount_on;
						}
						window.cart['total'] = (window.cart['total'] - item_discount);
					}else if(perc_discount_on != 0){
						item_price = (window.cart['items'][i]['price'] * window.cart['items'][i]['amount']);
						item_discount = (item_price - ((item_price / 100) * perc_discount_on));
						window.cart['total'] = (window.cart['total'] - item_discount);
					}
					break;
				}
			}
		}
		$('.subtotal-host>.subtotal').html('$' + window.cart['total']);
		taxes_total = (Math.round((window.cart['total'] * (window.cart['tax_perc'] / 100)) * 100) / 100);
		grand_total = (Math.round((window.cart['total'] + window.cart['shipping_total'] + taxes_total) * 100) / 100);
	}
	window.cart['pick_up'] = 0;
	if($('#pick_up').is(':checked')){
		shipping_total = 0;
		window.cart['pick_up'] = 1;
	}
	window.cart['shipping_total'] = parseFloat(shipping_total.toFixed(2));
	window.cart['taxes_total'] = parseFloat(taxes_total.toFixed(2));
	window.cart['grand_total'] = parseFloat(grand_total.toFixed(2));
	window.cart['discount_total'] = parseFloat((window.cart['taxes_total'] + window.cart['shipping_total'] + window.cart['total'] - window.cart['grand_total']).toFixed(2));

	$('.shipping-host>.shipping').html('$' + window.cart['shipping_total']);
	$('.tax-host>.tax').html('$' + window.cart['taxes_total']);
	$('.total-host>.total').html('$' + window.cart['grand_total']);
}

calculateTotal = function(){
	var total = 0;
	var i = 0;
	for(i; i < window.cart['items'].length; i++){
		total += (window.cart['items'][i]['price'] * window.cart['items'][i]['amount']);
	}
	window.cart['total'] = parseFloat(total.toFixed(2));
	$('.subtotal-host>.subtotal').html('$' + window.cart['total']);
}

resetFrameThumbs = function(){
	$('.frame-thumb-target').off('click');
	$('.frame-thumb-target').on('click', function(){
		var dir = $(this).data('dir');
		if($('#overlay_modal').text().length > 0){
			$('#overlay_modal').remove();
		}
		var payload = '<div class="modal fade" id="overlay_modal" tabindex="-1" role="dialog" aria-hidden="true">'
				+ '<div class="modal-dialog modal-fullscreen">'
					+ '<div class="modal-content">'
						+ '<div class="modal-header">'
							+ '<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'
							+ '<h4 class="modal-title">Detailed Photo</h4>'
						+ '</div>'
						+ '<div class="modal-body">'
						  + '<img src="' + dir + '">'
						+ '</div>'
					+ '</div>'
				+ '</div>'
			+ '</div>';
		$('body').append(payload);
		$('#overlay_modal').modal('show');
	});
}

adjustHeight = function(t) {
	var h = $('.' + t + '-collage-host').outerHeight(), c = 5;
  if(h > 0) {
    if(t == 'frame'){
    	c = 1;
    }else if(t == 'clothe'){
    	c = parseInt($('.clothe-carousel-control.r').length);
    }
    var h_c = (h/c), h_c_off = h_c;
		$('.' + t + '-carousel-control').css({'height':h_c, 'line-height':h_c + 'px'});
    if(h_c > 54){
    	h_c = 54;
    }
		$('.' + t + '-carousel-control>img').css({'height':h_c, 'margin-top':((h_c_off-h_c)/2) + 'px'});
  }
	setTimeout(function(){
		adjustHeight(t);
	},300);
}

initFrame = function(){
	var items = window.frame_availability.items;
	var curr = window.curr_frame;
	$('.frame-price-desc').html(items[curr].price_desc);

	$('.frame-desc-header, .frame-desc').hide();
	$('.frame-desc').html(items[curr].desc);
	if(items[curr].desc.length > 0){
		$('.frame-desc-header, .frame-desc').show();
	}

	$('.available_sizes').html('');
	$('.available_sizes').hide();
	var available_sizes_payload = '', i = 0, size_options = ['8x10', '11x14', '16x20', '20x24'];
	var size_options_len = size_options.length;
	if(window.frame_availability['mode'] == '0'){
		size_options_len = 2;
	}
	var price = 0, prices = 0;
	var target_size = 0;
	window.curr_size = '';
	for(i; i < size_options_len; i++){
		if(items[curr].sizes[size_options[i]].availability > 0){
			prices++;
			if(price == 0){
				target_size = i;
				window.curr_size = size_options[target_size];
				price = items[curr].sizes[size_options[i]].price;
				$('.frame-price>span').html(price);
			}
			available_sizes_payload += '<option value="' + size_options[i] + '">' + size_options[i] + ' | $' + items[curr].sizes[size_options[i]].price + '</option>';
		}
	}
	if(prices > 1){
		$('.available_sizes').html(available_sizes_payload);
		$('.available_sizes').show();
		$(".available_sizes").change(function() {
			window.curr_size = $('option:selected', this).val();
			$('.available_sizes option[value=' + window.curr_size + ']').attr('selected', 'selected');
			$('.frame-price>span').html(items[curr].sizes[window.curr_size].price);
		});
	}

	$('.frame-thumbs-host>.row').html('');
	$('.frame-thumbs-title').hide();
	if(items[curr].images.length > 0){
		$('.frame-thumbs-title').show();
	}
	var thumb_payload = '', i = 0;
	for(i; i < items[curr].images.length; i++){
		thumb_payload += '<div class="col-md-6">'
				+ '<a href="javascript:void(0);" data-dir="' + items[curr].images[i].dir + '" class="frame-thumb-target">'
					+ '<img src="' + items[curr].images[i].dir + '">'
				+ '</a>'
			+ '</div>';
	}
	$('.frame-thumbs-host>.row').html(thumb_payload);
	$('.def-frame-img').hide();
	$('.def-frame-bg').css({'top':items[curr].top_offset + '%','bottom':items[curr].bottom_offset + '%','left':items[curr].left_offset + '%','right':items[curr].right_offset + '%'});
	if(typeof items[curr].images[0] !== "undefined"){
		$('.def-frame-img').attr('src', items[curr].images[0].dir);
		$('.def-frame-img').show();
	}
	resetFrameThumbs();
}

movePrevFrame = function(){
	var items = window.frame_availability.items;
	if(items.length < 2){
		return false;
	}
	if(window.curr_frame == 0){
		window.curr_frame = (items.length - 1);
	}else{
		window.curr_frame--;
	}
	initFrame();
}

moveNextFrame = function(){
	var items = window.frame_availability.items;
	if(items.length < 2){
		return false;
	}
	if(window.curr_frame == (items.length - 1)){
		window.curr_frame = 0;
	}else{
		window.curr_frame++;
	}
	initFrame();
}

movePrev = function(t){
	var l = 0, i = 0, target = 1, t_class = '';
	if($(t).hasClass('background')){
		t_class = 'background';
	}else if($(t).hasClass('label1')){
		t_class = 'label1';
	}else if($(t).hasClass('label2')){
		t_class = 'label2';
	}else if($(t).hasClass('label3')){
		t_class = 'label3';
	}else if($(t).hasClass('label4')){
		t_class = 'label4';
	}
	l = $('.carousel-inner.' + t_class + ' > .item').length;
	for(i; i < l; i++){
		if($('.carousel-inner.' + t_class + ' > .item:nth-child(' + (i + 1) + ')').hasClass('active')){
			target = i;
			break;
		}
	}
	if(target == 0){
		target = l;
	}
	$('.carousel-inner.' + t_class + ' > .item.active').addClass('left');
	$('.carousel-inner.' + t_class + ' > .item:nth-child(' + target + ')').addClass('next');
	setTimeout(function(){
		$('.carousel-inner.' + t_class + ' > .item:nth-child(' + target + ')').addClass('left');
	},10);
	setTimeout(function(){
		$('.carousel-inner.' + t_class + ' > .item.active').removeClass('left').removeClass('active');
		$('.carousel-inner.' + t_class + ' > .item.next').removeClass('next').removeClass('left').addClass('active');
		$('#' + t_class).val($('.carousel-inner.' + t_class + ' > .active').attr('data-id'));
	},610);
}

moveNext = function(t){
	var l = 0, i = 0, target = 1, t_class = '';
	if($(t).hasClass('background')){
		t_class = 'background';
	}else if($(t).hasClass('label1')){
		t_class = 'label1';
	}else if($(t).hasClass('label2')){
		t_class = 'label2';
	}else if($(t).hasClass('label3')){
		t_class = 'label3';
	}else if($(t).hasClass('label4')){
		t_class = 'label4';
	}
	l = $('.carousel-inner.' + t_class + ' > .item').length;
	for(i; i < l; i++){
		if($('.carousel-inner.' + t_class + ' > .item:nth-child(' + (i + 1) + ')').hasClass('active')){
			target = (i + 2);
			break;
		}
	}
	if(target > l){
		target = 1;
	}
	$('.carousel-inner.' + t_class + ' > .item.active').addClass('right');
	$('.carousel-inner.' + t_class + ' > .item:nth-child(' + target + ')').addClass('prev');
	setTimeout(function(){
		$('.carousel-inner.' + t_class + ' > .item:nth-child(' + target + ')').addClass('right');
	},10);
	setTimeout(function(){
		$('.carousel-inner.' + t_class + ' > .item.active').removeClass('right').removeClass('active');
		$('.carousel-inner.' + t_class + ' > .item.prev').removeClass('prev').removeClass('right').addClass('active');
		$('#' + t_class).val($('.carousel-inner.' + t_class + ' > .active').attr('data-id'));
	},610);
}

movePrevHomeCar = function(t){
	var l = 0, i = 0, target = 1;
	l = $('.carousel-inner > .item').length;
	for(i; i < l; i++){
		if($('.carousel-inner > .item:nth-child(' + (i + 1) + ')').hasClass('active')){
			target = i;
			break;
		}
	}
	if(target == 0){
		target = l;
	}
	$('.carousel-inner > .item.active').addClass('left');
	$('.carousel-inner > .item:nth-child(' + target + ')').addClass('next');
	setTimeout(function(){
		$('.carousel-inner > .item:nth-child(' + target + ')').addClass('left');
	},1);
	setTimeout(function(){
		$('.carousel-inner > .item.active').removeClass('left').removeClass('active');
		$('.carousel-inner > .item.next').removeClass('next').removeClass('left').addClass('active');
	},601);
}

moveNextHomeCar = function(t){
	var l = 0, i = 0, target = 1;
	l = $('.carousel-inner > .item').length;
	for(i; i < l; i++){
		if($('.carousel-inner > .item:nth-child(' + (i + 1) + ')').hasClass('active')){
			target = (i + 2);
			break;
		}
	}
	if(target > l){
		target = 1;
	}
	$('.carousel-inner > .item.active').addClass('right');
	$('.carousel-inner > .item:nth-child(' + target + ')').addClass('prev');
	setTimeout(function(){
		$('.carousel-inner > .item:nth-child(' + target + ')').addClass('right');
	},1);
	setTimeout(function(){
		$('.carousel-inner > .item.active').removeClass('right').removeClass('active');
		$('.carousel-inner > .item.prev').removeClass('prev').removeClass('right').addClass('active');
	},601);
}