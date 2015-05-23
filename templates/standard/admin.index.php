<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
		<title><?php echo empty($this->title) ? 'Profex Administrator area' : $this->title?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no">
        <?php
            if(!empty($this->scripts)) echo $this->scripts;
            if(!empty($this->styles)) echo $this->styles;
        ?>
    </head>
	<body>
		<!-- HEADER -->
        <header class="navbar clearfix" id="header">
            <div class="container">
                <div class="navbar-brand">
                    <!-- COMPANY LOGO -->
                    <a href="index.html">
                        <img src="<?php echo URL_ROOT; ?>/img/logo.png" alt="Admin Logo" class="img-responsive" height="30" width="120">
                    </a>
                    <!-- /COMPANY LOGO -->
                    <!-- SIDEBAR COLLAPSE -->
                    <div id="sidebar-collapse" class="sidebar-collapse btn">
                        <i class="fa fa-bars" 
                            data-icon1="fa fa-bars" 
                            data-icon2="fa fa-bars" ></i>
                    </div>
                    <!-- /SIDEBAR COLLAPSE -->
                </div>
                <ul class="nav navbar-nav pull-right">
                    <li><a href="<?php echo URL_ROOT; ?>"  class="dropdown-toggle"><?php lang::_e('RETURN_TO_SITE'); ?> <i class="fa fa-arrow-right"></i></a></li>
                </ul>
            </div>
        </header>
        <!--/HEADER -->
        <section id="page">
            <!-- SIDEBAR -->
            <div id="sidebar" class="sidebar">
                <div class="sidebar-menu nav-collapse">                  
                    <!-- SIDEBAR MENU -->
                    <ul>
                       <?php foreach(rs('pages.getAdminMenuList') as $k => $menu) { ?>
                            <?php 
                                if(isset($menu['children']) && !empty($menu['children'])) { 
                                    $has_childrens = true;
                                    $parent_link = 'javascript:;';
                                } else {
                                    $has_childrens = false;
                                    $parent_link = $menu['url'];
                                }
                            ?>
                            <li class="<?php echo isset($menu['selected']) && $menu['selected'] ? 'active' : ''?> <?php if($has_childrens) echo 'has-sub'; ?>">
                                <a href="<?php echo $parent_link; ?>">
                                    <?php echo isset($menu['icon']) ? $menu['icon'] : '' ?>
                                    <span class="menu-text"><?php echo $menu['label']?></span>
                                    <?php if($has_childrens) { ?>
                                        <span class="arrow"></span>
                                    <?php }?>
                                </a>
                                <?php if($has_childrens) { ?>
                                <ul class="sub">
									 <li class="<?php echo isset($menu['selected']) && $menu['selected'] ? 'active' : ''?>">
                                        <a href="<?php echo $menu['url']?>"><?php echo $menu['label']?></a>
                                    </li>
                                    <?php foreach($menu['children'] as $kChild => $menuChild) { ?>
                                    <li class="<?php echo isset($menuChild['selected']) && $menuChild['selected'] ? 'active' : ''?>">
                                        <a href="<?php echo $menuChild['url']?>"><?php echo $menuChild['label']?></a>
                                    </li>
                                    <?php }?>
                                </ul>
                                <?php }?>
                            </li>
                        <?php }?>
                    </ul>
                    <!-- /SIDEBAR MENU -->
                </div>
            </div>
            <!-- /SIDEBAR -->
            
            <div id="main-content">
                <div class="container">
                	<div class="row">
                		<div id="content" class="col-lg-12">
                            <?php echo $this->content;?>  
                        </div>
                	</div>
                </div>
            </div>
            <div class="clearfix"></div>
        </section>
        <div class="clearfix"></div>
	</body>
</html>