<div class="help-types">
	<span class="title">Як можна допомогти?</span>
	<div class="clearfix"></div>
	<?php foreach($this->help_types as $h) {?>
        <?php 
            switch($h['id']){
                case 5: $label = 'Фінансами'; break;
                case 6: $label = 'Матеріально'; break;
                case 7: $label = 'Фізично'; break;
                case 8: $label = 'Транспортом'; break;
                case 9: $label = 'Інформацією'; break;
            } 
        ?>
		<a href="<?php echo rs('help_types.getLink', $h)?>" class="button"><?php echo $label?></a>
	<?php }?>
</div>
<div class="clearfix"></div>