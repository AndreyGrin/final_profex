<?php if(!$this->subscribed) {?>
<a href="<?php echo uri::getLink('user/subscribe/'. $this->pid, array('_nonce' => html::generateNonce('subscribe')))?>" class="subscribeBtn" data-pid="<?php echo $this->pid?>">
		<?php lang::_e('SUBSCRIBE')?>
	</a>
<?php }?>