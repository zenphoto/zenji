<?php 
if ((getOption('zj_search')) || (getOption('zj_archive'))) {

$zenpagecount = 0;
$numimages = getNumImages();
$numalbums = getNumAlbums();
$total = $numimages + $numalbums;
if ($total > 0) { $showpag = true; } else { $showpag = false; }
if ($zenpage && !isArchive()) {
	$numpages = getNumPages();
	$numnews = getNumNews();
	$zenpagecount = $numpages + $numnews;
	$total = $total + $zenpagecount;
} else {
	$numpages = $numnews = 0;
}
if ($total == 0) { $_zp_current_search->clearSearchWords(); }

include('inc-header.php'); ?>

	<main class="section" id="middle" role="main">
		<div class="wrapper clearfix">
			<section class="content">
				
				<div id="breadcrumbs">
					<?php printSearchBreadcrumb(' / '); ?>
					<h2 id="breadcrumb-title"><?php echo gettext('Search Results'); printCurrentPageAppendix(); ?></h2>
				</div>

				<div id="albums">
					<?php while (next_album()): ?>
					<article class="album">
						<div class="thumb">
							<a href="<?php echo html_encode(getAlbumURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php printAnnotatedAlbumTitle(); ?>">
								<?php 
								// get custom sizes for landscape option
								$customthumbwidth = (getOption('zj_maxwidth')) / (getThemeOption('albums_per_row'));
								$customthumbheight = $customthumbwidth / 2;
								// print album thumb based on theme option
								if (getOption('zj_albumthumb') == 'square') {
									printCustomAlbumThumbImage(getAnnotatedAlbumTitle(),null,$customthumbwidth,$customthumbwidth,$customthumbwidth,$customthumbwidth);
								} else if (getOption('zj_albumthumb') == 'landscape') {
									printCustomAlbumThumbImage(getAnnotatedAlbumTitle(),null,$customthumbwidth,$customthumbheight,$customthumbwidth,$customthumbheight);
								} else {
									printAlbumThumbImage(getAnnotatedAlbumTitle()); 
								} ?>
								<div class="album-title"><?php printAlbumTitle(); ?></div>
								<?php if (getAlbumDate()) { ?><div class="album-date"><i class="fa fa-calendar-o"></i>&nbsp;<?php printAlbumDate(''); ?></div><?php } ?>
								<div class="album-desc"><?php echo strip_tags(truncate_string(getAlbumDesc(),120,'...')); ?></div>
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

				<?php if (($showpag) && ((hasNextPage()) || (hasPrevPage()))) {printPageListWithNav("« " . gettext("prev"), gettext("next") . " »");} ?>
				
				<?php if (($zenpage) && ($zenpagecount > 0) && ($_zp_page == 1)) { ?>
			
				<?php if ($numpages > 0) { ?>
				<div class="zp-pages">
					<?php while (next_page()) { ?>
					<article class="news-clip">
						<h3><a href="<?php echo html_encode($_zp_current_zenpage_page->getLink()); ?>"><?php printPageTitle(); ?></a></h3>
						<div class="news-content"><?php echo shortenContent(strip_tags(getPageContent()),180,getOption('zenpage_textshorten_indicator')); ?></div>
					</article>
					<?php } ?>
				</div>
				<?php } ?>
			
				<?php if ($numnews > 0) { ?>
				<div class="zp-news">
					<?php while (next_news()) { ?>
					<article class="news-clip">
						<h3><?php printNewsURL(); ?></h3>
						<div class="news-info">
							<span><i class="fa fa-calendar-o"></i>&nbsp;<?php printNewsDate(); ?>&nbsp;</span>
							<?php if (function_exists('getCommentCount')) { ?>
							<span><i class="fa fa-comments-o"></i>&nbsp;<?php echo gettext('Comments:').' '.getCommentCount(); ?>&nbsp;</span>
							<?php } ?>
							<?php if (getNewsCategories()) { ?><span><?php printNewsCategories(', ','','catlist'); ?></span><?php } ?>
						</div>
						<div class="news-content"><?php echo shortenContent(strip_tags(getNewsContent()),180,getOption('zenpage_textshorten_indicator')); ?></div>
						<?php if (getCodeBlock(1)) { ?><div class="codeblock"><?php printCodeblock(1); ?></div><?php } ?>
						<?php if (getTags()) {printTags('links','','taglist','');} ?>
					</article>
					<?php } ?>
				</div>
				<?php } ?>
			
				<?php } ?>
			
			</section>
			
			<section class="sidebar">
				<?php
				$searchwords = getSearchWords();
				$searchdate = getSearchDate();
				if (!empty($searchdate)) {
					if (!empty($searchwords)) {
						$searchwords .= ": ";
					}
					$searchwords .= $searchdate;
				}
				if ($total > 0 ) { ?>
				<div id="description"><?php printf(ngettext('%1$u Hit for <em>%2$s</em>','%1$u Hits for <em>%2$s</em>',$total), $total, html_encode($searchwords));?></div>
				<?php 
				} else { ?>
				<div id="description"><?php echo gettext('Sorry, no matches found. Try refining your search.'); ?></div>
				<?php } 
				if (extensionEnabled('scriptless-socialsharing')) {
					scriptlessSocialsharing::printButtons(gettext('Share: '));
				}
				if (function_exists('printAddToFavorites')) {
					include ('inc-favorites.php');
				}
				
				if (function_exists('printRating')) {
					?><div id="rating"><?php echo printRating(); ?></div><?php } ?>
				<div id="album-jump"><?php if(function_exists('printAlbumMenu')) {printAlbumMenu('jump','count');} ?></div>
			</section>
			
		</div>
	</main>

<?php 
include('inc-footer.php');
} else {
include(SERVERPATH . '/' . ZENFOLDER . '/404.php');
} ?>