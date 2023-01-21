<?php include('inc-header.php'); ?>

<main class="section" id="middle" role="main">
	<div class="wrapper clearfix">

		<?php if (is_NewsArticle()) { // for single news article  ?>

			<section class="content">
				<article>
					<div id="breadcrumbs">				
						<h2 id="breadcrumb-title"><?php printNewsTitle(); ?></h2>
					</div>
					<div class="news-content"><?php printNewsContent(); ?></div>
					<?php if (getCodeBlock(1)) { ?><div class="codeblock"><?php printCodeblock(1); ?></div><?php } ?>
				</article>
			</section>
			<section class="sidebar">
				<nav class="news-nav clearfix">
					<?php if ($prev = getNextPrevNews('prev')) { ?>
						<a class="news-prev" href="<?php echo $prev['link']; ?>" title="<?php echo $prev['title']; ?>"><i class="fa fa-angle-left"></i>&nbsp;<?php echo gettext('Prev'); ?></a>
					<?php }
					if ($next = getNextPrevNews('next')) {
						?>
						<a class="news-next" href="<?php echo $next['link']; ?>" title="<?php echo $next['title']; ?>"><?php echo gettext('Next'); ?>&nbsp;<i class="fa fa-angle-right"></i></a>
					<?php } ?>
				</nav>
				<div class="news-info">
					<?php
					if (getNewsDate()) {
						?><span><i class="fa fa-calendar-o"></i>&nbsp;<?php printNewsDate(); ?>&nbsp;</span>
					<?php }
					if (function_exists('getCommentCount')) {
						?>
						<span><i class="fa fa-comments-o"></i>&nbsp;<?php echo gettext('Comments:') . ' ' . getCommentCount(); ?>&nbsp;</span>
					<?php } ?>
				<?php if (getNewsCategories()) { ?><span><?php printNewsCategories(', ', '', 'catlist'); ?></span><?php } ?>
				</div>
				<?php
				if (getNewsExtraContent()) {
					printNewsExtraContent();
				}			
				if (getTags()) {
					printTags('links', '', 'taglist', '');
				}					
				if (extensionEnabled('scriptless-socialsharing')) {
					scriptlessSocialsharing::printButtons(gettext('Share: '));
				}
				if (function_exists('printRating')) { ?>
					<div id="rating"><?php echo printRating(); ?></div><?php 
				} ?>
			</section>

				<?php } else { // for news article loops ?>

			<section class="content">
				<div id="breadcrumbs">
					<?php if (in_context(ZP_ZENPAGE_NEWS_DATE)) {
						printNewsIndexURL(null, '');
						echo ' / ';
						?>
						<h2 id="breadcrumb-title"><?php printCurrentNewsArchive(''); printCurrentPageAppendix(); ?></h2>
					<?php } else if (in_context(ZP_ZENPAGE_NEWS_CATEGORY)) {
						printNewsIndexURL(null, '');
						echo ' / ';
						?>
						<h2 id="breadcrumb-title"><?php printCurrentNewsCategory(''); ?></h2>
						<div id="category-description"><?php printNewsCategoryDesc(); ?></div>
						<?php } else { ?>
						<h2 id="breadcrumb-title"><?php echo gettext('News'); ?></h2>
						<?php } ?>
				</div>
						<?php while (next_news()): ?>
					<article class="news-clip">
						<h3><?php printNewsURL(); ?></h3>
						<div class="news-info">
							<span><i class="fa fa-calendar-o"></i>&nbsp;<?php printNewsDate(); ?>&nbsp;</span>
					<?php if (function_exists('getCommentCount')) { ?>
								<span><i class="fa fa-comments-o"></i>&nbsp;<?php echo gettext('Comments:') . ' ' . getCommentCount(); ?>&nbsp;</span>
		<?php } ?>
		<?php if (getNewsCategories()) { ?><span><?php printNewsCategories(', ', '', 'catlist'); ?></span><?php } ?>
						</div>
						<div class="news-content"><?php printNewsContent(); ?></div>
						<?php if (getCodeBlock(1)) { ?><div class="codeblock"><?php printCodeblock(1); ?></div><?php } ?>
					</article>
	<?php endwhile;
	printNewsPageListWithNav(gettext('next »'), gettext('« prev'), true, 'pagelist', true);
	?>
			</section>
			<section class="sidebar">

				<div class="sidebar-menu">
					<h3><?php echo gettext('News Categories'); ?></h3>
	<?php printAllNewsCategories(gettext('All News'), true, '', 'menu-active', true, 'submenu', 'menu-active'); ?>
				</div>

			<?php if (ZP_PAGES_ENABLED) { ?>
					<div class="sidebar-menu">
						<h3><?php echo gettext('Pages'); ?></h3>
		<?php printPageMenu('list', '', 'menu-active', 'submenu', 'menu-active'); ?>
					</div>
	<?php } ?>

			</section>

			<?php } ?>

	</div>
</main>

			<?php if ((is_NewsArticle()) && ((function_exists('printRelatedItems')) || (function_exists('printCommentForm')))) { ?>
	<aside class="section" id="bottom" role="complementary">
		<div class="wrapper clearfix">
			<?php if (function_exists('printCommentForm')) { ?>
				<section class="content">
					<?php callUserFunction('printCommentForm'); ?>
				</section>
				<?php if (function_exists('printRelatedItems')) { ?>
					<section class="sidebar">
			<?php printRelatedItems(5, 'news', null, null, true); ?>
					</section>
		<?php } ?>
	<?php } else { ?>
				<section class="content full">
		<?php printRelatedItems(5, 'news', null, null, true); ?>
				</section>
	<?php } ?>
		</div>
	</aside>
<?php }
include('inc-footer.php');
?>