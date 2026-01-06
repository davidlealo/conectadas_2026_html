<?php
/**
 * Theme functions for Conectadas 2026
 */

/* =========================================================
 * 1. SETUP BÁSICO DEL THEME
 * ========================================================= */

function conectadas2026_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5', [
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
  ]);
}
add_action('after_setup_theme', 'conectadas2026_theme_setup');


/* =========================================================
 * 2. CARGA DE ESTILOS Y SCRIPTS
 * ========================================================= */

function conectadas2026_enqueue_assets() {

  wp_enqueue_style(
    'conectadas2026-style',
    get_stylesheet_uri(),
    [],
    wp_get_theme()->get('Version')
  );

  wp_enqueue_style(
    'conectadas2026-main',
    get_template_directory_uri() . '/assets/css/main.css',
    [],
    '1.0'
  );

  wp_enqueue_script(
    'conectadas2026-main',
    get_template_directory_uri() . '/assets/js/main.js',
    [],
    '1.0',
    true
  );
}
add_action('wp_enqueue_scripts', 'conectadas2026_enqueue_assets');


/* =========================================================
 * 3. CUSTOM POST TYPE: EMPRENDEDORAS
 * ========================================================= */

function conectadas2026_register_emprendedoras_cpt() {

  register_post_type('emprendedora', [
    'labels' => [
      'name'          => 'Emprendedoras',
      'singular_name' => 'Emprendedora',
      'add_new_item'  => 'Agregar emprendedora',
      'edit_item'     => 'Editar emprendedora',
      'menu_name'     => 'Emprendedoras',
    ],
    'public'        => true,
    'has_archive'   => true,
    'rewrite'       => ['slug' => 'emprendedoras'],
    'menu_icon'     => 'dashicons-store',
    'supports'      => ['title', 'editor', 'thumbnail'],
    'show_in_rest'  => true,
  ]);

}
add_action('init', 'conectadas2026_register_emprendedoras_cpt');


/* =========================================================
 * 4. TAXONOMÍA: CATEGORÍA DE EMPRENDIMIENTO
 * ========================================================= */

function conectadas2026_register_categoria_taxonomy() {

  register_taxonomy('categoria_emprendimiento', 'emprendedora', [
    'labels' => [
      'name'          => 'Categorías',
      'singular_name' => 'Categoría',
    ],
    'hierarchical'  => false,
    'public'        => true,
    'show_in_rest'  => true,
  ]);

}
add_action('init', 'conectadas2026_register_categoria_taxonomy');


/* =========================================================
 * 5. TAXONOMÍA: COMUNA
 * ========================================================= */

function conectadas2026_register_comuna_taxonomy() {

  register_taxonomy('comuna', 'emprendedora', [
    'labels' => [
      'name'          => 'Comunas',
      'singular_name' => 'Comuna',
    ],
    'hierarchical'  => false,
    'public'        => true,
    'show_in_rest'  => true,
  ]);

}
add_action('init', 'conectadas2026_register_comuna_taxonomy');


/* =========================================================
 * 6. META FIELDS: RRSS EMPRENDEDORAS (SIN ACF)
 * ========================================================= */

function conectadas_register_emprendedora_meta() {

  register_post_meta('emprendedora', 'whatsapp', [
    'type'              => 'string',
    'single'            => true,
    'sanitize_callback' => 'sanitize_text_field',
    'show_in_rest'      => true,
  ]);

  register_post_meta('emprendedora', 'instagram', [
    'type'              => 'string',
    'single'            => true,
    'sanitize_callback' => 'esc_url_raw',
    'show_in_rest'      => true,
  ]);

  register_post_meta('emprendedora', 'facebook', [
    'type'              => 'string',
    'single'            => true,
    'sanitize_callback' => 'esc_url_raw',
    'show_in_rest'      => true,
  ]);

}
add_action('init', 'conectadas_register_emprendedora_meta');


/* =========================================================
 * 7. HELPER: FORMATEAR WHATSAPP A wa.me
 * ========================================================= */

function conectadas_format_whatsapp($raw) {
  if (!$raw) return '';

  // eliminar espacios, +, paréntesis, guiones
  $number = preg_replace('/[^0-9]/', '', $raw);

  // si es número chileno sin prefijo
  if (strlen($number) === 9) {
    $number = '56' . $number;
  }

  return 'https://wa.me/' . $number;
}

/* =========================================================
 * 8. METABOX: REDES SOCIALES EMPRENDEDORA
 * ========================================================= */

function conectadas_add_rrss_metabox() {
  add_meta_box(
    'conectadas_rrss_metabox',
    'Redes sociales',
    'conectadas_rrss_metabox_html',
    'emprendedora',
    'side',
    'default'
  );
}
add_action('add_meta_boxes', 'conectadas_add_rrss_metabox');


function conectadas_rrss_metabox_html($post) {

  wp_nonce_field('conectadas_save_rrss', 'conectadas_rrss_nonce');

  $whatsapp  = get_post_meta($post->ID, 'whatsapp', true);
  $instagram = get_post_meta($post->ID, 'instagram', true);
  $facebook  = get_post_meta($post->ID, 'facebook', true);
  ?>

  <p>
    <label><strong>WhatsApp</strong></label><br>
    <input
      type="text"
      name="whatsapp"
      value="<?php echo esc_attr($whatsapp); ?>"
      placeholder="+56 9 1234 5678"
      style="width:100%;"
    >
  </p>

  <p>
    <label><strong>Instagram</strong></label><br>
    <input
      type="url"
      name="instagram"
      value="<?php echo esc_attr($instagram); ?>"
      placeholder="https://instagram.com/usuario"
      style="width:100%;"
    >
  </p>

  <p>
    <label><strong>Facebook</strong></label><br>
    <input
      type="url"
      name="facebook"
      value="<?php echo esc_attr($facebook); ?>"
      placeholder="https://facebook.com/usuario"
      style="width:100%;"
    >
  </p>

  <?php
}

function conectadas_save_rrss_metabox($post_id) {

  if (!isset($_POST['conectadas_rrss_nonce'])) return;
  if (!wp_verify_nonce($_POST['conectadas_rrss_nonce'], 'conectadas_save_rrss')) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

  if (isset($_POST['whatsapp'])) {
    update_post_meta($post_id, 'whatsapp', sanitize_text_field($_POST['whatsapp']));
  }

  if (isset($_POST['instagram'])) {
    update_post_meta($post_id, 'instagram', esc_url_raw($_POST['instagram']));
  }

  if (isset($_POST['facebook'])) {
    update_post_meta($post_id, 'facebook', esc_url_raw($_POST['facebook']));
  }
}
add_action('save_post_emprendedora', 'conectadas_save_rrss_metabox');
