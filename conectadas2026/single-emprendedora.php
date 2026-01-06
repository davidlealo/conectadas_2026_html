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

            <h1><?php the_title(); ?></h1>

            <!-- Comuna -->
            <?php
            $comunas = get_the_terms(get_the_ID(), 'comuna');
            if (!empty($comunas) && !is_wp_error($comunas)) :
            ?>
              <small class="comuna">
                <?php echo esc_html($comunas[0]->name); ?>
              </small>
            <?php endif; ?>

            <!-- Descripción -->
            <div class="profile-description">
              <?php the_content(); ?>
            </div>

            <!-- REDES SOCIALES -->
            <?php
            $whatsapp  = get_post_meta(get_the_ID(), 'whatsapp', true);
            $instagram = get_post_meta(get_the_ID(), 'instagram', true);
            $facebook  = get_post_meta(get_the_ID(), 'facebook', true);

            // Normalizar WhatsApp
            if ($whatsapp) {
              $whatsapp = preg_replace('/[^0-9]/', '', $whatsapp);
              if (strlen($whatsapp) === 9) {
                $whatsapp = '56' . $whatsapp;
              }
              $whatsapp = 'https://wa.me/' . $whatsapp;
            }

            if ($whatsapp || $instagram || $facebook) :
            ?>
              <div class="rrss">

                <?php if ($whatsapp) : ?>
                  <a href="<?php echo esc_url($whatsapp); ?>"
                     target="_blank"
                     rel="noopener"
                     aria-label="WhatsApp">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/whatsapp.svg" alt="WhatsApp">
                  </a>
                <?php endif; ?>

                <?php if ($instagram) : ?>
                  <a href="<?php echo esc_url($instagram); ?>"
                     target="_blank"
                     rel="noopener"
                     aria-label="Instagram">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/instagram.svg" alt="Instagram">
                  </a>
                <?php endif; ?>

                <?php if ($facebook) : ?>
                  <a href="<?php echo esc_url($facebook); ?>"
                     target="_blank"
                     rel="noopener"
                     aria-label="Facebook">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/facebook.svg" alt="Facebook">
                  </a>
                <?php endif; ?>

              </div>
            <?php endif; ?>

            <!-- Volver -->
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
