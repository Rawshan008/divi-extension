<?php

class MYEX_MyExtension extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'myex-my-extension';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'my-extension';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * MYEX_MyExtension constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'my-extension', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

		parent::__construct( $name, $args );

		add_action('wp_enqueue_scripts', array($this,'site_enqueue_script'));
	}

	public function site_enqueue_script(){
	    wp_enqueue_style('slick-css', plugin_dir_url(dirname(__FILE__)) . 'styles/slick.css');
	    wp_enqueue_style('slick-theme-css', plugin_dir_url(dirname(__FILE__)) . 'styles/slick-theme.css');

	    wp_enqueue_script('slick.min.js', plugin_dir_url(dirname(__FILE__)) . 'scripts/slick.min.js', array('jquery'), '1.0', true);
    }
}

new MYEX_MyExtension;
