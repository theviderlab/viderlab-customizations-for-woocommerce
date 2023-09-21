<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://viderlab.com
 * @since      1.0.0
 *
 * @package    ViderLab_Customizations_for_Woocommerce
 * @subpackage ViderLab_Customizations_for_Woocommerce/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    ViderLab_Customizations_for_Woocommerce
 * @subpackage ViderLab_Customizations_for_Woocommerce/admin
 * @author     ViderLab
 */
class ViderLab_Customizations_for_Woocommerce_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ViderLab_Customizations_for_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ViderLab_Customizations_for_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/viderlab-customizations-for-woocommerce-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ViderLab_Customizations_for_Woocommerce_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ViderLab_Customizations_for_Woocommerce_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/viderlab-customizations-for-woocommerce-admin.js', array( 'jquery' ), $this->version, false );

	}

	// Menu
	public function add_wc_submenu() {
		$this->page_id = add_submenu_page(
			'woocommerce',
			__('Customizations for Woocommerce', 'viderlab-customizations-for-woocommerce'),
			__('Customizations for Woocommerce', 'viderlab-customizations-for-woocommerce'),
			'manage_woocommerce',
			'viderlab-customizations-for-woocommerce',
			array($this, 'wc_submenu_page')
		);
	}

	// Settings
    public function settings_init() {
        // Register a new setting for "viderlab-customizations-for-woocommerce-settings" page.
        register_setting( 'viderlab-customizations-for-woocommerce-settings', 'viderlab-customizations-for-woocommerce-settings_options' );

        /** SECTIONS **/
        // Shop
        add_settings_section(
            'viderlab-customizations-for-woocommerce-settings_shop',
            __( 'Shop', 'viderlab-customizations-for-woocommerce' ), 
            [ $this, 'settings_shop' ],
            'viderlab-customizations-for-woocommerce-settings'
        );

        // Product
        add_settings_section(
            'viderlab-customizations-for-woocommerce-settings_products',
            __( 'Products', 'viderlab-customizations-for-woocommerce' ), 
            [ $this, 'settings_products' ],
            'viderlab-customizations-for-woocommerce-settings'
        );

        // Checkout
        add_settings_section(
            'viderlab-customizations-for-woocommerce-settings_checkout',
            __( 'Checkout', 'viderlab-customizations-for-woocommerce' ), 
            [ $this, 'settings_checkout' ],
            'viderlab-customizations-for-woocommerce-settings'
        );

        // My Account
        add_settings_section(
            'viderlab-customizations-for-woocommerce-settings_my-account',
            __( 'My Account', 'viderlab-customizations-for-woocommerce' ), 
            [ $this, 'settings_my_account' ],
            'viderlab-customizations-for-woocommerce-settings'
        );

        /** FIELDS **/
        // SHOP
        add_settings_field(
            'viderlab-customizations-for-woocommerce-settings_addtocart-text', // As of WP 4.6 this value is used only internally.
                                    // Use $args' label_for to populate the id inside the callback.
                __( 'Button text', 'viderlab-customizations-for-woocommerce' ),
            [ $this, 'input_text_field' ],
            'viderlab-customizations-for-woocommerce-settings',
            'viderlab-customizations-for-woocommerce-settings_shop',
            array(
                'label_for'     => 'viderlab-customizations-for-woocommerce-settings_addtocart-text',
                'class'         => 'viderlab-customizations-for-woocommerce-settings_row',
                'custom_data'   => 'custom',
                'description'   => __( 'Change "Add to cart" button text. Leave empty for default', 'viderlab-customizations-for-woocommerce' ),
            )
        );

        // PRODUCTS
        // Add Gutenberg to product pages
        add_settings_field(
            'viderlab-customizations-for-woocommerce-settings_add-gutenberg-product', // As of WP 4.6 this value is used only internally.
                                    // Use $args' label_for to populate the id inside the callback.
                __( 'Add Gutenberg to products', 'viderlab-customizations-for-woocommerce' ),
            [ $this, 'input_checkbox_field' ],
            'viderlab-customizations-for-woocommerce-settings',
            'viderlab-customizations-for-woocommerce-settings_products',
            array(
                'label_for'     => 'viderlab-customizations-for-woocommerce-settings_add-gutenberg-product',
                'class'         => 'viderlab-customizations-for-woocommerce-settings_row',
                'custom_data'   => 'custom',
                'description'   => __( 'Add Gutenberg editor to products pages.', 'viderlab-customizations-for-woocommerce' ),
            )
        );

        // CHECKOUT
        // Remove Cart
        add_settings_field(
            'viderlab-customizations-for-woocommerce-settings_remove-cart', // As of WP 4.6 this value is used only internally.
                                    // Use $args' label_for to populate the id inside the callback.
                __( 'Remove cart', 'viderlab-customizations-for-woocommerce' ),
            [ $this, 'input_checkbox_field' ],
            'viderlab-customizations-for-woocommerce-settings',
            'viderlab-customizations-for-woocommerce-settings_checkout',
            array(
                'label_for'     => 'viderlab-customizations-for-woocommerce-settings_remove-cart',
                'class'         => 'viderlab-customizations-for-woocommerce-settings_row',
                'custom_data'   => 'custom',
                'description'   => __( 'Removes cart form checkout process.', 'viderlab-customizations-for-woocommerce' ),
            )
        );

		// Empty Cart before adding new product
        add_settings_field(
            'viderlab-customizations-for-woocommerce-settings_empty-cart', // As of WP 4.6 this value is used only internally.
                                    // Use $args' label_for to populate the id inside the callback.
                __( 'Empty cart before adding', 'viderlab-customizations-for-woocommerce' ),
            [ $this, 'input_checkbox_field' ],
            'viderlab-customizations-for-woocommerce-settings',
            'viderlab-customizations-for-woocommerce-settings_checkout',
            array(
                'label_for'     => 'viderlab-customizations-for-woocommerce-settings_empty-cart',
                'class'         => 'viderlab-customizations-for-woocommerce-settings_row',
                'custom_data'   => 'custom',
                'description'   => __( 'Removes all items from cart before adding a new product. To allow only purchasing one product at a time.', 'viderlab-customizations-for-woocommerce' ),
            )
        );

        // Removes add to cart message
        add_settings_field(
            'viderlab-customizations-for-woocommerce-settings_remove-addtocart-message', // As of WP 4.6 this value is used only internally.
                                    // Use $args' label_for to populate the id inside the callback.
                __( 'Remove add to cart message', 'viderlab-customizations-for-woocommerce' ),
            [ $this, 'input_checkbox_field' ],
            'viderlab-customizations-for-woocommerce-settings',
            'viderlab-customizations-for-woocommerce-settings_checkout',
            array(
                'label_for'     => 'viderlab-customizations-for-woocommerce-settings_remove-addtocart-message',
                'class'         => 'viderlab-customizations-for-woocommerce-settings_row',
                'custom_data'   => 'custom',
                'description'   => __( 'Removes the message shown when a new item is added to the cart.', 'viderlab-customizations-for-woocommerce' ),
            )
        );

        // Removes fields from checkout form
        $checkout_fields = [
            ['billing','billing_first_name'],
            ['billing','billing_last_name'],
            ['billing','billing_company'],
            ['billing','billing_country'],
            ['billing','billing_address_1'],
            ['billing','billing_address_2'],
            ['billing','billing_city'],
            ['billing','billing_state'],
            ['billing','billing_postcode'],
            ['billing','billing_phone'],
            ['billing','billing_email'],
            ['shipping','shipping_first_name'],
            ['shipping','shipping_last_name'],
            ['shipping','shipping_company'],
            ['shipping','shipping_country'],
            ['shipping','shipping_address_1'],
            ['shipping','shipping_address_2'],
            ['shipping','shipping_city'],
            ['shipping','shipping_state'],
            ['shipping','shipping_postcode'],
            ['order','order_comments'],
        ];
        foreach($checkout_fields as $field) {
            add_settings_field(
                "viderlab-customizations-for-woocommerce-settings_remove-{$field[0]}-{$field[1]}-field", // As of WP 4.6 this value is used only internally.
                                        // Use $args' label_for to populate the id inside the callback.
                    sprintf(__( "Remove ['%s']['%s'] field", 'viderlab-customizations-for-woocommerce' ), $field[0], $field[1]),
                [ $this, 'input_checkbox_field' ],
                'viderlab-customizations-for-woocommerce-settings',
                'viderlab-customizations-for-woocommerce-settings_checkout',
                array(
                    'label_for'     => "viderlab-customizations-for-woocommerce-settings_remove-{$field[0]}-{$field[1]}-field",
                    'class'         => 'viderlab-customizations-for-woocommerce-settings_row',
                    'custom_data'   => 'custom',
                    'description'   => sprintf(__( "Removes '%s' field from '%s' section of checkout form.", 'viderlab-customizations-for-woocommerce' ), $field[0], $field[1]),
                )
            );
        }

        // Removes additional info in checkout
        add_settings_field(
            'viderlab-customizations-for-woocommerce-settings_remove-additional-info', // As of WP 4.6 this value is used only internally.
                                    // Use $args' label_for to populate the id inside the callback.
                __( 'Remove additional info section', 'viderlab-customizations-for-woocommerce' ),
            [ $this, 'input_checkbox_field' ],
            'viderlab-customizations-for-woocommerce-settings',
            'viderlab-customizations-for-woocommerce-settings_checkout',
            array(
                'label_for'     => 'viderlab-customizations-for-woocommerce-settings_remove-additional-info',
                'class'         => 'viderlab-customizations-for-woocommerce-settings_row',
                'custom_data'   => 'custom',
                'description'   => __( 'Removes the title of additional information in checkout form.', 'viderlab-customizations-for-woocommerce' ),
            )
        );

        // MY ACCOUNT
        // Removes tabs from My Account
        $my_account_tabs = ['dashboard', 'orders', 'downloads', 'edit-address', 'members-area', 'payment-methods', 'edit-account', 'customer-logout'];
        foreach($my_account_tabs as $tab) {
            add_settings_field(
                "viderlab-customizations-for-woocommerce-settings_remove-{$tab}-tab", // As of WP 4.6 this value is used only internally.
                                        // Use $args' label_for to populate the id inside the callback.
                    sprintf(__( "Remove '%s' tab", 'viderlab-customizations-for-woocommerce' ), $tab),
                [ $this, 'input_checkbox_field' ],
                'viderlab-customizations-for-woocommerce-settings',
                'viderlab-customizations-for-woocommerce-settings_my-account',
                array(
                    'label_for'     => "viderlab-customizations-for-woocommerce-settings_remove-{$tab}-tab",
                    'class'         => 'viderlab-customizations-for-woocommerce-settings_row',
                    'custom_data'   => 'custom',
                    'description'   => sprintf(__( "Removes '%s' tab from My Account.", 'viderlab-customizations-for-woocommerce' ), $tab),
                )
            );
        }

        // Select default tab from My Account
        add_settings_field(
            'viderlab-customizations-for-woocommerce-settings_default-tab', // As of WP 4.6 this value is used only internally.
                                    // Use $args' label_for to populate the id inside the callback.
                __( 'Default tab', 'viderlab-customizations-for-woocommerce' ),
            [ $this, 'select_field' ],
            'viderlab-customizations-for-woocommerce-settings',
            'viderlab-customizations-for-woocommerce-settings_my-account',
            array(
                'label_for'     => 'viderlab-customizations-for-woocommerce-settings_default-tab',
                'class'         => 'viderlab-customizations-for-woocommerce-settings_row',
                'custom_data'   => 'custom',
                'description'   => __( 'Sets de default tab in My Account page.', 'viderlab-customizations-for-woocommerce' ),
                'options'       => array_slice($my_account_tabs, 0, -1), // Removes last element 'customer-logout'
            )
        );
    }

    /**
     * Filter section callback function.
     *
     * @param array $args  The settings array, defining title, id, callback.
     */
    public function settings_shop( $args ) {
    }
    public function settings_products( $args ) {
    }
    public function settings_checkout( $args ) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Modify checkout behaviour.', 'viderlab-customizations-for-woocommerce' ); ?></p>
        <?php
    }
    public function settings_my_account( $args ) {
    }

    /**
     * Input text field
     *
     * @param array $args
     */
    public function input_text_field( $args ) {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );
        ?>
        <input type="text" 
                id="<?php echo esc_attr( $args['label_for'] ); ?>"
                data-custom="<?php echo esc_attr( $args['custom_data'] ); ?>"
                name="viderlab-customizations-for-woocommerce-settings_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
                value="<?php echo $options !== false && isset($options[ $args['label_for'] ]) ? $options[ $args['label_for'] ] : ''; ?>">
        <p class="description">
		<?php echo esc_attr( $args['description'] ); ?>
        </p>
        <?php
    }

	/**
     * Input checkbox field
     *
     * @param array $args
     */
    public function input_checkbox_field( $args ) {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );
        ?>
        <input type="checkbox" 
                id="<?php echo esc_attr( $args['label_for'] ); ?>"
                data-custom="<?php echo esc_attr( $args['custom_data'] ); ?>"
                name="viderlab-customizations-for-woocommerce-settings_options[<?php echo esc_attr( $args['label_for'] ); ?>]"
                value="<?php echo $args['label_for']; ?>"
				<?php checked( $options !== false && isset($options[$args['label_for']]), true ); ?> >
        <p class="description">
		<?php echo esc_attr( $args['description'] ); ?>
        </p>
        <?php
    }

    /**
     * Select field
     *
     * @param array $args
     */
    public function select_field( $args ) {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );
        ?>
        <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
                data-custom="<?php echo esc_attr( $args['custom_data'] ); ?>"
                name="viderlab-customizations-for-woocommerce-settings_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
                <?php
                foreach( $args['options'] as $option ): ?>
                    <option value="<?php echo esc_attr($option); ?>" <?php selected( $options !== false && ($options[$args['label_for']] == $option), true ); ?>>
                        <?php echo esc_attr($option); ?>
                    </option>
                <?php
                endforeach; ?>
        </select>        
        <p class="description">
		<?php echo esc_attr( $args['description'] ); ?>
        </p>
        <?php
    }

	// Admin page
	public function wc_submenu_page() {
        // check user capabilities
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // add error/update messages

        // check if the user have submitted the settings
        // WordPress will add the "settings-updated" $_GET parameter to the url
        if ( isset( $_GET['settings-updated'] ) ) {
            // add settings saved message with the class of "updated"
            add_settings_error( 'viderlab-customizations-for-woocommerce-settings_messages', 'viderlab-customizations-for-woocommerce-settings_message', __( 'Settings Saved', 'viderlab-customizations-for-woocommerce' ), 'updated' );
        }

        // show error/update messages
        settings_errors( 'viderlab-customizations-for-woocommerce-settings_messages' );
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                // output security fields for the registered setting "viderlab-customizations-for-woocommerce-settings"
                settings_fields( 'viderlab-customizations-for-woocommerce-settings' );
                // output setting sections and their fields
                // (sections are registered for "viderlab-customizations-for-woocommerce-settings", each field is registered to a specific section)
                do_settings_sections( 'viderlab-customizations-for-woocommerce-settings' );
                // output save settings button
                submit_button( __('Save Settings', 'viderlab-customizations-for-woocommerce') );
                ?>
            </form>
        </div>
        <?php
	}

    /**
     * Enables Gutenberg editor for Woocommerce product pages.
     *
     */
    public function activate_gutenberg_product() {
        add_filter( 'use_block_editor_for_post_type', [$this, 'activate_gutenberg_product_filter'], 10, 2 );    
    }
    public function activate_gutenberg_product_filter( $can_edit, $post_type ) {
        $options = get_option( 'viderlab-customizations-for-woocommerce-settings_options' );
		if( $post_type == 'product' && $options !== false &&
                isset($options['viderlab-customizations-for-woocommerce-settings_add-gutenberg-product']) ) {
            $can_edit = true;
		}

        return $can_edit;
    }
}
