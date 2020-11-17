<?php
/**
 * Initialize the plugin.
 *
 * @package plugin-notes
 */

namespace Plugin\Notes;

/**
 * The init class.
 */
class Init {
	/**
	 * The option name.
	 *
	 * @var string
	 */
	private $option_name = 'plugin_notes';

	/**
	 * The option group.
	 *
	 * @var string
	 */
	private $option_group = 'plugin_notes';

	/**
	 * Init constructor.
	 */
	public function __construct() {
		add_action( 'admin_init', [ $this, 'admin_init' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
	}

	/**
	 * Admin Init callback. Registers options.
	 *
	 * @return void
	 */
	public function admin_init() {
		$setting_args = [
			'sanitize_callback' => [ $this, 'sanitize' ],
			'type'              => 'array',
		];

		register_setting( $this->option_group, $this->option_name, $setting_args );
	}

	/**
	 * Sanitize callback.
	 *
	 * @param array $val The value.
	 * @return array
	 */
	public function sanitize( $val ) {
		$new_val = [];

		foreach ( $val as $key => $val ) {
			$new_val[ $key ] = sanitize_textarea_field( $val );
		}

		return $new_val;
	}

	/**
	 * Register the settings page.
	 *
	 * @return void
	 */
	public function admin_menu() {
		add_submenu_page( 'tools.php', __( 'Plugin Notes', 'plugin-notes' ), __( 'Plugin Notes', 'plugin-notes' ), 'manage_options', 'plugin-notes', [ $this, 'page' ] );
	}

	/**
	 * Generates the page output.
	 *
	 * @return void
	 */
	public function page() {
		$plugins  = get_plugins();
		$settings = get_option( $this->option_name );
		?>
		<div class="wrap">
			<h1>
				<?php esc_html_e( 'Plugin Notes', 'plugin-notes' ); ?>
			</h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( $this->option_group );
				do_settings_sections( $this->option_group );
				?>
				<table class="form-table">
					<?php foreach ( $plugins as $slug => $plugin ) : ?>
						<?php $value = $settings[ $slug ] ?? ''; ?>
					<tr valign="top">
						<th scope="row">
							<label for="<?php $this->id( $slug ); ?>">
								<?php echo esc_html( $plugin['Name'] ); ?>
							</label>
						</th>
						<td>
							<textarea
								id=<?php $this->id( $slug ); ?>
								name="<?php $this->name( $slug ); ?>"
								rows="6"
								cols="60"
								><?php echo esc_html( $value ); ?></textarea>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Generates and ID from the plugin slug
	 *
	 * @param string $slug The plugin slug.
	 * @return void
	 */
	private function id( $slug ) {
		echo esc_attr(
			sanitize_title(
				sprintf(
					'%1$s-%2$s',
					$this->option_name,
					$slug
				)
			)
		);
	}

	/**
	 * Generates a name value from the slug.
	 *
	 * @param string $slug The plugin slug.
	 * @return void
	 */
	private function name( $slug ) {
		printf(
			'%1$s[%2$s]',
			esc_attr( $this->option_name ),
			esc_attr( $slug )
		);
	}
}
