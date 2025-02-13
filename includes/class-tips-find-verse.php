<?php
class Find_Verse_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'find_verse_widget', 
            'Find Verse Widget', 
            array( 'description' => __( 'A widget that displays a shortcode for finding a verse.', 'text_domain' ) ) 
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget']; 
        echo do_shortcode('[tips_find_verse]'); 
        echo $args['after_widget']; 
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}

function find_verse_widget_init() {
    register_widget( 'Find_Verse_Widget' );
}
add_action( 'widgets_init', 'find_verse_widget_init' );

function tips_find_verse_plugin_enqueue() {
    wp_enqueue_style(
        'tips-find-verse-style',
        plugins_url('../build/static/css/main.css', __FILE__),
        array(),
        null
    );

    wp_enqueue_script(
        'tips-find-verse-script',
        plugins_url('../build/static/js/main.js', __FILE__),
        array(),
        null,
        true
    );
    $data = array(
        'color' => get_option('tips_find_verse_color', '#31bbd8'),
        'button_text' => get_option('tips_find_verse_button_text', 'Find verse'),
        'place_holder' => get_option('tips_find_verse_place_order', 'Tips: Find verse')
    );
    wp_localize_script('tips-find-verse-script', 'tipsFindVerseData', $data);
}

add_action('wp_enqueue_scripts', 'tips_find_verse_plugin_enqueue');


function tips_find_verse_shortcode() {
    $unique_id = 'tips-find-verse-' . uniqid();
    return '<div id="' . $unique_id . '"></div>';
}
add_shortcode('tips_find_verse', 'tips_find_verse_shortcode');


