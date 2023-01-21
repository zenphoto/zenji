<?php include('inc-header.php'); ?>

<main class="section" id="middle" role="main">
	<div class="wrapper clearfix">
		<section class="content">
			<article>
				<div id="breadcrumbs">
					<?php printZenpageItemsBreadcrumb('', ' / '); ?>
					<h2 id="breadcrumb-title"><?php printPageTitle(); ?></h2>
				</div>
				<?php
				printPageContent();
				printCodeblock(1);
				?>
			</article>
		</section>
		<section class="sidebar">
			<?php
			if (getPageExtraContent()) {
				printPageExtraContent();
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
			<div class="sidebar-menu">
				<h3><?php echo gettext('Pages'); ?></h3>
				<?php printPageMenu('list', '', 'menu-active', 'submenu', 'menu-active'); ?>
			</div>
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
					<?php printRelatedItems(5, 'pages', null, null, true); ?>
					</section>
					<?php } ?>
				<?php } else { ?>
				<section class="content full">
				<?php printRelatedItems(5, 'pages', null, null, true); ?>
				</section>
	<?php } ?>
		</div>
	</aside>
<?php }
include('inc-footer.php');
?>