<div class="col-md-12 product-wrapper">
    <div class="col-md-12 product-content">
        <div class="col-md-9">
            <?php if(!empty($this->program['files'])) {?>
                <div class="col-md-5 program-image">
                    <ul class="bxslider">
                        <?php foreach($this->program['files'] as $f) { ?>
                            <li><img src="<?php echo $f['url']?>" alt="" /></li>
                        <?php }?>
                    </ul>
                    <div class="clearfix"></div>
                    
                    <?php if(count($this->program['files']) > 1): ?>
                        <div id="bx-pager">
                            <?php $i = 0; ?>
                            <?php foreach($this->program['files'] as $f) { ?>
                                <a data-slide-index="<?php echo $i; ?>" href="" class="col-md-3"><img src="<?php echo $f['url']?>" class="img-responsive" alt="" /></a>
                                <?php $i++; ?>
                            <?php }?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php }?>
            <div class="col-md-7 program-information">
                <span class="title"><?php echo $this->program['label']?></span>
                <div class="program-options">
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
				
                <div class="clearfix"></div>
            </div>
            
            <div class="clearfix"></div>
            <div class="col-md-12 full-description">
                <span><?php lang::_e('PRODUCT_DESC'); ?></span>
                <?php echo $this->program['description']?>
                <div class="clearfix"></div>
            </div>
			<div class="clearfix"></div>
			<?php rs('user.view.showSubscribeBtn', $this->program['id'])?>
			<div class="clearfix"></div>
			<div class="col-md-12 news">
				<?php rs('news.view.showListForProgram', $this->program['id']);?>
			</div>
        </div>
        <div class="col-md-3 program-payment">
            <span>Payment Details</span>
            <p>You can choose from the following payment methods:</p>
            <div class="clearfix"></div>
            <div class="payments-list">
                <img src="<?php echo document::_()->getTemplatesUrl(); ?>/img/mastercard.png" alt="" />
                <img src="<?php echo document::_()->getTemplatesUrl(); ?>/img/visa.png" alt="" />
                <img src="<?php echo document::_()->getTemplatesUrl(); ?>/img/maestro.jpg" alt="" />
                <img src="<?php echo document::_()->getTemplatesUrl(); ?>/img/paypal.jpg" alt="" />
                <img src="<?php echo document::_()->getTemplatesUrl(); ?>/img/webmoney.png" alt="" />
                <img src="<?php echo document::_()->getTemplatesUrl(); ?>/img/skrill.png" alt="" />
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
            <p class="problem">If you have any problem with payment</p>
            <button class="btn btn-primary problem-button" type="button">Contact Us</button>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="clearfix"></div>
