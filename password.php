<?php include('inc-header.php'); ?>

	<main class="section" id="middle" role="main">
		<div class="wrapper clearfix">
			<section class="content full">
				<div id="breadcrumbs">
					<h2 id="breadcrumb-title"><?php echo gettext('Password Required') ?></h2>
				</div>
				<?php 
				if (zp_loggedin()) { 
					echo gettext('You are logged in.');
				} else { 
					printPasswordForm('',true,false); 
				}
				?>
			</section>
		</div>
	</main>
	
<?php include('inc-footer.php'); ?>