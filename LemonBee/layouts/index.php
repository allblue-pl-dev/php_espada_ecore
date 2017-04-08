<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="<?php echo $images->favicon; ?>" rel="shortcut icon" type="image/vnd.microsoft.icon" />
        <link rel="apple-touch-icon" href="<?php echo $images->appleTouchIcon; ?>" />

        <?php $eHolders->header; ?>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php $eHolders->init; ?>

        <?php if ($layout === 'panel'): ?>
            <div class="fill background_main"></div>
          	<div class="container <?php echo $panelClass; ?>">
                <div class="col-sm-6 logo">
                    <a href="<?php echo E\Uri::Base(); ?>">
                        <img src="<?php echo E\Uri::File('LemonBee:images/logo_main.png'); ?>" />
                    </a>
                </div>

                <?php $eHolders->userInfo; ?>
          		<div class="clear"></div>
          		<?php $eHolders->topMenu; ?>
          		<div class="content">
                    <div class="clear"></div>
          			<?php $eHolders->content; ?>
          		</div>
				<div class="shadow"></div>
              	<div class="povered_by pull-right">
              		Powered by <a href="http://allblue.pl">AllBlue</a>
              	</div>
            </div>
        <?php elseif ($layout === 'logIn'): ?>
            <div class="fill background_login"></div>
            <div class="col-lg-4 col-md-6 col-sm-8 login">
            	<div class="login_content">

            		<div class="login_logo  col-sm-8 col-sm-offset-2">
            			<img src="<?php echo E\Uri::File('LemonBee:images/logo.png'); ?>" />
            		</div>
            		<div class="clear"></div>
            		<?php $eHolders->content; ?>

            		<div class="clear"></div>
            	</div>
            	<div class="shadow"></div>
            	<div class="povered_by pull-right">
            		Powered by <a href="https://allblue.pl">AllBlue</a>
            	</div>
            </div>
        <?php else: ?>
            Unknown layout.
        <?php endif; ?>

        <?php $eHolders->debug; ?>
    </body>
</html>
