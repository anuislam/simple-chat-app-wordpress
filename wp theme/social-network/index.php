<?php get_header(); ?>

  
   <div class="container" style="padding-top: 65px">
       <div class="row">
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-12">
                        <?php get_sidebar(); ?>
                     </div>
                 </div>
            </div>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-12">
                        <?php get_template_part('inc/post-content'); ?>
                     </div>
                 </div>

            </div>  
          
        </div>
    </div>

 <?php get_footer(); ?>