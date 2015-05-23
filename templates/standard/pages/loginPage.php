<form class="loginForm" action="" role="form">
    <div class="form-group">
        <label for="user_login">Login</label>
        <i class="fa fa-user"></i>
        <?php echo html::text('login', array('attrs' => 'class="form-control" id="user_login"')); ?>
    </div>
    <div class="form-group"> 
        <label for="user_pass">Password</label>
        <i class="fa fa-lock"></i>
        <?php echo html::password('passwd', array('attrs' => 'class="form-control" id="user_pass"')); ?>
    </div>
	<?php echo html::hidden('return', array('value' => $this->return))?>
	<?php echo html::submit('send', array('value' => lang::_('LOGIN'), 'attrs' => 'class="btn btn-danger"'))?>
	<div class="loginMsg"></div>
</form>