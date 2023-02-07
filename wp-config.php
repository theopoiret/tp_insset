<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'wordpress' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'pu*SZ5(#w0|]T7Xi ` <pHi7yTnz<G^4O<W_PDbpSGe@ I%#pA~Z1i58 YU1WZh9' );
define( 'SECURE_AUTH_KEY',  '4%$9UDeKC|^wwW^M`;fy2D.w3~3jmV5{(J{:TuOba+?+p{T+ j@8@UEGm$-t@aBt' );
define( 'LOGGED_IN_KEY',    '6M]woqjGbr~ey^##arF{6>MvDw-n8hFpRdAU1~Vc,w;wx}ACFdB0+S:ilrbgEbRb' );
define( 'NONCE_KEY',        '/59L.M;h:zV,BP~7`E|.A@pZXCGbkoxN&j!m>6Y5AgU.cZ [>.{UhSSnBO2bN{ER' );
define( 'AUTH_SALT',        '_r _A%I@KF.`=wMO|[2t&t:QSCy7zMZg!kz>_lp{_WZG`m^7=LCXqZBC,t# 2Q{L' );
define( 'SECURE_AUTH_SALT', 'pBwvVJS2.@(0gsVZbT:P 3.[TZ=2rh(AirRM,:4:3!:%H2Y~M]ttAfwj?%`@f!ul' );
define( 'LOGGED_IN_SALT',   '{WY{|VY&hB X[oJq~1=M(COEa<acF]KrYlkUvzgHXHTLw{tp/aO`+`Uzko2XE66A' );
define( 'NONCE_SALT',       '$]OcfoU +h;Uz.L`+TqBF,g4Ut#/hemCt*T_I]_&>a,Bjr1CrAgJ9dldw:PEhG=Y' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );

ini_set('display_errors', false);
error_reporting(0);