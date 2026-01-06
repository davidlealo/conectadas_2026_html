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

  // CSS principal (style.css)
  wp_enqueue_style(
    'conectadas2026-style',
    get_stylesheet_uri(),
    [],
    wp_get_theme()->get('Version')
  );

  // CSS adicional
  wp_enqueue_style(
    'conectadas2026-main',
    get_template_directory_uri() . '/assets/css/main.css',
    [],
    '1.0'
  );

  // JS principal
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
      'name'               => 'Emprendedoras',
      'singular_name'      => 'Emprendedora',
      'add_new'            => 'Agregar nueva',
      'add_new_item'       => 'Agregar emprendedora',
      'edit_item'          => 'Editar emprendedora',
      'new_item'           => 'Nueva emprendedora',
      'view_item'          => 'Ver emprendedora',
      'search_items'       => 'Buscar emprendedoras',
      'not_found'          => 'No se encontraron emprendedoras',
      'menu_name'          => 'Emprendedoras',
    ],
    'public'              => true,
    'has_archive'         => true,
    'rewrite'             => ['slug' => 'emprendedoras'],
    'menu_icon'           => 'dashicons-store',
    'supports'            => ['title', 'editor', 'thumbnail'],
    'show_in_rest'        => true,
  ]);

}
add_action('init', 'conectadas2026_register_emprendedoras_cpt');


/* =========================================================
 * 4. TAXONOMÍA: CATEGORÍA DE EMPRENDIMIENTO
 * ========================================================= */

function conectadas2026_register_categoria_taxonomy() {

  register_taxonomy('categoria_emprendimiento', 'emprendedora', [
    'labels' => [
      'name'              => 'Categorías',
      'singular_name'     => 'Categoría',
      'search_items'      => 'Buscar categorías',
      'all_items'         => 'Todas las categorías',
      'edit_item'         => 'Editar categoría',
      'add_new_item'      => 'Agregar categoría',
      'menu_name'         => 'Categorías',
    ],
    'hierarchical'       => false,
    'public'             => true,
    'show_in_rest'       => true,
  ]);

}
add_action('init', 'conectadas2026_register_categoria_taxonomy');

/* =========================================================
 * 5. TAXONOMÍA: WhatsApp Formateado
 * ========================================================= */

function conectadas_format_whatsapp($raw) {
  if (!$raw) return '';

  // eliminar espacios, +, guiones, paréntesis
  $number = preg_replace('/[^0-9]/', '', $raw);

  // asegurar prefijo país si no viene
  if (strlen($number) === 9) {
    $number = '56' . $number;
  }

  return 'https://wa.me/' . $number;
}

/* =========================================================
 * 6. TAXONOMÍA: COMUNA
 * ========================================================= */

function conectadas2026_register_comuna_taxonomy() {

  register_taxonomy('comuna', 'emprendedora', [
    'labels' => [
      'name'              => 'Comunas',
      'singular_name'     => 'Comuna',
      'search_items'      => 'Buscar comunas',
      'all_items'         => 'Todas las comunas',
      'edit_item'         => 'Editar comuna',
      'add_new_item'      => 'Agregar comuna',
      'menu_name'         => 'Comunas',
    ],
    'hierarchical'       => false,
    'public'             => true,
    'show_in_rest'       => true,
  ]);

}
add_action('init', 'conectadas2026_register_comuna_taxonomy');
