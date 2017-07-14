<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>




<?php wp_head(); ?>

  </head>
  <body>


    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" <?php echo (is_user_logged_in()) ? 'style="margin-top:32px;"' : '' ; ?>>
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav social-nav-menu">
                    <li>
                        <a href="#">Anu islam</a>
                    </li>
                    <li>
                        <a href="#">Home (100)</a>
                    </li>
                    <li>
                        <a href="#" class="font-icon"><i class="fa fa-users" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#" class="font-icon"><i class="fa fa-weixin" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#" class="font-icon"><i class="fa fa-globe" aria-hidden="true"></i></a>
                    </li>
                </ul>
                <a class="profile-image pull-right" href="#" style="margin:5px 0;">
                    <img src="<?php echo site_directory_uri; ?>/img/profile.jpg" alt="profile">
                </a>
            </div>            
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>