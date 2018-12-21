<?php 
if (function_exists('printSlideShow')) {
include('inc-header.php'); ?>

	<main class="section" id="middle" role="main">
		<div class="wrapper clearfix">
			<section class="content full clearfix">
				<div id="slideshowpage" class="clearfix">
					<a href="#" id="fullscreenlink"><?php echo gettext('Fullscreen Toggle'); ?></a>
					<?php
					printSlideShow(true, true);
					?>
				</div>
			</section>
		</div>
	</main>

	<script>
// full-screen available?
if (
	document.fullscreenEnabled || 
	document.webkitFullscreenEnabled || 
	document.mozFullScreenEnabled ||
	document.msFullscreenEnabled
) {

	// image container
	var i = document.getElementById("slideshowpage");
	var link = document.getElementById("fullscreenlink");
	
	// click event handler
	link.onclick = function() {
	
		// in full-screen?
		if (
			document.fullscreenElement ||
			document.webkitFullscreenElement ||
			document.mozFullScreenElement ||
			document.msFullscreenElement
		) {

			// exit full-screen
			if (document.exitFullscreen) {
				document.exitFullscreen();
			} else if (document.webkitExitFullscreen) {
				document.webkitExitFullscreen();
			} else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			} else if (document.msExitFullscreen) {
				document.msExitFullscreen();
			}
		
		}
		else {
		
			// go full-screen
			if (i.requestFullscreen) {
				this.requestFullscreen();
			} else if (i.webkitRequestFullscreen) {
				i.webkitRequestFullscreen();
			} else if (i.mozRequestFullScreen) {
				i.mozRequestFullScreen();
			} else if (i.msRequestFullscreen) {
				i.msRequestFullscreen();
			}
		
		}
	
	}

}
</script>

<?php 
include('inc-footer.php');
} else {
include(SERVERPATH . '/' . ZENFOLDER . '/404.php');
} ?>