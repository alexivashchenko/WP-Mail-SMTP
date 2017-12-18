<?php

namespace WPMailSMTP;

/**
 * Class Upgrade helps upgrade plugin options and similar tasks when the
 * occassion arises.
 *
 * @since 1.1.0
 */
class Upgrade {

	/**
	 * Upgrader constructor.
	 *
	 * @since 1.1.0
	 */
	public function __construct() {

		$upgrades = $this->upgrades();

		if ( empty( $upgrades ) ) {
			return;
		}

		// Run any available upgrades.
		foreach ( $upgrades as $upgrade ) {
			$this->{$upgrade}();
		}

		// Update version post upgrade(s).
		update_option( 'wp_mail_smtp_version', WPMS_PLUGIN_VER );
	}

	/**
	 * Whether we need to perform an upgrade.
	 *
	 * @since 1.1.0
	 *
	 * @return bool
	 */
	protected function upgrades() {

		$version  = get_option( 'wp_mail_smtp_version' );
		$upgrades = array();

		// Version 1.1.0 upgrade; prior to this the option was not available.
		if ( empty( $version ) ) {
			$upgrades[] = 'v110_upgrade';
		}

		return $upgrades;
	}

	/**
	 * Upgrade routine for v1.1.0.
	 *
	 * Set SMTPAutoTLS to true.
	 *
	 * @since 1.1.0
	 */
	public function v110_upgrade() {

		$values = Options::init()->get_all();

		// Enable SMTPAutoTLS option.
		$values['smtp']['autotls'] = true;

		Options::init()->set( $values );
	}
}