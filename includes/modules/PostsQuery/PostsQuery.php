<?php


class MYEX_PostsQuery extends ET_Builder_Module {
    public $slug       = 'myex_posts_query';
    public $vb_support = 'on';


    public function init() {
        $this->name = esc_html__( 'Posts Query', 'myex-my-extension' );
    }

    public function get_fields() {
        return array(
            'post_type' => array(
                'label'           => esc_html__( 'Post Type', 'myex-my-extension' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Content entered here will appear inside the module.', 'myex-my-extension' ),
                'toggle_slug'     => 'main_content',
            ),
            'post_number' => array(
                'label'           => esc_html__( 'Post Number', 'myex-my-extension' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Content entered here will appear inside the module.', 'myex-my-extension' ),
                'toggle_slug'     => 'main_content',
                'computed_affects'   => array(
                    '__posts',
                ),
                'default' => 5,
            ),
            'posts_rows' => array(
                'label'           => esc_html__( 'Post Row', 'myex-my-extension' ),
                'type'            => 'text',
                'option_category' => 'basic_option',
                'description'     => esc_html__( 'Content entered here will appear inside the module.', 'myex-my-extension' ),
                'toggle_slug'     => 'main_content',
            ),
            '__posts' => array(
                'type' => 'computed',
                'computed_callback' => array('MYEX_PostsQuery','get_blog_posts' ),
                'computed_depends_on' => array(
                    'posts_number',
                ),
                'computed_minimum' => array(
                    'posts_number',
                ),
            ),
        );
    }


    static function get_blog_posts( $args = array() ){
        $defaults = array(
            'post_type'    => 'post',
            'posts_number'     => '',
        );

        $args = wp_parse_args( $args, $defaults );

        $query_args  = array(
            'posts_per_page' => intval($args['post_number'])
        );

        $query = new WP_Query( $query_args );

        ob_start();

        if($query->have_posts()){
            while ($query->have_posts()){
                $query->the_post();

                ?>
                <h1><?php the_title();?></h1>
                <?php
            }
            wp_reset_query();
        }
        wp_reset_postdata();

        $posts = ob_get_contents();

        ob_end_clean();

//        return $posts;

        echo "I am";
    }


    public function render( $attrs, $content = null, $render_slug ) {
        $query_args  = array(
            'posts_per_page' => intval($this->props['post_number']),
            'post_type' => $this->props['post_type']
        );

        $query = new WP_Query( $query_args );

        ob_start();

        if($query->have_posts()){
            while ($query->have_posts()){
                $query->the_post();

                ?>
                <h1><?php the_title();?></h1>
                <?php
            }
            wp_reset_query();
        }
        wp_reset_postdata();

        $posts = ob_get_contents();

        ob_end_clean();

        return $posts;

    }
}
new MYEX_PostsQuery;
