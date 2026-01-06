<section id="portafolio">
  <div class="container">

    <!-- Header sección -->
    <div class="section-header">
      <h2>Portafolio de emprendedoras</h2>
      <p class="section-lead">
        Descubre los emprendimientos de mujeres participantes del programa Conectadas 55+.
      </p>
    </div>

    <!-- FILTROS -->
    <form method="get" class="filters">

      <!-- Filtro Comuna -->
      <select name="comuna">
        <option value="">Todas las comunas</option>
        <?php
        $comunas = get_terms([
          'taxonomy'   => 'comuna',
          'hide_empty' => true,
        ]);

        if (!is_wp_error($comunas)) {
          foreach ($comunas as $comuna) {
            $selected = (isset($_GET['comuna']) && $_GET['comuna'] === $comuna->slug) ? 'selected' : '';
            echo '<option value="' . esc_attr($comuna->slug) . '" ' . $selected . '>' . esc_html($comuna->name) . '</option>';
          }
        }
        ?>
      </select>

      <!-- Filtro Categoría -->
      <select name="categoria">
        <option value="">Todas las categorías</option>
        <?php
        $categorias = get_terms([
          'taxonomy'   => 'categoria_emprendimiento',
          'hide_empty' => true,
        ]);

        if (!is_wp_error($categorias)) {
          foreach ($categorias as $cat) {
            $selected = (isset($_GET['categoria']) && $_GET['categoria'] === $cat->slug) ? 'selected' : '';
            echo '<option value="' . esc_attr($cat->slug) . '" ' . $selected . '>' . esc_html($cat->name) . '</option>';
          }
        }
        ?>
      </select>

      <button type="submit" class="btn secondary">Filtrar</button>

    </form>

    <!-- GRID -->
    <div class="grid">

      <?php
      /* =========================
       * QUERY CON FILTROS
       * ========================= */

      $args = [
        'post_type'      => 'emprendedora',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
      ];

      $tax_query = [];

      if (!empty($_GET['comuna'])) {
        $tax_query[] = [
          'taxonomy' => 'comuna',
          'field'    => 'slug',
          'terms'    => sanitize_text_field($_GET['comuna']),
        ];
      }

      if (!empty($_GET['categoria'])) {
        $tax_query[] = [
          'taxonomy' => 'categoria_emprendimiento',
          'field'    => 'slug',
          'terms'    => sanitize_text_field($_GET['categoria']),
        ];
      }

      if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
      }

      $query = new WP_Query($args);

      if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
      ?>

        <!-- CARD -->
        <a href="<?php the_permalink(); ?>" class="card-link">
          <article class="card">

            <div class="thumb">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium_large'); ?>
              <?php endif; ?>
            </div>

            <div class="card-body">
              <h4><?php the_title(); ?></h4>

              <p>
                <?php echo wp_trim_words(get_the_content(), 22); ?>
              </p>

              <div class="badges">
                <?php
                $comunas = get_the_terms(get_the_ID(), 'comuna');
                if ($comunas && !is_wp_error($comunas)) {
                  foreach ($comunas as $c) {
                    echo '<span>' . esc_html($c->name) . '</span>';
                  }
                }

                $categorias = get_the_terms(get_the_ID(), 'categoria_emprendimiento');
                if ($categorias && !is_wp_error($categorias)) {
                  foreach ($categorias as $cat) {
                    echo '<span>' . esc_html($cat->name) . '</span>';
                  }
                }
                ?>
              </div>
            </div>

          </article>
        </a>

      <?php
        endwhile;
        wp_reset_postdata();
      else :
        echo '<p>No hay emprendedoras publicadas con estos filtros.</p>';
      endif;
      ?>

    </div>
  </div>
</section>
