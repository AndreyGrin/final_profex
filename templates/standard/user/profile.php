<div class="col-md-6 col-sm-6 col-xs-12">
    <h3>Профіль користувача</h3>
    <form action="<?php echo uri::getLink('user/saveProfile')?>" class="profileForm">
        <div class="form-group">
            <label for="first_name" class="control-label"><?php lang::_e('FIRST_NAME')?></label>
            <?php echo html::text('first_name', array('value' => $this->user['first_name'], 'attrs' => 'class="form-control"'))?>
        </div>
        <div class="form-group">
            <label for="last_name" class="control-label"><?php lang::_e('LAST_NAME')?></label>
            <?php echo html::text('last_name', array('value' => $this->user['last_name'], 'attrs' => 'class="form-control"'))?>
        </div>
        <div class="form-group">
            <label for="email" class="control-label"><?php lang::_e('EMAIL')?></label>
            <?php echo html::text('email', array('value' => $this->user['email'], 'attrs' => 'class="form-control"'))?>
        </div>
        <div class="form-group">
            <label for="login" class="control-label"><?php lang::_e('LOGIN')?></label>
            <?php echo html::text('login', array('value' => $this->user['login'], 'attrs' => 'class="form-control"'))?>
        </div>
        <div class="form-group">
            <label for="passwd" class="control-label"><?php lang::_e('PASSWORD')?></label>
            <?php echo html::text('passwd', array('attrs' => 'class="form-control"'))?>
        </div>
        <?php echo html::formEnd('subscribe')?>
        <input type="submit" class="button" value="<?php lang::_e('SAVE')?>" />
        <div class="profileFormMsg"></div>
    </form>
</div>

<div class="col-md-6 col-sm-6 col-xs-12">
    <h3>Мої проекти</h3>
    <?php if(!empty($this->user['subscribed']) && !empty($this->subscribedPrograms)) { ?>
        <?php foreach($this->subscribedPrograms as $p) { ?>
            <div class="subscriptionRow">
                <a href="<?php echo uri::getLink('programs/view/'. $p['id'])?>"><?php echo $p['label']?></a>
                <a class="unsubscribeBtn label label-danger pull-right" href="<?php echo uri::getLink('user/unsubscribe/'. $p['id'])?>"><?php lang::_e('UNSUBSCRIBE')?></a>
                <div class="clearfix"></div>
            </div>
        <?php }?>
    <?php }?>
</div>

<div class="clearfix"></div>