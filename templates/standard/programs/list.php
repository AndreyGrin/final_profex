<?php if(!frame::_()->isHome()): ?>
    <h2 class="text-center">
        <?php
            if(isset($this->pageData['category'])){
                echo $this->pageData['category']['label']; 
            } elseif(isset($this->pageData['location'])){
                echo $this->pageData['location']['label']; 
            } elseif(isset($this->pageData['help_type'])){
                echo $this->pageData['help_type']['label'].' допомога'; 
            }
        ?>
    </h2>
    
    <div class="filter">
        <ul class="nav nav-tabs nav-justified" id="filters">
            <li class=""><a data-toggle="tab" href="#categories">Тематика програм</a></li>
            <li class=""><a data-toggle="tab" href="#types">Тип допомоги</a></li>
            <li class=""><a data-toggle="tab" href="#locations">Розташування</a></li>
        </ul>
        <div class="tab-content">
            <div id="categories" class="tab-pane fade">
                <?php echo rs('categories_widget.getContent')?>
            </div>
            
            <div id="types" class="tab-pane fade">
				<div class="help-types-widget">
					<?php echo rs('help_types_widget.getContent')?>
				</div>
            </div>
            
            <div id="locations" class="tab-pane fade">
                <?php echo rs('locations_widget.getContent')?>
            </div>
        </div>
    </div>
<?php endif; ?>
<div class="projects">
    <div class="container">
        <div class="col-md-12 nopadding"> 
            <span class="title"><?php lang::_e('ACTUAL_PROGRAMS')?></span>
            <div class="clearfix"></div>
            
            <div class="programs-cat">
                <?php if(!empty($this->programs)) { ?>
                    <?php foreach($this->programs as $p) { ?>
                        <div class="col-md-6 col-sm-6 col-xs-12 project-item nopadding animated" data-animtype="fadeInUp"
                                             data-animrepeat="0"
                                             data-animspeed="0.7s"
                                             data-animdelay="0.3s">
                            <?php if(!empty($p['files'])) {?>
                                <a href="<?php echo rs('programs.getLink', $p)?>">
                                    <img class="img-responsive" src="<?php echo $p['files'][0]['url']?>" />
                                </a>
                            <?php }?>
                            <div class="project-information">
                                <div class="pull-left">
                                    <div class="accepted">
                                        <span><?php lang::_e('PROGRAMM_MEMBERS')?></span>
                                        <p><?php echo $p['subscribed']; ?></p>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="update">
                                        <span><?php lang::_e('PROGRAMM_NEWS')?></span>
                                        <p><?php echo $p['news']; ?></p>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <a href="<?php echo rs('programs.getLink', $p)?>" class="join"><?php lang::_e('PROGRAMM_DETAILS')?></a>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php //rs('user.view.showSubscribeBtn', $p['id'])?>
                        
                    <?php }?>
                <?php } else { ?>
                    <b><?php lang::_e('NO_PROGRAMS_FOUND')?></b>
                <?php }?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="clearfix"></div>