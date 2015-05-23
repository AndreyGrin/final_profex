<div class="locations container">
    <h3><?php lang::_e('LOCATIONS'); ?></h3>
	<div class="locations-list">
		<?php foreach($this->locations as $c) {?>
				<a href="<?php echo rs('locations.getLink', $c)?>" <?php if(frame::_()->isHome()){ echo 'class="animated" data-animtype="zoomIn"
                                             data-animrepeat="0"
                                             data-animspeed="0.5s"
                                             data-animdelay="0.3s"';}?>><?php echo $c['label']?></a>
		<?php }?>
	</div>
</div>
<div class="clearfix"></div>