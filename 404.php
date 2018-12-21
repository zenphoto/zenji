<?php include('inc-header.php'); ?>

<main class="section" id="middle" role="main">
	<div class="wrapper clearfix">
		<section class="content full">
			<div id="breadcrumbs">
				<h2 id="breadcrumb-title"><?php echo gettext("404 - Page not found"); ?></h2>
			</div>
			<?php print404status(isset($album) ? $album : NULL, isset($image) ? $image : NULL, $obj); ?>
		</section>
	</div>
</main>

<?php include('inc-footer.php'); ?>