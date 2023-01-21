<?php
// Show only favorite lists if multi option on favorites page
if (($_zp_gallery_page == 'favorites.php') && (getOption('favorites_multi'))) { ?>
	<div id="favorites-box">
		<div id="favorites-title"><i class="fa fa-heart"></i> <?php echo gettext('Favorites'); ?></div>
	<?php printFavoritesURL(null, '', '', ''); ?>	
	</div>
<?php } else { ?>
	<div id="favorites-box">
		<div id="favorites-title"><i class="fa fa-heart"></i> <?php echo gettext('Favorites'); ?></div>
		<?php
		if ($_zp_gallery_page == 'album.php') {
			$current = $_zp_current_album;
		} elseif ($_zp_gallery_page == 'image.php') {
			$current = $_zp_current_image;
		} else {
			$current = null;
		}

		if ($current) {
			printAddToFavorites($current);
			?>
		<?php if (getOption('favorites_multi')) { ?>
				<div id="favorites_help">
					<i class="fa fa-question-circle"></i> <em><?php echo gettext('To add to a specific favorites list, type it in the input box before clicking add favorite.'); ?></em>
				</div>
			<?php
			}
		}
		?>

	<?php printFavoritesURL(null, '', '', ''); ?>	
	</div>
<?php } ?>