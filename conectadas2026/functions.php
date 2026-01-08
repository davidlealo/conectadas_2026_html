<?php
/**
 * Theme functions for Conectadas 2026
 */

/* =========================================================
 * 1. SETUP BÁSICO
 * ========================================================= */

function conectadas2026_theme_setup() {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('html5');
}
add_action('after_setup_theme', 'conectadas2026_theme_setup');

/* =========================================================
 * 2. CARGA DE ESTILOS Y SCRIPTS
 * ========================================================= */

function conectadas2026_enqueue_assets() {

  wp_enqueue_style(
    'conectadas-style',
    get_stylesheet_uri(),
    [],
    wp_get_theme()->get('Version')
  );

  wp_enqueue_style(
    'conectadas-main',
    get_template_directory_uri() . '/assets/css/main.css',
    [],
    '1.0'
  );

  wp_enqueue_script(
    'conectadas-main',
    get_template_directory_uri() . '/assets/js/main.js',
    [],
    '1.0',
    true
  );
}
add_action('wp_enqueue_scripts', 'conectadas2026_enqueue_assets');

/* =========================================================
 * 3. CPT: EMPRENDEDORAS
 * ========================================================= */

function conectadas2026_register_emprendedoras_cpt() {

  register_post_type('emprendedora', [
    'labels' => [
      'name'          => 'Emprendedoras',
      'singular_name' => 'Emprendedora',
    ],
    'public'        => true,
    'has_archive'   => true,
    'rewrite'       => ['slug' => 'emprendedoras'],
    'menu_icon'     => 'dashicons-store',
    'supports'      => ['title', 'editor', 'thumbnail'],
    'show_in_rest'  => true,

    // 👉 CLAVE: usar categorías y tags nativos
    'taxonomies'    => ['category', 'post_tag'],
  ]);
}
add_action('init', 'conectadas2026_register_emprendedoras_cpt');

/* =========================================================
 * 4. HELPER: WHATSAPP
 * ========================================================= */

function conectadas_format_whatsapp($raw) {
  if (!$raw) return '';

  $number = preg_replace('/[^0-9]/', '', $raw);

  if (strlen($number) === 9) {
    $number = '56' . $number;
  }

  return 'https://wa.me/' . $number;
}

/* =========================================================
 * META BOX: REDES SOCIALES EMPRENDEDORA
 * ========================================================= */

function conectadas_emprendedora_meta_box() {
  add_meta_box(
    'conectadas_rrss',
    'Redes sociales',
    'conectadas_emprendedora_meta_box_html',
    'emprendedora',
    'normal',
    'default'
  );
}
add_action('add_meta_boxes', 'conectadas_emprendedora_meta_box');

function conectadas_emprendedora_meta_box_html($post) {

  wp_nonce_field('conectadas_save_rrss', 'conectadas_rrss_nonce');

  $whatsapp  = get_post_meta($post->ID, 'whatsapp', true);
  $instagram = get_post_meta($post->ID, 'instagram', true);
  $facebook  = get_post_meta($post->ID, 'facebook', true);
  ?>

  <p>
    <label><strong>WhatsApp</strong></label><br>
    <input type="text"
           name="whatsapp"
           value="<?php echo esc_attr($whatsapp); ?>"
           placeholder="+56912345678"
           style="width:100%">
  </p>

  <p>
    <label><strong>Instagram</strong></label><br>
    <input type="url"
           name="instagram"
           value="<?php echo esc_attr($instagram); ?>"
           placeholder="https://instagram.com/usuario"
           style="width:100%">
  </p>

  <p>
    <label><strong>Facebook</strong></label><br>
    <input type="url"
           name="facebook"
           value="<?php echo esc_attr($facebook); ?>"
           placeholder="https://facebook.com/pagina"
           style="width:100%">
  </p>

  <?php
}

function conectadas_save_emprendedora_rrss($post_id) {

  if (!isset($_POST['conectadas_rrss_nonce'])) return;
  if (!wp_verify_nonce($_POST['conectadas_rrss_nonce'], 'conectadas_save_rrss')) return;
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
  if (!current_user_can('edit_post', $post_id)) return;

  $fields = ['whatsapp', 'instagram', 'facebook'];

  foreach ($fields as $field) {
    if (isset($_POST[$field])) {
      update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
    }
  }
}
add_action('save_post_emprendedora', 'conectadas_save_emprendedora_rrss');

