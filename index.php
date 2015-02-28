<?php get_header(); ?>

<?php 
// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 
?>

<?php get_template_part('slideshow','home'); ?>

<?php get_footer(); ?>