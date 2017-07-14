jQuery(document).ready(function($){

	$('input#user_profile_poc').on('click', function(e){
		e.preventDefault();
		var th = $(this);

	    var as_image = wp.media({
	        title: '',
	        // mutiple: true if you want to upload multiple files at once
	        multiple: false
	    }).open()
	    .on('select', function(e){
	        var as_uploaded_image = as_image.state().get('selection').first();

	        var as_image_url = as_uploaded_image.toJSON().url;

	        th.val(as_uploaded_image.id);
	        th.val(as_uploaded_image.id);

	        th.closest('#image_outer').find('.image_previwe').html('<img style="width:250px;" src="'+as_image_url+'" alt="#"><span class="button" onclick="as_social_user_option_image_remove(this)" id="as_image_prev_remove_option">Remove</span>').css('display', 'block');
	    });


	});
});

function as_social_user_option_image_remove(th){
	var main_image = jQuery(th).closest('#image_outer');
	main_image.find('.image_previwe').html('');
	main_image.find('input').val('');
}