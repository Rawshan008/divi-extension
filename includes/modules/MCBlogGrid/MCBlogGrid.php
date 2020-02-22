<?php

class MC_BlogGrid extends ET_Builder_Module {

    public $slug       = 'mdvcm_blog_grid';
    public $vb_support = 'on';

    protected $module_credits = array(
        'module_uri' => '',
        'author'     => 'Marie Comet',
        'author_uri' => 'https://mariecomet.fr',
    );

    public function init() {
        $this->name = esc_html__( 'Blog Grid', 'mdvcm-mc-divi-vb-custom-modules' );
        // à retirer en prod
        $debug_module = true;

        if (is_admin()) {
            // Clear module from cache if necessary
            if ($debug_module) { 
                add_action('admin_head', array( $this, 'remove_from_local_storage' ) );
            }
        }
        // à retirer en prod
    }

    public $debug_module = true;
                        
        public function remove_from_local_storage() {
            global $debug_module; 
            echo "<script>localStorage.removeItem('et_pb_templates_".esc_attr($this->slug)."');</script>";
        }


    public function get_fields() {
        return array(
            'posts_type' => array(
                'label'             => esc_html__( 'Post Type', 'mdcm-mc-divi-custom-modules-react' ),
                'type'              => 'select',
                'options' => array(
                    'post' => __('Post', 'one'),
                    'page' => __('Page', 'one')
                ),
                'description'       => esc_html__( 'Choose how much posts you would like to display per page.', 'mdcm-mc-divi-custom-modules-react' ),
                'computed_affects'   => array(
                    '__posts',
                ),
                'toggle_slug'       => 'main_content',
                'default'           => 'post',
            ),
            '__posts' => array(
                'type' => 'computed',
                'computed_callback' => array( 'MC_BlogGrid', 'get_blog_posts' ),
                'computed_depends_on' => array(
                    'posts_type',
                ),
                'computed_minimum' => array(
                    'posts_type',
                ),
            ),
        );
    }

    /**
     * Get blog posts for blog module
     *
     * @param array   arguments that is being used by et_pb_custom_blog
     * @return string blog post markup
     */
    static function get_blog_posts( $args = array(), $current_page = array() ) {

        $defaults = array(
            'post_type'                  => '',
        );

        $args = wp_parse_args( $args, $defaults );
        
        $query_args = array(
            'post_type' => $args['posts_type'],
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );


        // Get query
        $query = new WP_Query( $query_args );




        ob_start();
        echo '
            <script>
                jQuery(document).ready(function($) {
                  $(\'.all-posts\').slick({
                    infinite: true,
                    rows: 2,
                    slidesPerRow: 4,
                    arrows: true,
                    prevArrow: $(\'.prev\'),
                    nextArrow: $(\'.next\'),
                });
                })
            
            </script>
        ';

        echo '<div class="all-posts">';

        if ( $query->have_posts() ) {


            while( $query->have_posts() ) {
                $query->the_post();
                global $et_fb_processing_shortcode_object;

                $post_id = get_the_ID();
                $global_processing_original_value = $et_fb_processing_shortcode_object;

                // reset the fb processing flag
                $et_fb_processing_shortcode_object = false;

                ?>
                <article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
                    <figure>
                    <h1><?php the_title();?></h1>
                  </figure>
                </article>
                <?php

                $et_fb_processing_shortcode_object = $global_processing_original_value;

            } // endwhile


            wp_reset_query();
        }

        wp_reset_postdata();

        echo '</div>';

        $posts = ob_get_contents();

        ob_end_clean();

        return $posts;
    }

    public function render( $attrs, $content = null, $render_slug ) {
        
        $query_args = array(
            'post_type' => $this->props['posts_type'],
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );


        // Get query
        $query = new WP_Query( $query_args );

        ob_start();

        echo '
            <script>
                jQuery(document).ready(function($) {
                  $(\'.all-posts\').slick({
                    infinite: true,
                    rows: 2,
                    slidesPerRow: 3,
                    arrows: true,
                    prevArrow: $(\'.prev\'),
                    nextArrow: $(\'.next\'),
                });
                })
            
            </script>
        ';

        echo '<div class="all-posts">';

        if ( $query->have_posts() ) {


            while( $query->have_posts() ) {
                $query->the_post();
                global $et_fb_processing_shortcode_object;

                $post_id = get_the_ID();
                $global_processing_original_value = $et_fb_processing_shortcode_object;


                // reset the fb processing flag
                $et_fb_processing_shortcode_object = false;


                ?>
                <article id="post-<?php echo $post_id; ?>" <?php post_class(); ?>>
                    <figure>
                   <h1><?php the_title();?></h1>
                  </figure>
                </article>
                <?php

                $et_fb_processing_shortcode_object = $global_processing_original_value;

            } // endwhile


            wp_reset_query();
        }

        wp_reset_postdata();

        echo '</div>';

        echo '
            <button class="prev">></button>
            <button class="next"><</button>
        ';

        $posts = ob_get_contents();

        ob_end_clean();

        return $posts;
    }
}

new MC_BlogGrid;
