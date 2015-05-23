<!DOCTYPE HTML>
<html lang="en-US">
    <head>
        <meta charset="UTF-8">
        <title><?php echo empty($this->title) ? 'Допомога Україні' : $this->title; ?></title>
        
        <link rel="stylesheet/less" type="text/css" href="<?php echo document::_()->getTemplatesUrl(). '/style.less'; ?>" />
        <?php
            if(!empty($this->scripts)) echo $this->scripts;
            if(!empty($this->styles)) echo $this->styles;
        ?>
        
        <link rel="icon" href="<?php echo URL_ROOT.'/favicon.ico'; ?>" type="image/x-icon">
        <link rel="shortcut icon" href="<?php echo URL_ROOT.'/favicon.ico'; ?>" type="image/x-icon">
    </head>
	<body>
        <div class="header">
            <div class="container">
				<div class="col-md-12 nopadding">
                    <?php if(rs('user.isLoggedIn')) { ?>
                        <div class="pull-right logged-user">
                            <?php $user = rs('user.model.getLoggedIn'); ?>
                            Ви увійшли як <a href="<?php echo uri::getLink('user/profile'); ?>"><?php echo $user['login']; ?></a>. <a href="<?php echo uri::getLink('user/logout') ?>">Вийти?</a>
                        </div>
                    <?php } else { ?>
                        <div class="pull-right logged-user">
                            <a href="<?php echo uri::getLink( LOGIN_ALIAS ); ?>">Вхід</a>
                        </div>
                    <?php } ?>
                
					<h1>Допоможи Україні</h1>
					<span>стань волонтером вже сьогодні</span>
					<div class="clearfix"></div>
					<div class="registration">
						<div class="inner">
							<div class="help-types">
                                <?php rs('help_types_widget.view.showWidget')?>
							</div>
						</div>
					</div>
				</div>
                <div class="clearfix"></div>
            </div>
        </div>
                
        <div class="container">
			<?php rs('categories_widget.view.showWidget')?><br />
			<?php rs('locations_widget.view.showWidget')?><br />
			<br />
            <?php echo $this->content;?>
            <div class="clearfix"></div>
        </div>
    		
       <?php echo $this->footer;?>
        
        <div class="modal fade" id="after_add">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                
                </div>
            </div>
        </div>
	</body>
</html>