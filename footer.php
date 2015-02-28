<?php 
// Load saved values in Hermes Theme Options
$hermes_options = hermes_get_global_options(); 
?>

</div><!-- end #container -->

<?php 
wp_footer(); 
wp_reset_query();
?>
<?php if (isset($hermes_options['hermes_script_footer'])) { print(stripslashes($hermes_options['hermes_script_footer'])); } ?>
</body>
</html>