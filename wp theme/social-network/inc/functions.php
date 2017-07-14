<?php

function set_login_cookie(){

	if (is_user_logged_in()) {

		if (empty($_COOKIE['user_id']) === true) {
			$set_time =  time() + 86400;
			$set_time =  $set_time * 30;
			setcookie ( 'user_id', get_current_user_id(), $set_time, '/' );
		}
		
	}else{
		setcookie ( 'user_id', 'unset', time() - 86400, '/' );
	}

}
add_action('init', 'set_login_cookie');




function load_theme_all_component(){
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 200, 200, true );
	add_image_size( 'override_gravater', 50, 50, true );

}

add_action( 'after_setup_theme', 'load_theme_all_component' );


function social_get_user_($limit = '', $offset = ''){
	global $wpdb;
	$prifix = $wpdb->prefix;

	$limit 	= (empty($limit) === false) ? (int)$limit : 10 ;
	$offset = (empty($offset) === false) ? (int)$offset : 0 ;

	$returne = null;


	$data = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}users ORDER BY ID ASC LIMIT %d OFFSET %d ", $limit, $offset  ) );
	if (empty($data) === false) {
		$returne = $data;
	}

	return $returne;


}




function my_profile_img( $user_id) {

	$profile_post_id = get_the_author_meta( 'user_profile_poc', $user_id );
	
	$post_thumbnail =  wp_get_attachment_image_src( $profile_post_id, 'override_gravater' );

	if ($profile_post_id) {

		$profile_post_id = (int)$profile_post_id;
		return @$post_thumbnail[0];

	}else{
		$user_email =  get_the_author_meta( 'email', $user_id );
		$user_email = md5($user_email);
		return 'http://1.gravatar.com/avatar/'.$user_email.'?s=40&d=mm&r=g';
	}
	
} //end mt_profile_img


// Apply filter
add_filter( 'get_avatar' , 'social_custom_avatar' , 1 , 5 );

function social_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;

    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        $user = get_user_by( 'email', $id_or_email );	
    }

    if ( $user && is_object( $user ) ) {

			$profile_post_id = get_the_author_meta( 'user_profile_poc', $user->data->ID );
        if ( empty($profile_post_id) === false ) {

			
			$profile_post_id = (int)$profile_post_id;	
			$post_thumbnail =  wp_get_attachment_image_src( $profile_post_id, 'override_gravater' );

            $avatar = $post_thumbnail[0];
            $avatar = "<img alt='{$alt}' src='{$avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
        }

    }

    return $avatar;
}


//echo convertToAgoFormat('1500028626');
//convert timestamp to ago format
function convertToAgoFormat($timestamp){
    $diffBtwCurrentTimeAndTimestamp = time() - $timestamp;
    $periodsString = ["Just Now", "min", "hr", "day", "week", "month", "year", "decade"];
    $periodsNumber = ["60", "60", "24", "7", "4.35", "12", "10"];
    for($iterator = 0; $diffBtwCurrentTimeAndTimestamp >= $periodsNumber[$iterator]; $iterator++)
        $diffBtwCurrentTimeAndTimestamp /= $periodsNumber[$iterator];
    $diffBtwCurrentTimeAndTimestamp = round($diffBtwCurrentTimeAndTimestamp);
 
    if($diffBtwCurrentTimeAndTimestamp != 1) $periodsString[$iterator].="s";
    $output = "$diffBtwCurrentTimeAndTimestamp $periodsString[$iterator]"; //2 days
 
    return $output." ago";
}
 