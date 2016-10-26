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
define('DB_NAME', 'sroc');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ' aXzo;4/c{%EwZj&6*JM La`(:41ap/|CuD<fj$*(:.WiAr%`}p[@{@s3{%:3o|7');
define('SECURE_AUTH_KEY',  '4Q.}waZkj~TR`4 ETqlI>$u})n%bY-Ag!}R{_f CQ&JO|PK?,NKj*A q8/qQi7R1');
define('LOGGED_IN_KEY',    'gFFz;$(CTCA.|P*Y+pK}IX,uKLTSOexoNs8B@%0?d +@QT98:ZUt{`q|SoWYjBuM');
define('NONCE_KEY',        'G)NE=z`SU*IDuSU=-}_4Y>xy|=,AQH}rG4Fj!S.{n=h&8hLnnhG0Am5n[se*KP{&');
define('AUTH_SALT',        'PfT*nChGuc]j[56/UQESq6R}xL-#NM<wD,vJ#o@f=1qLg/W_],4.(Yvlk>b&XoFi');
define('SECURE_AUTH_SALT', 'zJU6#.N-lj.dUvnJ.h;YP?iUA~hf:p_GwYU{lDg.]`4aB,,WjSO(b/tB2(=Mex_ ');
define('LOGGED_IN_SALT',   'WNA)*Xi@9p176jwxd$0q8+d5ap=D+Xew*wc4lhQ+*rXHJkS4>~-=a~uG`@f h?lI');
define('NONCE_SALT',       'Fgl,xAZC.R@@ZO=FloS|TD2l:o8]#A.7<ngX=9o2f9V3$yHZz?:MtHI2|h-Z&J1`');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
