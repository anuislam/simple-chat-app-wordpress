<?php

function load_load_user_message(){
    if ( is_user_logged_in() ) {
?>

                <ul class="chat">
                
                    <li class="left clearfix"><span class="chat-img pull-left">
                        <img src="http://placehold.it/50/55C1E7/fff&amp;text=U" alt="User Avatar" class="img-circle">
                    </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
                                    <span class="glyphicon glyphicon-time"></span>12 mins ago</small>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                dolor, quis ullamcorper ligula sodales.
                            </p>
                        </div>
                    </li>

                    <li class="right clearfix"><span class="chat-img pull-right">
                        <img src="http://placehold.it/50/FA6F57/fff&amp;text=ME" alt="User Avatar" class="img-circle">
                    </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>13 mins ago</small>
                                <strong class="pull-right primary-font">Bhaumik Patel</strong>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                dolor, quis ullamcorper ligula sodales.
                            </p>
                        </div>
                    </li>
                    <li class="left clearfix"><span class="chat-img pull-left">
                        <img src="http://placehold.it/50/55C1E7/fff&amp;text=U" alt="User Avatar" class="img-circle">
                    </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <strong class="primary-font">Jack Sparrow</strong> <small class="pull-right text-muted">
                                    <span class="glyphicon glyphicon-time"></span>14 mins ago</small>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                dolor, quis ullamcorper ligula sodales.
                            </p>
                        </div>
                    </li>
                    <li class="right clearfix"><span class="chat-img pull-right">
                        <img src="http://placehold.it/50/FA6F57/fff&amp;text=ME" alt="User Avatar" class="img-circle">
                    </span>
                        <div class="chat-body clearfix">
                            <div class="header">
                                <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>15 mins ago</small>
                                <strong class="pull-right primary-font">Bhaumik Patel</strong>
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare
                                dolor, quis ullamcorper ligula sodales.
                            </p>
                        </div>
                    </li>
                </ul>


<?php
}
die();
}

add_action( 'wp_ajax_load_user_message', 'load_load_user_message' );
add_action( 'wp_ajax_nopriv_load_user_message', 'load_load_user_message' );