<div class="col-sm-6 user_info">
	<i class="fa fa-user"></i>
    <a href="<?php echo $uris->userInfo; ?>">
        <?php echo $login; ?>
    </a> /
    <a href="<?php echo $uris->logOut; ?>">
        <?php echo EC\HText::_('LemonBee:userInfo_LogOut'); ?>
    </a>
</div>
