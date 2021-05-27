<footer class="section" id="footer" role="contentinfo">
	<div class="wrapper clearfix">
		<div class="content full">
			<?php @call_user_func('printLanguageSelector'); ?>
			<?php
			echo getOption('zj_copy') . ' · ';
			if (class_exists('RSS'))
				printRSSLink('Gallery', '', 'RSS', ' · ', false, 'rss-link');
			if (extensionEnabled('contact_form')) {
				printCustomPageURL(gettext('Contact us'), 'contact', '', '', ' · ');
			}
			printZenphotoLink();
			?>
			<div id="footer-login">
				<?php
				@call_user_func('printUserLogin_out', '', '', 0);
				if (!zp_loggedin() && function_exists('printRegisterURL')) {
					printRegisterURL(gettext('Register for this site'), '', '');
				}
				?>
			</div>
		</div>
	</div>	
</footer>

<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>