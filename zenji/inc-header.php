<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) {
die();
}
// Set some default variables
$galleryactive = false; // determine if "Gallery" menu item should be active (highlighted)
$rss_option = 'Gallery'; // default RSS option - latest gallery images
$rss_title = gettext('RSS Gallery Images'); // default RSS Title - to go along with above.
$metadesc = truncate_string(getBareGalleryDesc(),150,'...'); // default meta description is gallery description, is modified on album, image, news, etc pages
$ssheight = '';

// Set some things depending on what page we are on...
switch ($_zp_gallery_page) {
	case 'index.php':
		$galleryactive = true;
		break;
	case 'album.php':
		$metadesc = truncate_string(getBareAlbumDesc(),150,'...');
		$galleryactive = true;
		$rss_option = 'Collection'; $rss_title = gettext('RSS Album Images'); // switch RSS to the album images
		break;
	case 'image.php':
		$metadesc = truncate_string(getBareImageDesc(),150,'...');
		$galleryactive = true;
		break;
	case 'pages.php':
		$metadesc = strip_tags(truncate_string(getPageContent(),150,'...'));
		$rss_option = 'Pages'; $rss_title = gettext('RSS Pages');
		break;
	case 'slideshow.php':
		// add some room for controls, title, and descriptions
		$add = 200;
		if (extensionEnabled('slideshow2')) {
			$ssheight = getOption('slideshow_height') + $add;
		} else {
			$ssheight = getOption('cycle-slideshow_height') + $add;
		}
		break;
	case 'news.php':
		$rss_option = 'News'; $rss_title = gettext('RSS News');
		if (is_NewsArticle()) {
		$metadesc = strip_tags(truncate_string(getNewsContent(),150,'...'));
		} else if ($_zp_current_category) {
		$metadesc = strip_tags(truncate_string(getNewsCategoryDesc(),150,'...'));
		$rss_option = 'Category'; $rss_title = gettext('RSS News Category');
		} else if (getCurrentNewsArchive()) {
		$metadesc = getCurrentNewsArchive().' '.gettext('News Archive').'... '.truncate_string(getBareGalleryDesc(),130,'...');
		} else {
		$metadesc = gettext('News').'... '.truncate_string(getBareGalleryDesc(),130,'...');
		}
		break;
	default:
		$metadesc = truncate_string(getBareGalleryDesc(),150,'...');
		break;
} ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php echo LOCAL_CHARSET; ?>">
	<?php
	zp_apply_filter('theme_head');
	printHeadTitle();
	if ((class_exists('RSS')) && ($rss_option != null)) {printRSSHeaderLink($rss_option,$rss_title);}
	?>

	<meta name="description" content="<?php echo $metadesc; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fontawesome/css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/css/core.css">
	<?php if ((getOption('zj_style') != 'minimal')) { ?>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/css/<?php echo getOption('zj_style'); ?>.css">
	<?php } ?>

	<!--[if lt IE 9]>
	<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/r29/html5.min.js"></script>
	<![endif]-->

	<script>
	// Mobile Menu
	$(function() {
		var navicon = $('#nav-icon');
		var menu = $('#nav');
		var menuHeight	= menu.height();
		$(navicon).on('click', function(e) {
			e.preventDefault();
			menu.slideToggle();
		});
		$(window).resize(function(){
        	var w = $(window).width();
        	if(w > 320 && menu.is(':hidden')) {
        		menu.removeAttr('style');
        	}
    	});
	});

	$(document).ready(function(){
		// remove width and height attributes in the img tag if present so that they can be scaled/responsive.
		$('img').each(function(){
			$(this).removeAttr('width')
			$(this).removeAttr('height');
		});
	});

	</script>

	<!-- enter favicon stuff from generator -->


	<?php
	// determine column widths based on options set for albums and images per row.
	$albumgridwidth = (100/getOption('albums_per_row'))-1; // the minus 1 is to account for horizontal space on inline elements.
	$imagegridwidth = (100/getOption('images_per_row'))-1;
	?>
	<style>
	@media (min-width: 600px) {
		.album{width:<?php echo $albumgridwidth; ?>%;max-height:<?php echo $albumgridwidth; ?>%;}
		.image{width:<?php echo $imagegridwidth; ?>%;max-height:<?php echo $imagegridwidth; ?>%;}
	}
	<?php
	// set max-width of the site (.wrapper div) from the options ?>
	.wrapper{max-width:<?php echo getOption('zj_maxwidth'); ?>px;}
	<?php
	// print css for link color chosen in options
	if (getOption('zj_linkcolor') != null) {echo '
		a,body.modern #nav li.active a,body.modern #nav li a.active,body#dark.modern #nav li.active a,body#dark.modern #nav li a.active
			{color:'.getOption('zj_linkcolor').';}
		.button,body.modern .sidebar .button-group a,body.modern .img-nav,body.modern .news-nav
			{background:'.getOption('zj_linkcolor').';}
	';} ?>
	<?php
	// print custom css from theme options if present
	if (getOption('zj_customcss') != null) {echo getOption('zj_customcss');} ?>

	<?php
	// if on slideshow page need to set show height
	if ($ssheight) {echo '.slideshow{height:'.$ssheight.'px;}#slideshowpage{height:'.$ssheight.'px;}';}?>
	</style>

</head>

<body id="<?php echo getOption('zj_color'); ?>" class="<?php echo getOption('zj_style'); ?>">
	<?php zp_apply_filter('theme_body_open'); ?>

	<header class="section" id="top">
		<div class="wrapper clearfix">
			<div class="content full">
				<div id="logo">
					<?php if (getOption('zj_logo') != '') { ?>
					<h1 id="image-logo"><a href="<?php echo html_encode(getGalleryIndexURL()); ?>"><img src="<?php echo pathurlencode(WEBPATH.'/'.UPLOAD_FOLDER.'/'.getOption('zj_logo')); ?>" alt="<?php printGalleryTitle(); ?>"></a></h1>
					<?php } else { ?>
					<h1><a href="<?php echo html_encode(getGalleryIndexURL()); ?>"><?php printGalleryTitle(); ?></a></h1>
					<?php } ?>
				</div>
				<nav id="main-nav" role="navigation">
					<?php if (getOption('zj_search')) {
						printSearchForm('','search',$_zp_themeroot.'/images/search.png',gettext('Search'),$_zp_themeroot.'/images/list.png');
					} ?>
					<ul id="nav">
						<?php if ($_zp_gallery->getParentSiteURL()) { ?>
						<li><?php printHomeLink(); ?><li>
						<?php } ?>
						<li <?php if ($galleryactive) { ?>class="active" <?php } ?>>
							<a href="<?php echo html_encode(getGalleryIndexURL()); ?>" title="<?php echo gettext('Gallery'); ?>"><?php echo gettext('Gallery'); ?></a>
						</li>
						<?php if (ZP_NEWS_ENABLED && getNumNews(true) > 0) { ?>
						<li <?php if ($_zp_gallery_page == "news.php") { ?>class="active" <?php } ?>>
							<a href="<?php echo getNewsIndexURL(); ?>"><?php echo gettext('News'); ?></a>
						</li>
						<?php } ?>
						<?php if (ZP_PAGES_ENABLED) {printPageMenu('list-top','','active','submenu','active','',0,false);} ?>
						<?php if (getOption('zj_archive')) { ?>
						<li <?php if (($_zp_gallery_page == "archive.php") || ($_zp_gallery_page == "search.php")) { ?>class="active" <?php } ?>>
							<a href="<?php echo getCustomPageURL('archive'); ?>" title="<?php echo gettext('Archive'); ?>"><?php echo gettext('Archive'); ?></a>
						</li>
						<?php } ?>
						<?php if (function_exists('printContactForm')) { ?>
						<li <?php if ($_zp_gallery_page == "contact.php") { ?>class="active" <?php } ?>>
							<?php printCustomPageURL(gettext('Contact'),"contact"); ?>
						</li>
						<?php } ?>
					</ul>
					<a href="#" id="nav-icon"><i class="fa fa-navicon"></i></a>
				</nav>
			</div>
		</div>
	</header>