<section id="portafolio">
  <div class="container">

    <div class="section-header">
      <h2>Portafolio de emprendedoras</h2>
      <p class="section-lead">
        Descubre los emprendimientos de mujeres participantes del programa Conectadas 55+.
      </p>
    </div>

    <?php
    $comunas = get_categories([
      'taxonomy'   => 'category',
      'hide_empty' => false,
    ]);

    $tags = get_tags([
      'hide_empty' => false,
    ]);
    ?>

    <!-- FILTROS -->
    <div class="filters">
      <select id="filterComuna">
        <option value="">Todas las comunas</option>
        <?php foreach ($comunas as $c): ?>
          <option value="<?php echo esc_attr($c->name); ?>">
            <?php echo esc_html($c->name); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <select id="filterCategoria">
        <option value="">Todos los rubros</option>
        <?php foreach ($tags as $t): ?>
          <option value="<?php echo esc_attr($t->name); ?>">
            <?php echo esc_html($t->name); ?>
          </option>
        <?php endforeach; ?>
      </select>

      <select id="filterOrden">
        <option value="az">Orden A–Z</option>
        <option value="za">Orden Z–A</option>
      </select>

      <span style="margin-left:auto">
        Mostrando <strong id="resultsCount">0</strong>
      </span>
    </div>

    <div class="grid" id="portfolioGrid">

      <?php
      $q = new WP_Query([
        'post_type' => 'emprendedora',
        'posts_per_page' => -1,
        'orderby' => 'title',
        'order' => 'ASC',
      ]);

      while ($q->have_posts()) : $q->the_post();

        $cats = get_the_category();
        $tags = get_the_tags();

        $cat_names = array_map(fn($c) => $c->name, $cats ?: []);
        $tag_names = array_map(fn($t) => $t->name, $tags ?: []);
      ?>

        <a
          class="card"
          href="<?php the_permalink(); ?>"
          data-comuna="<?php echo esc_attr(implode('|', $cat_names)); ?>"
          data-categoria="<?php echo esc_attr(implode('|', $tag_names)); ?>"
          data-title="<?php echo esc_attr(strtolower(get_the_title())); ?>"
        >
          <div class="thumb">
            <?php the_post_thumbnail('medium_large'); ?>
          </div>

          <div class="card-body">
            <h4><?php the_title(); ?></h4>
            <p><?php echo wp_trim_words(strip_tags(get_the_content()), 18); ?></p>

            <div class="badges">
              <?php foreach ($cat_names as $c): ?><span><?php echo esc_html($c); ?></span><?php endforeach; ?>
              <?php foreach ($tag_names as $t): ?><span><?php echo esc_html($t); ?></span><?php endforeach; ?>
            </div>
          </div>
        </a>

      <?php endwhile; wp_reset_postdata(); ?>

    </div>
  </div>
</section>
