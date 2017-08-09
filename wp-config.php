<?php
define( 'WPCACHEHOME', '/home3/waepaq0acycy/public_html/wp-content/plugins/wp-super-cache/' ); //Added by WP-Cache Manager
//define('WP_CACHE', true); //Added by WP-Cache Manager
define('WP_HOME','http://animalalliesclinic.org');
define('WP_SITEURL','http://animalalliesclinic.org');


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
define('DB_NAME', 'waepaq0a_YaBRzpZGACoD2qbY');

/** MySQL database username */
define('DB_USER', 'waepaq0a_v7J');

/** MySQL database password */
define('DB_PASSWORD', 'v-eyW&=sDP:nYB`h#:*"b:mtr;+8LBOo');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY', 'QV~=_58{hOktj@M~m<oJTUy;i`[:0!JehF+A]-j=[x[ijR$*-"+xKWSXw[`QaS.}');
define('SECURE_AUTH_KEY', '2#X#4{-`_J/nlBKu66#XOJ,x9<46kHEoUzgp~b>kzQd/(1V4<OQvqGLR%K.v]M=C');
define('LOGGED_IN_KEY', '%G{9kR8#omOlqN<AWPHk;XXj0uJSLRmb:zjxTq1}p5dWll2zFCanO%izs-K}^?X$');
define('NONCE_KEY', '>+_v,]`TCt^)ae{!TSYGRx[fU$2mt%tpg:M7lNso0Hv^Go6ylPbbT$)n(ExfHX:,');
define('AUTH_SALT', 'gw9F2SmT:vc%<1rI0/FE"%AJb4Bp;O;.1N*XvkDotc^JsjO9b5fl00:)A-]<5mqX');
define('SECURE_AUTH_SALT', '5&TXl5"F3YWJH;)C<lCWhNjpC"+xn:fgb`59z>YV=>alDKf?4+)23]XB[hy[xnVx');
define('LOGGED_IN_SALT', '%0/qAu|y:za}`ZH/pICY@YGK>(k?cSEb~m/wN%Mp<"x_S%n$m"qvx5z8cUQWN2yt');
define('NONCE_SALT', '(slUY1<?6mF^?nS_eCac$uX}|v(;11_GY-mp>%}a,C^<EF/Jd@.C,VBk7O*qDffg');

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
