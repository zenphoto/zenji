<?php include('inc-header.php'); ?>

<main class="section" id="middle" role="main">
	<div class="wrapper clearfix">
		<section class="content">
			<div id="albums">
				<?php while (next_album()): ?>
					<div class="album">
						<div class="thumb">
							<a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php printAnnotatedAlbumTitle(); ?>">
								<?php
								// get custom sizes for landscape option
								$customthumbwidth = (getOption('zj_maxwidth')) / (getThemeOption('albums_per_row'));
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
					</div>
			<?php endwhile; ?>
			</div>
<?php printPageListWithNav("« " . gettext("prev"), gettext("next") . " »"); ?>
		</section>
		<section class="sidebar">
			<div id="description"><?php printGalleryDesc(); ?></div>
			<?php
			if (extensionEnabled('scriptless-socialsharing')) {
				scriptlessSocialsharing::printButtons(gettext('Share: '));
			}
			if (ZP_NEWS_ENABLED) { ?>
				<div class="sidebar-menu">
					<h4><?php echo gettext('Latest News'); ?></h4>
				<?php printLatestNews(1, '', true, true, 120, false, null, true); ?>
				</div>
			<?php } ?>
<?php if (function_exists('printAddToFavorites')) include ('inc-favorites.php'); ?>
			<div id="album-jump"><?php if (function_exists('printAlbumMenu')) printAlbumMenu('jump', 'count'); ?></div>
		</section>
	</div>
</main>

<?php include('inc-footer.php'); ?>