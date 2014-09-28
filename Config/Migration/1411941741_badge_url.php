<?php
class BadgeUrl extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'uploads' => array(
					'badgeUrl' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_czech_ci', 'charset' => 'utf8', 'after' => 'previewUrl'),
				),
			),
			'alter_field' => array(
				'uploads' => array(
					'thumbnailUrl' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_czech_ci', 'charset' => 'utf8'),
					'previewUrl' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_czech_ci', 'charset' => 'utf8'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'uploads' => array('badgeUrl',),
			),
			'alter_field' => array(
				'uploads' => array(
					'thumbnailUrl' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_czech_ci', 'charset' => 'utf8'),
					'previewUrl' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_czech_ci', 'charset' => 'utf8'),
				),
			),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function after($direction) {
		return true;
	}
}
