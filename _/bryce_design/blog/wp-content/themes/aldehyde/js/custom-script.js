jQuery( document ).ready( function( $ ) {


	$('.toggle-button').on('click',function(){
		if(!$('body').hasClass('mobile-device')){
			$('body').addClass('mobile-device'); 
			 $('.mobile-nav ul.menu > li > a').each(function(){
	 		     $(this).attr('href', 'javascript:void(0);');
	 		});
		}else if($('body').hasClass('mobile-device')){
			$('body').removeClass('mobile-device'); 
		}
           
	});
	$('.mobile-nav ul.menu > li > a').on('click',function(){
			$(this).parent().toggleClass('show-list'); 
	});
		// add gray area
	$('#menu-header-menu > li.menu-item').hover(function(){
		var menuHeight = $(this).find('.sub-menu').height();
          $('.gray-area').height(menuHeight);
	},function(){
		 $('.gray-area').height(0);
	});
	
	 
	 // check title attribute for special cases
	$('.sub-menu > li > a').each(function(){
           var title = $(this).attr('title');

           if(title !== undefined && title !== 'contact'  && title !== 'submenu-title' && title !== 'terms' ){
           	var extJpg =  title.indexOf('.jpg') > -1;
           	var extPng =  title.indexOf('.png') > -1;
           	if(extPng || extJpg)
           	    
           		$(this).attr('data-img', title);
           		$(this).attr('title','');
           }
         
	});
	  // add cover banner from submenu item
	  $('.sub-menu').append('<div class="cover-banner"><img src="" /></div>');
	$('.sub-menu > li > a').hover(function(){

			if(typeof $(this).attr('data-img') !== "undefined"){
				  
				var img_src = $(this).attr('data-img')
				$(this).parent().parent().find('.cover-banner img').attr('src', img_src);
				$(this).parent().parent().find('.cover-banner img').show();
			}
	}, function(){
		$(this).parent().parent().find('.cover-banner img').hide();
   			$(this).parent().parent().find('.cover-banner img').attr('src', '');
	});
	// terms modal
	$('a[title="terms"]').click(function(){
		var dir = $(this).data('dir');
		if($('#overlay_modal').text().length > 0){
			$('#overlay_modal').remove();
		}
		$.ajax({
			url:  "http://www.coatandtails.com/services/get_t_and_c.php",
			crossDomain: true,
    		 
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
	// contact form
	$('a[title="contact"]').click(function(e){
		e.preventDefault();
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
					url: "http://www.coatandtails.com/services/send_message.php",
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
	
	
} );