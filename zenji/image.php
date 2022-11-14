<?php include('inc-header.php'); ?>

<main class="section" id="middle" role="main">
	<div class="wrapper clearfix">
		<section class="content">
			<div id="breadcrumbs">
				<?php
				printParentBreadcrumb('', ' / ', ' / ');
				printAlbumBreadcrumb('', ' / ');
				?>
				<h3 id="breadcrumb-title"><?php printImageTitle(); ?></h3>
			</div>

			<article id="full-image">
			<?php printDefaultSizedImage(''); ?>
			</article>
<?php if (function_exists('printThumbNav')) printThumbNav(); ?>

		</section>
		<section class="sidebar">
			<nav class="img-nav clearfix">
				<?php if (hasPrevImage()) { ?>
					<a class="img-prev" href="<?php echo html_encode(getPrevImageURL()); ?>" title="<?php echo gettext("Previous Image"); ?>"><i class="fa fa-angle-left icon-before"></i><?php echo gettext('Prev'); ?></a>
				<?php } ?>
				<span class="img-number"><?php echo ImageNumber(); ?> of <?php echo getNumImages(); ?></span>
				<?php if (hasNextImage()) { ?>
					<a class="img-next" href="<?php echo html_encode(getNextImageURL()); ?>" title="<?php echo gettext("Next Image"); ?>"><?php echo gettext('Next'); ?><i class="fa fa-angle-right icon-after"></i></a>
<?php } ?>
			</nav>

			<div class="image-info">
				<?php if (getImageDate()) {
					?><span><i class="fa fa-calendar-o"></i>&nbsp;<?php printImageDate(); ?></span>
					<?php
				}
				if (function_exists('getCommentCount')) {
					?>
					<span><i class="fa fa-comments-o"></i>&nbsp;<?php echo gettext('Comments:') . ' ' . getCommentCount(); ?></span>
<?php } ?>
			</div>
			<div id="description"><?php printImageDesc(); ?></div>
			<?php
			if (getTags())
				printTags('links', '', 'taglist', '');
			if (getOption('zj_imagemeta'))
				printImageMetadata('', false);
			?>
			<div class="button-group">
				<?php
				if (function_exists('printGoogleMap'))
					printGoogleMap(gettext('Show Map'), 'google-map-link', 'colorbox');
				if (getOption('zj_download')) {
					?><a id="download-button" href="<?php echo html_encode(getFullImageURL()); ?>" title="<?php echo gettext('Download'); ?>"><?php echo gettext('Download') . ' (' . getFullWidth() . ' x ' . getFullHeight() . ')'; ?></a><?php } ?>
			<?php callUserFunction('printSlideShowLink'); ?>
			</div>
			<?php
			if (extensionEnabled('scriptless-socialsharing')) {
				scriptlessSocialsharing::printButtons(gettext('Share: '));
			}
			if (function_exists('printAddToFavorites'))
				include ('inc-favorites.php');
			if (function_exists('printRating')) {
				?><div id="rating"><?php echo printRating(); ?></div><?php } ?>
			<div id="album-jump"><?php if (function_exists('printAlbumMenu')) printAlbumMenu('jump', 'count'); ?></div>
		</section>
	</div>
</main>

<?php if ((function_exists('printRelatedItems')) || (function_exists('printCommentForm'))) { ?>
	<aside class="section" id="bottom" role="complementary">
		<div class="wrapper clearfix">
				<?php if (function_exists('printCommentForm')) { ?>
				<section class="content">
				<?php callUserFunction('printCommentForm'); ?>
				</section>
					<?php if (function_exists('printRelatedItems')) { ?>
					<section class="sidebar">
					<?php printRelatedItems(5, 'images', null, null, true); ?>
					</section>
					<?php
				}
			} else {
				?>
				<section class="content full">
				<?php printRelatedItems(5, 'images', null, null, true); ?>
				</section>
	<?php } ?>
		</div>
	</aside>
<?php } ?>

<?php include('inc-footer.php'); ?>