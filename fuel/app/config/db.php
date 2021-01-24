<?php
/**
 * Fuel is a fast, lightweight, community driven PHP 5.4+ framework.
 *
 * @package    Fuel
 * @version    1.8.2
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2019 Fuel Development Team
 * @link       https://fuelphp.com
 */

/**
 * -----------------------------------------------------------------------------
 *  Global database settings
 * -----------------------------------------------------------------------------
 *
 *  Set database configurations here to override environment specific
 *  configurations
 *
 */

return array(
    'type' => 'pdo',
    'connection'     => array(
		'persistent'     => false,
	),
    'identifier' => '"' /* for PostgreSQL */,
	'table_prefix'   => 'cf_',
	'charset'        => null,
    'collation'      => false,
	'enable_cache'   => true,
	'profiling'      => false,
    'readonly'       => false,
);
