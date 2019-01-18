<?php 
/*
  Template Name: Affiliate
 */
get_header(); 
?>

<div class="container main_content">
    <?php while (have_posts()) : the_post(); ?>
    <div class="ppo_breadcrumb">
        <?php if ( function_exists('yoast_breadcrumb') ) { yoast_breadcrumb('<div class="breadcrumbs">','</div>'); } ?>
    </div>
    <div class="banner_logo mt10 mb30">
        <?php get_template_part('template', 'logo_banner'); ?>
    </div>
    <div class="entry-content">
        <?php the_content();?>
    </div>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>