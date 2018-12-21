<?php
if (function_exists('printContactForm')) {
	include('inc-header.php');
	?>

	<main class="section" id="middle" role="main">
		<div class="wrapper clearfix">
			<section class="content full">
				<div id="breadcrumbs">
					<h2 id="breadcrumb-title"><?php echo gettext('Contact Us'); ?></h2>
				</div>
	<?php printContactForm(); ?>
			</section>
		</div>
	</main>

	<?php
	include('inc-footer.php');
} else {
	include(SERVERPATH . '/' . ZENFOLDER . '/404.php');
}
?>