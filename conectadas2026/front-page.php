<?php get_header(); ?>

<?php
// El WP Loop
if ( have_posts() ) : 
  while ( have_posts() ) : the_post();
?>

  <!-- Aquí va tu contenido dinámico o estático -->
  <div class="content">
    <?php the_content(); ?>
  </div>

<?php
  endwhile;
else :
  echo '<p>No hay contenido disponible.</p>';
endif;
?>

<?php get_template_part('template-parts/hero'); ?>
<?php get_template_part('template-parts/portfolio'); ?>
<?php get_template_part('template-parts/about'); ?>
<?php get_template_part('template-parts/impact'); ?>
<?php get_template_part('template-parts/how'); ?>
<?php get_template_part('template-parts/simulator'); ?>
<?php get_template_part('template-parts/contact'); ?>



<?php get_footer(); ?>
