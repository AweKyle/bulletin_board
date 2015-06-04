<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<link rel="stylesheet" type="text/css" href="/wp-content/plugins/bulletin_board/assets/css/main.css">

	<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>
<title>Объявление | my_vsu</title>
<meta name='robots' content='noindex,follow' />
<link rel="alternate" type="application/rss+xml" title="my_vsu &raquo; Лента" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/feed/" />
<link rel="alternate" type="application/rss+xml" title="my_vsu &raquo; Лента комментариев" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/comments/feed/" />
		<script type="text/javascript">
			window._wpemojiSettings = {"baseUrl":"http:\/\/s.w.org\/images\/core\/emoji\/72x72\/","ext":".png","source":{"concatemoji":"http:\/\/awe-kyle.ru\/wp-includes\/js\/wp-emoji-release.min.js?ver=4.2.1"}};
			!function(a,b,c){function d(a){var c=b.createElement("canvas"),d=c.getContext&&c.getContext("2d");return d&&d.fillText?(d.textBaseline="top",d.font="600 32px Arial","flag"===a?(d.fillText(String.fromCharCode(55356,56812,55356,56807),0,0),c.toDataURL().length>3e3):(d.fillText(String.fromCharCode(55357,56835),0,0),0!==d.getImageData(16,16,1,1).data[0])):!1}function e(a){var c=b.createElement("script");c.src=a,c.type="text/javascript",b.getElementsByTagName("head")[0].appendChild(c)}var f;c.supports={simple:d("simple"),flag:d("flag")},c.supports.simple&&c.supports.flag||(f=c.source||{},f.concatemoji?e(f.concatemoji):f.wpemoji&&f.twemoji&&(e(f.twemoji),e(f.wpemoji)))}(window,document,window._wpemojiSettings);
		</script>
		<style type="text/css">
img.wp-smiley,
img.emoji {
	display: inline !important;
	border: none !important;
	box-shadow: none !important;
	height: 1em !important;
	width: 1em !important;
	margin: 0 .07em !important;
	vertical-align: -0.1em !important;
	background: none !important;
	padding: 0 !important;
}
</style>
<link rel='stylesheet' id='open-sans-css'  href='//fonts.googleapis.com/css?family=Open+Sans%3A300italic%2C400italic%2C600italic%2C300%2C400%2C600&#038;subset=latin%2Clatin-ext%2Ccyrillic%2Ccyrillic-ext&#038;ver=4.2.1' type='text/css' media='all' />
<link rel='stylesheet' id='dashicons-css'  href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/wp-includes/css/dashicons.min.css?ver=4.2.1' type='text/css' media='all' />
<link rel='stylesheet' id='admin-bar-css'  href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/wp-includes/css/admin-bar.min.css?ver=4.2.1' type='text/css' media='all' />
<link rel='stylesheet' id='twentyfifteen-fonts-css'  href='//fonts.googleapis.com/css?family=Noto+Sans%3A400italic%2C700italic%2C400%2C700%7CNoto+Serif%3A400italic%2C700italic%2C400%2C700%7CInconsolata%3A400%2C700&#038;subset=latin%2Clatin-ext%2Ccyrillic%2Ccyrillic-ext' type='text/css' media='all' />
<link rel='stylesheet' id='genericons-css'  href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/wp-content/plugins/bulletin_board/assets/css/genericons/genericons.css?ver=3.2' type='text/css' media='all' />
<link rel='stylesheet' id='twentyfifteen-style-css'  href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/wp-content/plugins/bulletin_board/assets/css/style.css?ver=4.2.1' type='text/css' media='all' />
<!--[if lt IE 9]>
<link rel='stylesheet' id='twentyfifteen-ie-css'  href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/wp-content/plugins/bulletin_board/assets/css/ie.css?ver=20141010' type='text/css' media='all' />
<![endif]-->
<!--[if lt IE 8]>
<link rel='stylesheet' id='twentyfifteen-ie7-css'  href='http://<?php echo $_SERVER['HTTP_HOST']; ?>/wp-content/plugins/bulletin_board/assets/css/ie7.css?ver=20141010' type='text/css' media='all' />
<![endif]-->
<script type='text/javascript' src='http://<?php echo $_SERVER['HTTP_HOST']; ?>/wp-includes/js/jquery/jquery.js?ver=1.11.2'></script>
<script type='text/javascript' src='http://<?php echo $_SERVER['HTTP_HOST']; ?>/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.2.1'></script>
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/wp-includes/wlwmanifest.xml" /> 



	<style type="text/css">.recentcomments a{display:inline !important;padding:0 !important;margin:0 !important;}</style>
<style type="text/css" media="print">#wpadminbar { display:none; }</style>
<style type="text/css" media="screen">
	html { margin-top: 32px !important; }
	* html body { margin-top: 32px !important; }
	@media screen and ( max-width: 782px ) {
		html { margin-top: 46px !important; }
		* html body { margin-top: 46px !important; }
	}
</style>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<div id="content" class="site-content">
		<?php
		if (get_current_user_id() == 0) {
			echo "Для просмотра доски объявлений Вы должны быть <a style='text-decoration: underline;' href='/wp-login.php'>авторизованы</a>";
			echo "</div>
			</div>
			</body>
			</html>";
			exit();
		}
		load_template( dirname( __FILE__ ) . '/get-user-info.php', true);

		?>