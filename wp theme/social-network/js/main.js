jQuery(document).ready(function($){
	var conn = new WebSocket('ws://as-metabox.com:8080');

	var webconnection = false;

	conn.onopen = function(e) {
	    console.log("your online");
	    webconnection = true;

	};

	conn.close = function() {
	    console.log("your offline");
	    webconnection = false;
	};




	$('div[data-selector="user-001"]').on('click', function(){

		var main_body_width = parseInt($('html body').width());
		var chat_box_width = parseInt($('html body .all-chat-box').width());
		var chat_box = $('html body .single-chat-box[data-active="active"]');
		var after_width = main_body_width - chat_box_width;


		var userimage 	= $(this).attr('data-userimage');
		var username 	= $(this).attr('data-username');
		var userid 		= $(this).attr('data-userid');
		var select_id 	= $(this).attr('id');
		var have_box 	= true;

		full_chat_box_open( 
				anu_ajax, 
				$, 
				main_body_width,
				chat_box_width,
				chat_box,
				userimage,
				username,
				userid,
				select_id,
				have_box

				);
			});


$('#close_chat_box').live('click', function(){
	$(this).closest('.single-chat-box[data-active="active"]').remove();
});


$('#chat_submit').live('submit', function(e){
	e.preventDefault();
	var current_user = anu_ajax;
	var btn_input = $(this).find('#btn-input').val();
	var userid = $(this).closest('.single-chat-box[data-active="active"]').attr('data-userid');
	if (webconnection === true) {
		conn.send(JSON.stringify({
			type: 			'chat',
			msg: 			btn_input,
			user_to_id: 	userid
		}));
 	}
	$(this).find('#btn-input').val('');
	var mon_date = Math.floor(Date.now() / 1000);
    $('#uset_'+userid+'_id[data-active="active"] #message_'+userid+'_body ul').append(own_message_html(current_user.my_profile_pic, current_user.my_username, mon_date, btn_input));
 	scroll_to_bottom_chack("message_"+userid+"_body");
});




	conn.onmessage = function(e) {
		var userinfo = anu_ajax;
		var main_data = JSON.parse(e.data);
		var msg_form 	 = parseInt(main_data.msg_form);
		var msg_to 		 = parseInt(main_data.msg_to);
		var msg_to_image = userinfo.content_url+main_data.user_image;
		var get_current_user_id = parseInt(userinfo.get_current_user_id);
		var content_url = userinfo.content_url;

		if (main_data.type == 'chat') {
			var mon_date = Math.floor(Date.now() / 1000);
			if (get_current_user_id == msg_form) {
				var chack_oepn_box = $('#uset_'+msg_to+'_id[data-active="active"] #message_'+msg_to+'_body ul');
				if (chack_oepn_box.length == 1) {
					chack_oepn_box.append(own_message_html(userinfo.my_profile_pic, userinfo.my_username, mon_date, main_data.message));
					scroll_to_bottom_chack("message_"+msg_to+"_body");
				}else{	
					var main_body_width = parseInt($('html body').width());
					var chat_box_width = parseInt($('html body .all-chat-box').width());
					var chat_box = $('html body .single-chat-box[data-active="active"]');

					var userimage 	= userinfo.my_profile_pic;
					var username 	= userinfo.my_username;
					var userid 		= msg_to;
					var select_id 	= 'uset_'+msg_to+'_id';
					var have_box 	= true;

					full_chat_box_open( 
						anu_ajax, 
						$, 
						main_body_width,
						chat_box_width,
						chat_box,
						userimage,
						username,
						userid,
						select_id,
						have_box,
						true,
						false,
						{
							pic: userinfo.my_profile_pic,
							username: userinfo.my_username,
							date: mon_date,
							message:main_data.message
						}
					);
				}
			}else{
				//message for friend


				var chack_oepn_box = $('#uset_'+msg_form+'_id[data-active="active"] #message_'+msg_form+'_body ul');

				if (chack_oepn_box.length == 1) {
					chack_oepn_box.append(others_message_html(
							content_url+main_data.user_image,
							main_data.usemeta_name, 
							mon_date, 
							main_data.message
							));
					scroll_to_bottom_chack("message_"+msg_form+"_body");
				}else{

					var main_body_width = parseInt($('html body').width());
					var chat_box_width = parseInt($('html body .all-chat-box').width());
					var chat_box = $('html body .single-chat-box[data-active="active"]');

					var userimage 	= content_url+main_data.user_image;
					var username 	= main_data.usemeta_name;
					var userid 		= msg_form;
					var select_id 	= 'uset_'+msg_form+'_id';
					var have_box 	= true;

					full_chat_box_open( 
						anu_ajax, 
						$, 
						main_body_width,
						chat_box_width,
						chat_box,
						userimage,
						username,
						userid,
						select_id,
						have_box,
						true,
						true,
						{
							pic: content_url+main_data.user_image,
							username: main_data.usemeta_name,
							date: mon_date,
							message:main_data.message
						}
					);




				}

			}
		}

	};


});