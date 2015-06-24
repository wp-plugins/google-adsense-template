<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
class adsense_template_Admin {

	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'adsense_template_options';

	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'adsense_template_option_metabox';

	/**
	 * Array of metaboxes/fields
	 * @var array
	 */
	protected $option_metabox = array();

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	public function __construct() {
		// Set our title
		$this->title = __( 'Adsense Template', 'adsense_template' );
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_filter('ptu_add_template_filter', array( $this, 'add_template' ));
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_init', array( $this, 'add_options_page_metabox' ) );
		//add_action( 'cmb2_init', array( $this, 'yourprefix_register_demo_metabox' ) );
		//add_action( 'cmb2_init', array( $this, 'add_adsense_page_metabox' ) );
		add_filter( 'cmb2_show_on', array( $this, 'be_metabox_show_on_template'), 10, 2 );
	}
	
	function add_template($templates){
		$templates['adsenseTemplate1.php'] = 'Adsense Template 1';
		return $templates;
	}

	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2_options_page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 * @param  array $meta_boxes
	 * @return array $meta_boxes
	 */
	function add_options_page_metabox() {

		$cmb = new_cmb2_box( array(
			'id'      => $this->metabox_id,
			'hookup'  => false,
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		// Set our CMB2 fields

		$cmb->add_field( array(
			'name' => __( 'Top Ad', 'adsense_template' ),
			//'desc' => __( 'field description (optional)', 'adsense_template' ),
			'id'   => 'top_ad',
			'type' => 'textarea_code'
			//'default' => 'Default Text',
		) );

		$cmb->add_field( array(
			'name'    => __( 'Bottom Ad', 'adsense_template' ),
			//'desc'    => __( 'field description (optional)', 'adsense_template' ),
			'id'      => 'bottom_ad',
			'type' => 'textarea_code'
			//'default' => '#bada55',
		) );

	}
	
	function add_adsense_page_metabox() {

		$cmb = new_cmb2_box( array(
			'id'      => '_adsense_template_adsense_metabox',
			'title'         => __( 'Test Metabox', 'cmb2' ),
			//'hookup'  => false,
			'object_types' => array( 'page', 'post' ),
			'show_on' => array(
				// These are important, don't remove
				'key'   => 'template',
				'value' => array('adsenseTemplate1', ),
			),
		) );

		// Set our CMB2 fields

		$cmb->add_field( array(
			'name' => __( 'Top Ad', 'adsense_template' ),
			//'desc' => __( 'field description (optional)', 'adsense_template' ),
			'id'   => 'page_top_ad',
			'type' => 'textarea_code'
			//'default' => 'Default Text',
		) );

		$cmb->add_field( array(
			'name'    => __( 'Bottom Ad', 'adsense_template' ),
			//'desc'    => __( 'field description (optional)', 'adsense_template' ),
			'id'      => 'page_bottom_ad',
			'type' => 'textarea_code'
			//'default' => '#bada55',
		) );

	}
	
	
	
	
	
	
	
	
	
	/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_init' hook.
 */
function yourprefix_register_demo_metabox() {
	// Start with an underscore to hide fields from custom fields list
	$prefix = '_yourprefix_demo_';
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => $prefix . 'metabox',
		'title'         => __( 'Test Metabox', 'cmb2' ),
		'object_types'  => array( 'page', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
	) );
	$cmb_demo->add_field( array(
		'name'       => __( 'Test Text', 'cmb2' ),
		'desc'       => __( 'field description (optional)', 'cmb2' ),
		'id'         => $prefix . 'text',
		'type'       => 'text',
		'show_on_cb' => 'yourprefix_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
	) );
}
	
	
	
	
	//'show_on'      => array( 'key' => 'page-template', 'value' => 'template-contact.php' ),

	/**
	 * Defines the theme option metabox and field configuration
	 * @since  0.1.0
	 * @return array
	 */
	public function option_metabox() {
		return ;
	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'fields', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid property: ' . $field );
	}
	
	
	/**
	 * Metabox for Page Template
	 * @author Kenneth White
	 * @link https://github.com/WebDevStudios/CMB2/wiki/Adding-your-own-show_on-filters
	 *
	 * @param bool $display
	 * @param array $meta_box
	 * @return bool display metabox
	 */
	function be_metabox_show_on_template( $display, $meta_box ) {
	
	    
	    if ( isset( $meta_box['show_on']['key'] ) && isset( $meta_box['show_on']['key'] ) ) :
	   // $GLOBALS['DebugMyPlugin']->panels['main']->addMessage('show_on key:'. $meta_box['show_on']['key']); 
	    if( 'template' !== $meta_box['show_on']['key'] )
	        return $display;
	
	    // Get the current ID
	    if( isset( $_GET['post'] ) ) $post_id = $_GET['post'];
	        elseif( isset( $_POST['post_ID'] ) ) $post_id = $_POST['post_ID'];
	    if( !isset( $post_id ) ) return false;
	
	    $template_name = get_page_template_slug( $post_id );
	    //$GLOBALS['DebugMyPlugin']->panels['main']->addMessage('$template_name: ' . $template_name,'Hello World'); 
	    if ( !empty( $template_name ) ) $template_name = substr($template_name, 0, -4);
	    //$GLOBALS['DebugMyPlugin']->panels['main']->addMessage('$template_name after substring: ' . $template_name,'Hello World'); 
	
	    // If value isn't an array, turn it into one
	    //$meta_box['show_on']['value'] = !is_array( $meta_box['show_on']['value'] ) ? array( $meta_box['show_on']['value'] ) : $meta_box['show_on']['value'];	
	    $test_array_in = in_array( $template_name, $meta_box['show_on']['value']);
		//$GLOBALS['DebugMyPlugin']->panels['main']->addMessage('in_array: ' . $test_array_in,'Hello World'); 
	    // See if there's a match
	    return in_array( $template_name, $meta_box['show_on']['value'] );
	    else:
	        return $display;
	    endif;
	}

}

// Get it started
$GLOBALS['adsense_template_Admin'] = new adsense_template_Admin();
$GLOBALS['adsense_template_Admin']->hooks();

/**
 * Helper function to get/return the adsense_template_Admin object
 * @since  0.1.0
 * @return adsense_template_Admin object
 */
function adsense_template_Admin() {
	global $adsense_template_Admin;
	return $adsense_template_Admin;
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function adsense_template_get_option( $key = '' ) {
	global $adsense_template_Admin;
	return cmb2_get_option( $adsense_template_Admin->key, $key );
	
}
