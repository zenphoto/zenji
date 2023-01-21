<?php
if (getOption('zj_archive')) {
	include('inc-header.php');
?>

	<main class="section" id="middle" role="main">
		<div class="wrapper clearfix">
			<section class="content full">

				<div id="breadcrumbs">
					<?php printParentBreadcrumb('', ' / ', ' / '); ?>
					<h2 id="breadcrumb-title"><?php echo gettext('Gallery Archive'); ?></h2>
				</div>

				<div id="archive"><?php printAllDates('archive', 'year', 'month', 'desc'); ?></div>

					<?php if (ZP_NEWS_ENABLED) { ?>
						<h2><?php echo gettext('News Archive'); ?></h2>
						<?php printNewsArchive('archive'); ?>
					<?php } ?>

					<div id="tag-cloud">
						<h2><?php echo gettext('Tags'); ?></h2>
						<?php printAllTagsAs('cloud', 'archive-cloud', null, true, true, 2, 50, 1); ?>
					</div>

			</section>
		</div>
	</main>

	<?php
	include('inc-footer.php');
} else {
	include(SERVERPATH . '/' . ZENFOLDER . '/404.php');
}
?>