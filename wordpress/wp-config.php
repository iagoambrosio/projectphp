<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do banco de dados
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do banco de dados - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
 
define( 'DB_NAME', 'wordpress-db' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'wordpress-user' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', 'hpj8X9Quadareu23greatPreDrmENb' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'mysql_compose' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'n}wX}7_=fp@JzNsvK#BnG~$l2{)t<&XQ#IMd#ToFiezmV)g#Ww#g}HgCCkO_*O:[' );
define( 'SECURE_AUTH_KEY',  'Zbh9]&*;9fK$4! a9EX!+{y]jeO2`AE_Kv TfH0bp#FY_3J1{7lwV D0JH=|7{sT' );
define( 'LOGGED_IN_KEY',    'bQ{r:mvi?KZC(EUu^3e6AbJ7tcTzZs])S4TxseAaw%a;y?l# T/.tbGT}qU]Vg#H' );
define( 'NONCE_KEY',        '>sPC][,G|N?/>Om(G%rnvKK:}Vo?!?a6G9&r-O~n._gUK[Jjoi/d%&).6I0.L@{]' );
define( 'AUTH_SALT',        '$PSaX+n7}$p-Ku1kJk,QG|wT4EBpq{Y1D)Cx+Pl3,ZxPD0$gU:d!@GDU{]rY_6#f' );
define( 'SECURE_AUTH_SALT', '{}D5A(P$J+[??V10c9C~5-s#S3HeZs,aR)WU{m%V4]9T+qAU`/]Jo;?K?x7Tq+TS' );
define( 'LOGGED_IN_SALT',   'nmM+8>!iK)KAVqa.{J1JDRB5]y+q0A7T1!l p&ToWizDf NcH@5eTz6!xlhh<gUe' );
define( 'NONCE_SALT',       'NJl}6 Qnf#CB ]V-*q(K{H`dphLG(^ga_dEMdhNt(*G00RCPfPC?:3R68-h{cpoN' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Adicione valores personalizados entre esta linha até "Isto é tudo". */



/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
