<?php
/**
 * Theme activation
 */
if ( is_admin() && isset( $_GET['activated'] ) && 'themes.php' == $GLOBALS['pagenow'] ) {
	wp_redirect( admin_url( 'themes.php?page=theme_activation_options' ) );
	exit;
}
add_action( 'admin_menu', 'skilled_theme_activation_options_add_page', 50 );
add_action( 'admin_init', 'skilled_import_data' );

function skilled_theme_activation_options_add_page() {
	add_theme_page( esc_html__( 'Theme Activation', 'skilled' ), esc_html__( 'Theme Activation', 'skilled' ), 'edit_theme_options', 'theme_activation_options', 'skilled_theme_activation_options_render_page' );
}

function skilled_import_data() {


	if ( isset( $_POST['wheels-demo-data'] ) ) {
		if ( check_admin_referer( 'wheels-demo-data-nonce' ) ) {

			require_once 'demo-importer/Wheels_Import_Manager.php';
			$import_manager = new Wheels_Import_Manager();

			/**
			 * Import Theme Options
			 */
			if ( isset( $_REQUEST['theme_options'] ) && $_REQUEST['theme_options'] != '' ) {
				$theme_options_filename = 'theme-options/' . $_REQUEST['theme_options'] . '.json';
				$import_manager->import_theme_options( $theme_options_filename );
			}
			/**
			 * Import Layer Sliders
			 */
			// if ( isset( $_REQUEST['import_layer_sliders'] ) && $_REQUEST['import_layer_sliders'] === 'true' ) {
			// 	$sliders = array(
			// 		'layer-slider/layer-slider.zip',
			// 	);
			// 	foreach( $sliders as $filename ) {
			// 		$import_manager->import_layer_slider($filename);
			// 	}
			// }
			/**
			 * Import Widgets
			 */
			if ( isset( $_REQUEST['import_widgets'] ) && $_REQUEST['import_widgets'] === 'true' ) {
				$delete_current_widgets = false;
				if ( $_REQUEST['delete_current_widgets'] === 'true' ) {
					$delete_current_widgets = false;
				}
				$import_manager->import_widgets( 'widgets.json', $delete_current_widgets );
			}
			/**
			 * Set Static Front Page
			 */
			if ( isset( $_REQUEST['static_front_page'] ) && $_REQUEST['static_front_page'] != '' ) {

				$static_front_page_id = $_REQUEST['static_front_page'];

				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $static_front_page_id );

				$home_menu_order = array(
					'ID'         => $static_front_page_id,
					'menu_order' => - 1
				);
				wp_update_post( $home_menu_order );
			}
			/**
			 * Set Static Posts Page
			 */
			if ( isset( $_REQUEST['static_posts_page'] ) && $_REQUEST['static_posts_page'] != '' ) {
				update_option( 'page_for_posts', $_REQUEST['static_posts_page']);
			}
			/**
			 * Change Permalink Structure
			 */
			if ( isset( $_REQUEST['change_permalink_structure'] ) && $_REQUEST['change_permalink_structure'] === 'true' ) {

				if ( get_option( 'permalink_structure' ) !== '/%postname%/' ) {
					global $wp_rewrite;
					$wp_rewrite->set_permalink_structure( '/%postname%/' );
					flush_rewrite_rules();
				}
			}
			/**
			 * Save Menus
			 */
//			if ( isset( $_REQUEST['save_menus'] ) && $_REQUEST['save_menus'] === 'true' ) {
//				$menus = array(
//					'primary_navigation' => 'Main Menu',
//					'secondary_navigation' => 'Footer Menu'
//				);
//				$import_manager->import_menus( $menus );
//			}
			/**
			 * Users Can Register
			 */
			if ( isset( $_REQUEST['anyone_can_register'] ) && $_REQUEST['anyone_can_register'] === 'true' ) {
				update_option('users_can_register', 1);
			}
			/**
			 * Set Sensei Course Archive Page
			 */
			if ( isset( $_REQUEST['sensei_course_archive_page'] ) && $_REQUEST['sensei_course_archive_page'] != '' ) {
				update_option( 'woothemes-sensei-settings', array(
					'course_page' => $_REQUEST['sensei_course_archive_page'],
				) );
			}
			/**
			 * Set Sensei My Courses Page
			 */
			if ( isset( $_REQUEST['sensei_my_courses_page'] ) && $_REQUEST['sensei_my_courses_page'] != '' ) {
				update_option( 'woothemes-sensei-settings', array(
					'my_course_page' => $_REQUEST['sensei_my_courses_page'],
				) );
			}

		}
	}

}

function skilled_theme_activation_options_render_page() {
	$theme = wp_get_theme();
	if($theme->parent_theme) {
		$template_dir =  basename(get_template_directory());
		$theme = wp_get_theme($template_dir);
	}
	$theme_version = $theme->get( 'Version' );
	$theme_name = $theme->get( 'Name' );
	?>
	<div class="wrap">
		<h2><?php printf( esc_html__( '%s Theme Activation', 'skilled' ), wp_get_theme() ); ?></h2>

		<p><?php esc_html_e( 'These videos cover installation and update process.', 'skilled' ); ?></p>

		<p>
			<iframe width="560" height="315" src="https://www.youtube.com/embed/hDrcuXtzM0s" frameborder="0" allowfullscreen></iframe>
	        <iframe width="560" height="315" src="https://www.youtube.com/embed/9ct9KLDIFH0" frameborder="0" allowfullscreen></iframe>
		</p>
		<br/>
		<hr/>
		<h3><?php esc_html_e( 'Update Instructions', 'skilled' ); ?></h3>
		<p>
		<?php esc_html_e( 'If you are updating the theme, please watch the video on the right.',
						'skilled' ); ?>
		</p>
		<hr/>
		<h3><?php esc_html_e( 'Installation Steps', 'skilled' ); ?></h3>
		<h4><em><?php esc_html_e( 'These settings are optional and should usually be used only on a fresh installation.', 'skilled' ); ?></em></h4>
		<ol>
			<li>
				<p><strong><?php esc_html_e( 'Install required plugins', 'skilled' ); ?></strong></p>
				<p><?php esc_html_e( 'First, enable required plugins. After you finish plugin installation return to this page to complete the installation process.',
						'skilled' ); ?></p>
				<a href="<?php echo admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=install' ); ?>"><?php esc_html_e('Install required plugins', 'skilled'); ?></a>
			</li>
			<li>
				<p><strong><?php esc_html_e( 'Please note that Sensei plugin is not included in the theme and needs to be purchased separately.',
						'skilled' ); ?></strong></p>
				<p><?php esc_html_e( 'If you choose to use it you need to install it before you proceed to importing demo content.',
						'skilled' ); ?></p>
				<p><?php printf(esc_attr('Please follow this %s. Also, please read the documentation on the plugin.', 'wheels'), '<a href="http://www.woothemes.com/products/sensei/" target="_blank">link</a>'); ?></p>
				<a href="<?php echo admin_url( 'plugin-install.php?tab=upload' ); ?>"><?php esc_html_e('Install plugin', 'skilled'); ?></a>

			</li>
			<li>
				<p><strong><?php esc_html_e( 'Import demo content', 'skilled' ); ?></strong></p>
				<p><?php esc_html_e( 'Proceed only after all plugins are installed', 'skilled' ); ?></p>
				<a href="<?php echo admin_url( 'import.php?import=wordpress' ); ?>"><?php esc_html_e('Go to Wordpress Importer', 'skilled'); ?></a>
			</li>
			<li>
				<p><strong><?php esc_html_e( 'Import Layer Slider demo sliders', 'skilled' ); ?></strong></p>
				<?php if ( is_plugin_active( 'LayerSlider/layerslider.php' ) ): ?>
					<a href="<?php echo admin_url( 'admin.php?page=layerslider' ); ?>"><?php esc_html_e('Go to Layer Slider Importer', 'skilled'); ?></a>
				<?php else: ?>
					<?php esc_html_e( 'In order to import demo sliders you need to install and activate Layer Slider plugin', 'skilled' ); ?>
				<?php endif; ?>
			</li>
			<li>
				<p><strong><?php esc_html_e( 'Import Icons', 'skilled' ); ?></strong></p>
				<a href="<?php echo admin_url( 'admin.php?page=bsf-font-icon-manager' ); ?>"><?php esc_html_e('Go to Ultimate VC Addons Icon Manager', 'skilled'); ?></a>
			</li>
			<li>
				<p><strong><?php _e( 'Save Menus', 'skilled' ); ?></strong></p>
				<a href="<?php echo admin_url( 'nav-menus.php' ); ?>"><?php esc_html_e('Go to Wordpress Menus', 'skilled'); ?></a>
			</li>
			<li>
				<p><strong><?php _e( 'Select Front and Posts page', 'skilled' ); ?></strong></p>
				<a href="<?php echo admin_url( 'options-reading.php' ); ?>"><?php esc_html_e('Go to Wordpress Reading Settings', 'skilled'); ?></a>
			</li>
			<li>
				<p><strong><?php _e( 'Membership - Anyone Can Register? (Optional)', 'skilled' ); ?></strong></p>
				<p><?php esc_html_e( 'You need to set this if you want to allow users to register on your site.',
						'skilled' ); ?></p>
				<a href="<?php echo admin_url( 'options-general.php#users_can_register' ); ?>"><?php esc_html_e('Go to General Settings', 'skilled'); ?></a>
			</li>
		</ol>
		<br>
		<hr>
		<br>
		<form method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ); ?>">
			<input type="hidden" name="wheels-demo-data" value="1">
			<?php wp_nonce_field( 'wheels-demo-data-nonce' ); ?>
			<table class="form-table">


				<tr valign="top">
					<th scope="row"><?php esc_html_e( 'Import Theme Options', 'skilled' ); ?></th>
					<td>
						<fieldset>
							<select name="theme_options" id="">
								<option value="">Select Color Variation</option>
								<option value="default">Default</option>
								<option value="brown">Brown</option>
								<option value="green-blue-yellow">Green Blue Yellow</option>
								<option value="grey-green">Grey Green</option>
								<option value="orange-blue">Orange Blue</option>
								<option value="red-blue">Red Blue</option>
							</select>
						</fieldset>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e( 'Sidebar and Footer widgets', 'skilled' ); ?></th>
					<td>
						<fieldset>
							<label for="import_widgets">Import?</label>
							<input type="hidden" name="import_widgets" value="false"/>
							<input id="import_widgets" type="checkbox" name="import_widgets" value="true"/>

							<label for="delete_current_widgets">Delete current widgets?</label>
							<input type="hidden" name="delete_current_widgets" value="false"/>
							<input id="delete_current_widgets" type="checkbox" name="delete_current_widgets" value="true"/>
						</fieldset>
					</td>
				</tr>
				<?php if ( is_plugin_active( 'woothemes-sensei/woothemes-sensei.php' ) ) : ?>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Sensei Course Archive Page', 'skilled' ); ?></th>
						<td>
							<fieldset>
								<?php wp_dropdown_pages(array('name' => 'sensei_course_archive_page', 'show_option_none' => 'Select Sensei Course Archive page')); ?>
							</fieldset>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Sensei My Courses Page', 'skilled' ); ?></th>
						<td>
							<fieldset>
								<?php wp_dropdown_pages(array('name' => 'sensei_my_courses_page', 'show_option_none' => 'Select Sensei My Courses page')); ?>
							</fieldset>
						</td>
					</tr>
				<?php endif; ?>
			</table>
			<?php submit_button(); ?>
		</form>
		<br/>
		<hr/>
		<br/>
		<h2><?php esc_html_e( 'Important!', 'skilled' ); ?></h2>
  		<h4><?php printf(esc_attr('To use %s Theme, you must be running:', 'wheels'), $theme_name); ?></h4>
    	<ul style="list-style:circle;margin:10px 40px 13px;">
      		<li><?php esc_html_e( 'WordPress 3.1 or higher', 'skilled' ); ?></li>
      		<li><?php esc_html_e( 'PHP5.4 or higher', 'skilled' ); ?></li>
      		<li><?php esc_html_e( 'and mysql 5 or higher', 'skilled' ); ?></li>
    	</ul>
		<h4>
			<?php esc_html_e( 'Many issues that you may run into such as: white screen, demo content fails when importing and other similar issues are all related to low PHP configuration limits. The solution is to increase the PHP limits. You can do this on your own, or contact your web host and ask them to increase those limits to a minimum as follows:',
						'skilled' ); ?>
		</h4>
		<ul style="list-style:circle;margin:10px 40px 13px;">
			<li><?php esc_html_e( 'max_execution_time 180', 'skilled' ); ?></li>
			<li><?php esc_html_e( 'memory_limit 128M', 'skilled' ); ?></li>
			<li><?php esc_html_e( 'post_max_size 32M', 'skilled' ); ?></li>
			<li><?php esc_html_e( 'upload_max_filesize 32M', 'skilled' ); ?></li>
		</ul>
		<h4><?php esc_html_e( 'We have tested it with Mac, Windows and Linux. Below is a list of items you should ensure your host can comply with:', 'skilled' ); ?></h4>
	  	<ul style="list-style:circle;margin:10px 40px 13px;">
      		<li><?php esc_html_e( 'Check to ensure that your web host has the minimum requirements to run WordPress.', 'skilled' ); ?></li>
      		<li><?php esc_html_e( 'Always make sure they are running the latest version of WordPress.', 'skilled' ); ?></li>
			<li><?php printf(esc_attr('You can download the latest release of WordPress from official %s website.', 'wheels'), '<a href="https://wordpress.org/" target="_blank">WordPress</a>'); ?></li>
      		<li><?php esc_html_e( 'Always create secure passwords for FTP and Database.', 'skilled' ); ?></li>
    	</ul>
		<h4>
			<?php printf(esc_attr('Sensei Plugin is not included. You need to purchase it separately %s. Also, please read the documentation on the plugin.', 'wheels'), '<a href="http://www.woothemes.com/products/sensei/" target="_blank">here</a>'); ?></p>
		</h4>
			<?php esc_html_e( 'Visual Composer, Ultimate Addons for Visual Composer and Layer Slider plugins are included with the theme but you do not get purchase codes for these plugins.', 'skilled' ); ?>
		</h4>
		<p>
			<?php esc_html_e( 'That means that automatic updates for the plugins will not be available to you unless you buy a regular license for the plugin. We do not recommend that you buy regular licenses for the plugins because they will be updated with theme updates.', 'skilled' ); ?>
		</p>
		<br/>
		<?php if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) : ?>
			<br/>
			<p>
				<a href="<?php echo admin_url( 'admin.php?page=wc-status' ); ?>"><?php esc_html_e( 'Check System Status page', 'skilled' ); ?></a>
			</p>
		<?php endif; ?>
		<hr/>
		<h4>
			<?php printf(esc_attr('In case you need support contact us %s.', 'wheels'), '<a href="http://themeforest.net/user/aislin#contact" target="_blank">here</a>'); ?></p>
		</h4>
		<h4>
			<?php printf(esc_attr('Please make sure to include your puchase code in the email. Here is how to obtain the %s.', 'wheels'), '<a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-can-I-find-my-Purchase-Code-" target="_blank">purchase code</a>'); ?></p>
		</h4>
		<br/>
		<hr/>
		<br/>
	</div>
<?php
}
