<p class="lead">Friend list</p>


<?php

 $users = social_get_user_(20, 0);

if ($users) {
	if (is_array($users)) {
		foreach ($users as $user) {
			if (get_current_user_id() != $user->ID) {
                $userimage = my_profile_img( $user->ID );
                    
?>

<div id="uset_<?php echo $user->ID; ?>_id" 
    data-selector="user-001" 
    data-userid="<?php echo $user->ID; ?>"
    data-username="<?php echo $user->display_name; ?>"
    data-userimage="<?php echo $userimage; ?>"

     >
    <div class="table-class user-list">
        <div class="table-cell-class pro-img">
            <div class="profile-image pull-left" href="#" >

<img src="<?php echo $userimage; ?>" alt="profile">
            </div>
        </div>
        <div class="table-cell-class user-list-name">
        	<div class="post-description">
        		<span><?php echo $user->display_name; ?></span>
        	</div>
        </div>
        <div class="table-cell-class user-list-onoffline">
        	<div class="online-offline" style="background-color: #ddd;">
        		<span></span>
        	</div>
        </div>
    </div>
</div>


<?php
			}

		}

	}
}

 ?>