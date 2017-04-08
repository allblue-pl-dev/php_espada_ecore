<div class="menu_top">
	<a href="<?php echo $homeLink; ?>"><i class="fa fa-home"> </i></a>
	<?php foreach ($menuItems as $item): ?>
		/<a href="<?php echo $item->uri; ?>">
            <?php echo $item->title; ?>&nbsp;
        </a>
	<?php endforeach; ?>
</div>
