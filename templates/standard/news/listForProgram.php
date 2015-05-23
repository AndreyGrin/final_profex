<?php if(!empty($this->news)) { ?>
	<?php foreach($this->news as $new) { ?>
        <div class="update animated" data-animtype="fadeInUp"
                                             data-animrepeat="0"
                                             data-animspeed="0.7s"
                                             data-animdelay="0.3s">
            <p class="pull-right date"><?php echo $new['date_created']?></p>
            <?php if($new['label'] != ''): ?><span class="title"><?php echo $new['label']?></span><?php endif; ?>
            <?php echo $new['description'] ?>
        </div>
	<?php }?>
<?php } else { ?>
	<?php lang::_e('NEWS_UPDATES')?>
<?php }?>