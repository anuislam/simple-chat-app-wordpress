
function full_chat_box_open(
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
	appand = false,
	others,
	appand_data = '',
	){


	var after_width = main_body_width - chat_box_width;

	chat_box.each(function(){
		var box_active_id = $(this).attr('data-userid');
		if (userid == box_active_id) {
			have_box = false;
		}
	});

	if (have_box === true) {
		if (after_width > 380) {
			$('div[data-selector="user-002"]').append(chat_html(userimage, username, userid, select_id));
		}else{
			chat_box.first().remove();
			$('div[data-selector="user-002"]').append(chat_html(userimage, username, userid, select_id));
		}


	    $.ajax({
	        url: anu_ajax.ajaxurl,
	        type: "POST",
	        data: {
	            action: 'load_user_message'
	        },
	        success: function(result){
	        	$('#'+select_id+' .panel-body').html(result);    
	        	$('#'+select_id+' .main_loader_outer').remove();
				if (appand === true) {
						var chack_oepn_box = $('#uset_'+userid+'_id[data-active="active"] #message_'+userid+'_body ul');
					if (others === false) {
						chack_oepn_box.append(own_message_html(appand_data.pic, appand_data.username, appand_data.date, appand_data.message));
					}else{
						chack_oepn_box.append(others_message_html(appand_data.pic, appand_data.username, appand_data.date, appand_data.message));
					}
				}

				scroll_to_bottom_chack("message_"+userid+"_body");
	        }
	    }); 

	}

}






function chat_html(userimage, username, userid, select_id){
	return '<div class="single-chat-box" data-active="active" id="'+select_id+'"'+
		'data-userid="'+userid+'"'+
		'data-username="'+username+'"'+
		'data-userimage="'+userimage+'"'+
	'>'+
		'<div class="main_loader_outer">'+
			'<div class="loader_outer">'+
				'<div class="loader">Loading...</div>'+
			'</div>'+
		'</div>'+
		        '<div class="panel panel-primary" style="margin: 0;">'+
		            '<div class="panel-heading">'+
		                '<span class="glyphicon glyphicon-comment"></span> <a href="javascript:void(0);" style="color:#fff;">'+username+' '+
		                '</a><span class="pull-right" id="close_chat_box"><i class="fa fa-window-close" aria-hidden="true"></i></span>'+            
		            '</div>'+
		            '<div class="panel-body" id="message_'+userid+'_body">'+
		            '</div>'+
		            '<div class="panel-footer">'+
		                '<form action="#" id="chat_submit">'+
			                '<div class="input-group">'+
				                    '<input id="btn-input" type="text" class="form-control input-sm" placeholder="Type your message here...">'+
				                    '<span class="input-group-btn">'+
				                        '<button class="btn btn-warning btn-sm" id="btn-chat">'+
				                            'Send</button>'+
				                    '</span>'+
			                '</div>'+		                
		                '</form>'+
		            '</div>'+
		        '</div>'+
			'</div>';
}


function scroll_to_bottom_chack(id){
	var chatHistory = document.getElementById(id);
	chatHistory.scrollTop = chatHistory.scrollHeight;
}



function get_time_to_agothack(date){
	var date = moment.unix(date);
	return moment(date).fromNow();
}
function get_time_to_ago(date){
	if (get_time_to_agothack(date) == 'a few seconds ago') {
		return 'Just Now';
	}else{
		return get_time_to_agothack(date)
	}
}



function own_message_html(pic, username, time, message){

	var own_message_html = '<li class="right clearfix"><span class="chat-img pull-right">'+
								'<img src="'+pic+'" alt="User Avatar" class="img-circle">'+
								'</span>'+
								'<div class="chat-body clearfix">'+
									'<div class="header">'+
									'<small class=" text-muted"><span class="glyphicon glyphicon-time"></span>'+get_time_to_ago(time)+'</small>'+
									'<strong class="pull-right primary-font">'+username+'</strong>'+
									'</div>'+
								'<p>'+message+
								'</p>'+
								'</div>'+
							'</li>';

	return own_message_html;
}


function others_message_html(pic, username, time, message){

	var others_message_html = '<li class="left clearfix"><span class="chat-img pull-left">'+
                        '<img src="'+pic+'" alt="User Avatar" class="img-circle">'+
                    '</span>'+
                        '<div class="chat-body clearfix">'+
                            '<div class="header">'+
                                '<strong class="primary-font">'+username+'</strong> <small class="pull-right text-muted">'+
                                    '<span class="glyphicon glyphicon-time"></span>'+get_time_to_ago(time)+'</small>'+
                            '</div>'+
                            '<p>'+message+'</p>'+
                        '</div>'+
                    '</li>';

	return others_message_html;
}

