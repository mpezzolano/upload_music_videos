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
define('DB_NAME', 'biklop_music');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         ' (eykxtAfCP]wl#LIOoT<xeXrFK`Km54--1&{B33+-95m-+%bV0^--uJ_u0Fa``T');
define('SECURE_AUTH_KEY',  '2-)G{B`g!^EQ%~h+pwvG&jB+1l v>Y`LLk{3VRnUX&`pTD/?DMm/n#~zi@mT d/4');
define('LOGGED_IN_KEY',    'RtJzNeC1.zFre+AW{cas<[fchBYmcI.)A=P/D<PLcc)7E@n%lwQ|AHE%FXbfqbcb');
define('NONCE_KEY',        '~hi:|vuM9^/`2vnDEy29.E>S}}p[(S$PfLb*{zJ&E,ght=[=e(_m#l>lKwG]SS-;');
define('AUTH_SALT',        'Y`VY+U*YQ&Kv9|KNm-V8[Wvi1UxuoZP1= _in{ut&4$Zvzn=X+|#y4;B>}4m.G_|');
define('SECURE_AUTH_SALT', '4JNu36nS;[+g;ts~<+cn+|.({OUk!>ou $o;|%+-D7`7GE,b^)[=prO^M~7^x}Qx');
define('LOGGED_IN_SALT',   '%HYv26IUfu1pfK3,s=0~/E&c[~=-~}+`7 2NhfsD;G<WNQF#C@-R#}L_EK1bk~*G');
define('NONCE_SALT',       'i<w+Lz|Z)#|e|EYiT@)|Sw{%OH;9$w^HhgQfOc/gH7ua>-lZ/k{~GaWE*rr,B%*N');

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
