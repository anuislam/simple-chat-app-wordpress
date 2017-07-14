<?php

	function as_social_site_enqueue_scription(){
		global $wp_scripts;
		wp_enqueue_style( 'as_font_awesome_css', site_directory_uri.'/css/font-awesome.min.css' );
		wp_enqueue_style( 'as_bootstrap_css', site_directory_uri.'/css/bootstrap.min.css' );
		wp_enqueue_style( 'as_style_css', site_directory_uri.'/css/style.css' );



		wp_register_script( 'as_bootstrap_js', site_directory_uri.'/js/bootstrap.min.js', 'jquery', 1.0, true );
		wp_register_script( 'as_nicescroll_js', site_directory_uri.'/js/jquery.nicescroll.min.js', 'jquery', 1.0, true );
		wp_register_script( 'as_moment_js', site_directory_uri.'/js/moment.min.js', 'jquery', 1.0, true );
		wp_register_script( 'as_function_js', site_directory_uri.'/js/functions.js', 'jquery', 1.0, true );
		wp_register_script( 'as_main_js', site_directory_uri.'/js/main.js', 'jquery', 1.0, true );


		wp_register_script( 
			'html5shivone', 
			'https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js', 
			array(), 
			'1.0'
		);
		wp_register_script( 
			'respond', 
			'https://oss.maxcdn.com/respond/1.4.2/respond.min.js', 
			array(), 
			'1.0'
		);
		$wp_scripts->add_data( 'html5shivone', 'conditional', 'lt IE 9' ); // internet explorer
		$wp_scripts->add_data( 'respond', 'conditional', 'lt IE 9' ); // internet explorer
		wp_localize_script( 'as_main_js', 'anu_ajax',
		    array( 
		        'ajaxurl'   		  => admin_url( 'admin-ajax.php' ),
		        'get_current_user_id' => get_current_user_id(),
		        'my_profile_pic'      => my_profile_img( get_current_user_id() ),
		        'my_username'     	  => get_the_author_meta( 'display_name', get_current_user_id() ),
		        'content_url'     	  => content_url().'/uploads/',
		    )
		);
		wp_enqueue_script('jquery');
		wp_enqueue_script('html5shivone');
		wp_enqueue_script('respond');
		wp_enqueue_script('as_bootstrap_js');
		wp_enqueue_script('as_nicescroll_js');
		wp_enqueue_script('as_moment_js');
		wp_enqueue_script('as_function_js');
		wp_enqueue_script('as_main_js');
	}

	add_action('wp_enqueue_scripts','as_social_site_enqueue_scription');




	function as_social_enqueue_scription(){
		wp_register_script( 'as_social_js', site_directory_uri.'/js/admin_js.js', 'jquery', 1.0, true );
		wp_enqueue_media();
		wp_enqueue_script('as_social_js');
	}

	add_action('admin_enqueue_scripts','as_social_enqueue_scription');