<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', 'root' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'JoXTFrlGDmJGhZfGvEPSgC9oqiRtMtspdv3AeMKewD/w91ploKNTG4RceOXZsuvag0rs8K9mxSQN1UrAZxrOnA==');
define('SECURE_AUTH_KEY',  'usOvgrNnjOp/omHHPR/P8x1NhMBc/dJgstLSeiZ1d1hZ1Od+ZT07SgprXg1a89DAviVjVLDXnrFUIcpMrzAAEw==');
define('LOGGED_IN_KEY',    'k2LXXyuE382vuCoP1nT59sfiV5MtccQIoK5IM74cuo2QiHOt3uH+Mu457ukw7/n5KafY3BXSRwBzCeOHq8WIJw==');
define('NONCE_KEY',        'WSb8kjX4cPLf7hzh0V4Aud+qyihXdtYotSjUnzIIkxFk+18jL0PK2jlhtgFa+c96Sc3Qdls+Fr/82vWZYOFVpg==');
define('AUTH_SALT',        'lHbWvTTneN/VJryJkchaMZiHwoBsXmLGIS+wHRwfsIX9p6X4PQrrpjCttI/tlGl3BPPZUYEJucPGfEEf55KB1A==');
define('SECURE_AUTH_SALT', 'BYUtD7Gsmv9uL8RymhuoK+5cFuZ11v6uHuIasw9ezWM0hJF73YxrP7syyQxpEKomBI3U4/lERrSTQA5sThxdkA==');
define('LOGGED_IN_SALT',   'SuEi29+Q8SQO/TLdLG0rh+dQxsQ9m4oNEcgOkaGZrK6mjqJXrTUGAimH99YrKjq0Sy3ppwjY9jv5j1lD93+JqA==');
define('NONCE_SALT',       'GzhNxLdbISaJEtkSHzg2X+ja7lxn1MtkU7yC9joki0TnwjZJPMh75pdHJpSh/9nZBoIi1Hfc9ekwcptimQxmuw==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
