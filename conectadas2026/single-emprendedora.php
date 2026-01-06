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

            <!-- Comuna -->
            <small>
              <?php
              $comunas = get_the_terms(get_the_ID(), 'comuna');
              if ($comunas && !is_wp_error($comunas)) {
                echo esc_html($comunas[0]->name);
              }
              ?>
            </small>

            <!-- Descripción -->
            <div class="profile-description">
              <?php the_content(); ?>
            </div>

            <!-- REDES SOCIALES -->
            <?php
            // Campos ACF
            $whatsapp  = function_exists('get_field') ? get_field('whatsapp') : '';
            $instagram = function_exists('get_field') ? get_field('instagram') : '';
            $facebook  = function_exists('get_field') ? get_field('facebook') : '';

            // Normalizar WhatsApp
            function conectadas_format_whatsapp($raw) {
              if (!$raw) return '';
              $number = preg_replace('/[^0-9]/', '', $raw);
              if (strlen($number) === 9) {
                $number = '56' . $number;
              }
              return 'https://wa.me/' . $number;
            }

            if ($whatsapp || $instagram || $facebook):
            ?>
              <div class="rrss">

                <?php if ($whatsapp): ?>
                  <a href="<?php echo esc_url(conectadas_format_whatsapp($whatsapp)); ?>"
                     target="_blank"
                     aria-label="WhatsApp">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/whatsapp.svg"
                         alt="WhatsApp">
                  </a>
                <?php endif; ?>

                <?php if ($instagram): ?>
                  <a href="<?php echo esc_url($instagram); ?>"
                     target="_blank"
                     aria-label="Instagram">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/instagram.svg"
                         alt="Instagram">
                  </a>
                <?php endif; ?>

                <?php if ($facebook): ?>
                  <a href="<?php echo esc_url($facebook); ?>"
                     target="_blank"
                     aria-label="Facebook">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/facebook.svg"
                         alt="Facebook">
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
