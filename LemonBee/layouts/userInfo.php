<div class="lb-user-info">
    <a href="<?php echo $uris->userInfo; ?>" class="mg-spacer-right">
        <img src="<?php echo E\Uri::File('LemonBee:images/user.png'); ?>" alt="user" />
        <?php echo $login; ?>
    </a>
    |
    <a class="mg-spacer-left" href="<?php echo $uris->logOut; ?>">
        <?php echo EC\HText::_('LemonBee:userInfo_LogOut'); ?>
        <i class="fa fa-sign-out" aria-hidden="true"></i>
    </a>
</div>
