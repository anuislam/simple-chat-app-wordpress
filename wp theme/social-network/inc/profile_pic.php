<?php if ( ! defined( 'ABSPATH' ) ) { die('Cannot access pages directly.'); } // Cannot access pages directly.

function as_user_information($user){
?>
<table class="form-table">
<?php

$as_user_option = apply_filters('as_option_init', null);

if ($as_user_option !== null) {
	if (!empty($as_user_option)) {
		if (is_array($as_user_option)) {
			foreach ($as_user_option as $value) {
				as_make_user_mata($value, get_the_author_meta( $value['id'], $user->ID ) );
			}
		}
	}
}
?>


</table>

<?php
}
add_action('show_user_profile', 'as_user_information');
add_action('edit_user_profile', 'as_user_information');

function as_make_user_mata($key, $value){
	$key 	= (array)$key;
?>

	<tr>
		<th scope="row" ><label for="<?php echo @$key['id']; ?>"><?php echo @$key['title']; ?></label></th>
		<td>
		<?php 
			$output_func = 'user_meta_output_func_'.$key['type'];
			$output_func($key, $value);
		?>
			<br />
			<span class="description"><?php echo ($key['description']) ? $key['description'] : '' ; ?></span>
		</td>
	</tr>


<?php
}



function as_user_information_save( $user_id ) {

	$as_user_option = apply_filters('as_option_init', null);


	if ($as_user_option !== null) {
		if (!empty($as_user_option)) {
			if (is_array($as_user_option)) {
				foreach ($as_user_option as $value) {
					if ( current_user_can( 'edit_user', $user_id ) ){
						if (empty($_POST) === false) {

							$var_func = 'as_user_meta_'.$value['type'];
							$var_func($_POST[$value['id']], $value['id'], $user_id);
							//if (empty($_POST[$value['id']]) === false) {
								//$user_data = esc_url($_POST[$value['id']]);
								//update_user_meta( $user_id, $value['id'], $user_data );
							//}
						}
					}
				}
			}
		}
	}

}
add_action( 'personal_options_update', 'as_user_information_save' );
add_action( 'edit_user_profile_update', 'as_user_information_save' );


function user_meta_output_func_upload($key, $value){
	$image = wp_get_attachment_image_src( $value, 'full' );

?>
<div id="image_outer">

<input 
	type="text" 
	name="<?php echo @$key['id']; ?>" 
	id="<?php echo @$key['id']; ?>" 
	value="<?php echo esc_attr( $value ); ?>" 
	class="regular-text ltr" />
	

	<div class="image_previwe">
		<?php

			if ($image) {
				echo '<img src="'.$image[0].'" alt="nothing" style="width:250px;" ><span class="button" onclick="as_social_user_option_image_remove(this)" id="as_image_prev_remove_option">Remove</span>';
			}

		?>
	</div>

</div>

<?php
}

function as_user_meta_upload($value, $key, $user_id){
	if (empty($value) === false) {
		if (is_numeric($value) === true) {
			$value = (int)$value;
			update_user_meta( $user_id, $key, $value );
		}
	}else{
		update_user_meta( $user_id, $key, '' );
	}
}


function as_option_init_func($option){
	$option[] = array(
		'title' 		=> 'Profile pic',
		'id' 			=> 'user_profile_poc',
		'type' 			=> 'upload',
		'description' 	=> 'Upload Your Photo.',
	);


	return $option;
}
add_filter('as_option_init', 'as_option_init_func');