<?php include('inc-header.php'); ?>

<main class="section" id="middle" role="main">
	<div class="wrapper clearfix">
		<section class="content">

			<div id="breadcrumbs">
				<?php printParentBreadcrumb('', ' / ', ' / '); ?>
				<h3 id="breadcrumb-title"><?php printAlbumTitle(); ?></h3>
			</div>

			<div id="albums">
				<?php while (next_album()): ?>
					<article class="album">
						<div class="thumb">
							<a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php printAnnotatedAlbumTitle(); ?>">
								<?php
								// get custom sizes for landscape option
								$customthumbwidth = (getOption('zj_maxwidth')) / (getOption('albums_per_row'));
								$customthumbheight = $customthumbwidth / 2;
								// print album thumb based on theme option
								if (getOption('zj_albumthumb') == 'square') {
									printCustomAlbumThumbImage(getAnnotatedAlbumTitle(), null, $customthumbwidth, $customthumbwidth, $customthumbwidth, $customthumbwidth);
								} else if (getOption('zj_albumthumb') == 'landscape') {
									printCustomAlbumThumbImage(getAnnotatedAlbumTitle(), null, $customthumbwidth, $customthumbheight, $customthumbwidth, $customthumbheight);
								} else {
									printAlbumThumbImage(getAnnotatedAlbumTitle());
								}
								?>
								<div class="album-title"><?php printAlbumTitle(); ?></div>
								<?php if (getAlbumDate()) { ?><div class="album-date"><i class="fa fa-calendar-o"></i>&nbsp;<?php printAlbumDate(''); ?></div><?php } ?>
								<div class="album-desc"><?php echo strip_tags(truncate_string(getAlbumDesc(), 120, '...')); ?></div>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<div id="images">
				<?php while (next_image()): ?>
					<article class="image">
						<div class="thumb">
							<a href="<?php echo html_encode(getImageURL()); ?>" title="<?php printBareImageTitle(); ?>">
								<?php printImageThumb(getAnnotatedImageTitle()); ?>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php printPageListWithNav('« ' . gettext('Prev'), gettext('Next') . ' »'); ?>

		</section>
		<section class="sidebar">
			<div class="album-info">
				<span><i class="fa fa-image"></i>
					<?php
					$albumcount = getNumAlbums();
					$imagecount = getNumImages();
					if ($albumcount)
						echo $albumcount . ' ' . gettext('Subalbums');
					if (($albumcount) && ($imagecount))
						echo ', '; // if both, print out divider
					if ($imagecount)
						echo $imagecount . ' ' . gettext('Images');
					?>
				</span>
				<?php if (getAlbumDate()) { ?><span><i class="fa fa-calendar-o"></i>&nbsp;<?php printAlbumDate(); ?></span><?php } ?>
				<?php if (function_exists('getCommentCount')) { ?>
					<span><i class="fa fa-comments-o"></i>&nbsp;<?php echo gettext('Comments:') . ' ' . getCommentCount(); ?></span>
				<?php } ?>
			</div>

			<div id="description"><?php printAlbumDesc(); ?></div>
			<?php if (getTags()) printTags('links', '', 'taglist', ''); ?>

			<div class="button-group">
				<?php
				if (function_exists('printGoogleMap'))
					printGoogleMap(gettext('Show Map'), 'google-map-link', 'colorbox');
				if (class_exists('RSS'))
					printRSSLink($rss_option, '', $rss_title, '', false, 'rss-link');
				@call_user_func('printSlideShowLink');
				?>
			</div>
			<?php
			if (extensionEnabled('scriptless-socialsharing')) {
				scriptlessSocialsharing::printButtons(gettext('Share: '));
			}
			if (function_exists('printAddToFavorites'))
				include ('inc-favorites.php');
			if (function_exists('printRating')) {
				?><div id="rating"><?php echo printRating(); ?></div>
			<?php }
			?>
			<div id="album-jump"><?php if (function_exists('printAlbumMenu')) printAlbumMenu('jump', 'count'); ?></div>
		</section>
	</div>
</main>

<?php if ((function_exists('printRelatedItems')) || (function_exists('printCommentForm'))) { ?>
	<aside class="section" id="bottom" role="complementary">
		<div class="wrapper clearfix">
				<?php if (function_exists('printCommentForm')) { ?>
				<section class="content">
				<?php @call_user_func('printCommentForm'); ?>
				</section>
					<?php if (function_exists('printRelatedItems')) { ?>
					<section class="sidebar">
					<?php printRelatedItems(5, 'albums', null, null, true); ?>
					</section>
				<?php } ?>
				<?php } else { ?>
				<section class="content full">
				<?php printRelatedItems(5, 'albums', null, null, true); ?>
				</section>
	<?php } ?>
		</div>
	</aside>
<?php } ?>

<?php include('inc-footer.php'); ?>