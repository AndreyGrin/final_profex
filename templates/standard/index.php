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
		<div class="header page">
            <div class="container">
				<div class="col-md-12 nopadding">
					<h1>Допоможи Україні</h1>
					<span>стань волонтером вже сьогодні</span>
					<div class="clearfix"></div>
				</div>
                <div class="clearfix"></div>
            </div>
        </div>
		
		<nav class="navbar navbar-default">
			<div class="container-fluid container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav">
						<li <?php if(frame::_()->isHome()) echo 'class="active"'; ?>><a href="<?php echo URL_ROOT; ?>">Головна</a></li>
						<li><a href="<?php echo uri::getLink('programs/list')?>">Проекти</a></li>
						<?php if(rs('user.isLoggedIn')) { ?>
							<li class="pull-right logged-user">
								<?php $user = rs('user.model.getLoggedIn'); ?>
								Ви увійшли як <a href="<?php echo uri::getLink('user/profile'); ?>"><?php echo $user['login']; ?></a>. <a href="<?php echo uri::getLink('user/logout') ?>">Вийти?</a>
							</li>
						<?php } else {?>
                            <li class="pull-right logged-user">
								<a href="<?php echo uri::getLink( LOGIN_ALIAS ); ?>">Вхід</a>
							</li>
                        <?php } ?>
					</ul>
				</div>
			</div>
		</nav>
        
        <div class="container">
            <?php echo $this->content;?>
            <div class="clearfix"></div>
        </div>
		
		<?php echo $this->footer;?>
        
	</body>
</html>