<form action="<?php echo uri::getLink('user/subscribe')?>" class="subscribeForm">
    
    <div class="form-group">
            <label for="first_name" class="control-label"><?php lang::_e('FIRST_NAME')?></label>
            <?php echo html::text('first_name', array('attrs' => 'class="form-control"'))?>
        </div>
        <div class="form-group">
            <label for="last_name" class="control-label"><?php lang::_e('LAST_NAME')?></label>
            <?php echo html::text('last_name', array('attrs' => 'class="form-control"'))?>
        </div>
        <div class="form-group">
            <label for="email" class="control-label"><?php lang::_e('EMAIL')?></label>
            <?php echo html::text('email', array('attrs' => 'class="form-control"'))?>
        </div>
        <div class="form-group">
            <label for="login" class="control-label"><?php lang::_e('LOGIN')?></label>
            <?php echo html::text('login', array('attrs' => 'class="form-control"'))?>
        </div>
        <div class="form-group">
            <label for="passwd" class="control-label"><?php lang::_e('PASSWORD')?></label>
            <?php echo html::text('passwd', array('attrs' => 'class="form-control"'))?>
        </div>
    
	<?php echo html::formEnd('subscribe')?>
	<?php echo html::hidden('pid')?>
	<input type="submit" class="btn btn-primary" value="<?php lang::_e('SUBSCRIBE')?>" />
	<div class="subscribeMsg"></div>
</form>