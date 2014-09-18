<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta name="google-site-verification" content="2YQM0EHlMvytlg46idJaYb97cUlf_tBrYvwH02sHgeY" />
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta description="<?php bloginfo('description') ?>" />
<meta name="msvalidate.01" content="1CAE8A91A8F3DE3AD487C7E6C1DE3C30" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="icon" type="image/png" href="<?php bloginfo('template_directory') ?>/images/favicon.ico" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php
// Loads specfic CSS overrides based on browser type.
//wp_load_browser_css();
// ClearType for embedded fonts on IE (http://allcreatives.net/jquery-plugin-ie-font-face-cleartype-fix/)
wp_enqueue_script('jquery', get_option( 'siteurl' ) . '/wp-includes/js/jquery/jquery.js', false, '1.3.2');
wp_enqueue_script('iefontfix', get_bloginfo('template_url') . '/js/IEffembedfix.jQuery.js', false, '0.1');
// Default Wordpress Header Information
wp_head();
?>
	<!-- <script src="<?php bloginfo('template_directory') ?>/js/jquery.js" type="text/javascript" charset="utf-8"></script> -->
	<script src="<?php bloginfo('template_directory') ?>/js/easySlider1.7.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
	
	 var $j = jQuery.noConflict();

	$j(document).ready(function(){	
			$j("#slideshow").easySlider({
				prevText: '',
				nextText: '',
				continuous: true,
				auto: true,
				pause: 5000 
			});
	});	
	
	</script>	

	<!-- Google Analytics - Won't show/track if user is logged in or if site resides on DEV server -->
	<?php if (!is_user_logged_in() && !in_array("a4dev1", explode("/", $_SERVER['DOCUMENT_ROOT']))){?>
		<script type="text/javascript">
		
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-12840537-2']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
		</script>
	<?php } ?>
</head>
<body <?php body_class(); ?>>
<!--[if lte IE 6]><script src="<?php bloginfo('stylesheet_directory') ?>/js/ie6Update/warning.js"></script><script>window.onload=function(){e("<?php bloginfo('stylesheet_directory') ?>/js/ie6Update/")}</script><![endif]-->
	
<div id="outerwrap">
<div id="wrapper" class="hfeed">

	<div id="header">
		<div id="logo">
			<a href="<?php bloginfo('url'); ?>">&nbsp;</a>
		</div>
		<div id="social">
			<a href="/our-team/contact-us/">&nbsp;</a>
			<a href="https://www.facebook.com/taliesyhomesnw" target="_blank">&nbsp;</a>
			<a href="http://twitter.com/TALiesyHomes" target="_blank">&nbsp;</a>
		</div>

<!--
   <div id="menu"><ul><li><a href="/">Home</a></li><li class="cat-item cat-item-3"><a href="http://taliesyhomesnw.com/current-projects/" title="View all posts filed under Current Projects">Current Projects</a><ul class='children'><li class="cat-item cat-item-10"><a href="http://taliesyhomesnw.com/current-projects/frentress-heights/" title="View all posts filed under Frentress Heights">Frentress Heights</a></li><li class="cat-item cat-item-11"><a href="http://taliesyhomesnw.com/current-projects/sandy-bluff/" title="View all posts filed under Sandy Bluff">Sandy Bluff</a></li><li class="cat-item cat-item-5"><a href="http://taliesyhomesnw.com/current-projects/southern-ridge/" title="View all posts filed under Southern Ridge">Southern Ridge</a></li><li class="cat-item cat-item-4"><a href="http://taliesyhomesnw.com/current-projects/timberline-trails/" title="View all posts filed under Timberline Trails">Timberline Trails</a></li></ul></li><li class="cat-item cat-item-6"><a href="http://taliesyhomesnw.com/gallery-of-homes/" title="View all posts filed under Gallery of Homes">Gallery of Homes</a></li><li class="cat-item cat-item-7 current-cat"><a href="http://taliesyhomesnw.com/about-us/" title="View all posts filed under About">About</a></li><li class="cat-item cat-item-8"><a href="http://taliesyhomesnw.com/financing/" title="View all posts filed under Financing">Financing</a></li><li class="cat-item cat-item-9"><a href="http://taliesyhomesnw.com/contact/" title="View all posts filed under Contact">Contact</a></li></ul></div>
-->

<div id="menu">
	<?php wp_nav_menu(); ?>
</div>

	</div><!--  #header -->