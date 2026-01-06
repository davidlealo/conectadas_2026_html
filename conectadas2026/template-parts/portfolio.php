<section id="portafolio">
  <div class="container">

    <div class="section-header">
      <h2>Portafolio de emprendedoras</h2>
      <p class="section-lead">
        Descubre los emprendimientos de mujeres participantes del programa Conectadas 55+.
      </p>
    </div>

    <div class="grid">

      <?php
      $args = [
        'post_type'      => 'emprendedora',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
      ];

      $query = new WP_Query($args);

      if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
      ?>

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
        echo '<p>No hay emprendedoras publicadas aún.</p>';
      endif;
      ?>

    </div>
  </div>
</section>
