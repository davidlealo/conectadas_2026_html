<?php get_header(); ?>

<main id="single-emprendedora" class="section-alt">
  <div class="container">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

      <article class="profile">

        <div class="profile-inner">

          <!-- Imagen principal -->
          <div class="profile-img">
            <?php if (has_post_thumbnail()) : ?>
              <?php the_post_thumbnail('large'); ?>
            <?php endif; ?>
          </div>

          <!-- Contenido -->
          <div class="profile-content">

            <h3><?php the_title(); ?></h3>

            <small>
              <?php
                $comunas = get_the_terms(get_the_ID(), 'comuna');
                if ($comunas && !is_wp_error($comunas)) {
                  echo 'Comuna: ' . esc_html($comunas[0]->name);
                }
              ?>
            </small>

            <p><?php the_content(); ?></p>

            <div class="rrss">
              <!-- RRSS se agregan después con ACF -->
            </div>

            <a href="<?php echo esc_url(home_url('/#portafolio')); ?>" class="btn secondary">
              ← Volver al portafolio
            </a>

          </div>

        </div>

      </article>

    <?php endwhile; endif; ?>

  </div>
</main>

<?php get_footer(); ?>
