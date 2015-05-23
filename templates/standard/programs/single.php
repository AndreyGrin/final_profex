<div class="col-md-12 project-single nopadding">
	<div class="col-md-6 col-sm-6 col-xs-12 nopadding">
			<div class="project-image">
                <?php if(!empty($this->program['files']) && count($this->program['files']) > 1) {?>
                    <div class="program-image">
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
                <?php } elseif(!empty($this->program['files']) && count($this->program['files']) == 1) { ?>
                    <img src="<?php echo $this->program['files'][0]['url']; ?>" alt="" />
                <?php } ?>
				<div class="clearfix"></div>
			</div>
			<div class="project-updates">
				<span class="title">Оновлення проекту</span>
                <?php rs('news.view.showListForProgram', $this->program['id']);?>
                <?php rs('user.view.showSubscribeBtn', $this->program['id'])?>
			</div>
		<div class="clearfix"></div>
	</div>
	<div class="col-md-6 col-sm-6 col-xs-12 nopadding-right">
		<h2 class="project-title"><?php echo $this->program['label']?></h2>
        <div class="params">
            <div class="types see"><i class="fa fa-eye"></i> <span class="labels">Переглядів:</span> <?php echo $this->program['views']; ?></div>
            <div class="types help-type"><i class="fa fa-suitcase"></i> <span class="labels">Тип допомоги:</span>
                <?php foreach($this->program['help_types'] as $type): ?>
                    <a href="<?php echo uri::getLink('programs/list/help_type/'.$type['id']); ?>"><?php echo $type['label']; ?></a>
                <?php endforeach; ?>
            </div>
            <div class="types category"><i class="fa fa-th-list"></i> 
                <span class="labels">Категорія:</span>
                <?php foreach($this->program['categories'] as $type): ?>
                    <a href="<?php echo uri::getLink('programs/list/category/'.$type['id']); ?>"><?php echo $type['label']; ?></a>
                <?php endforeach; ?>
            </div>
            <div class="types location"><i class="fa fa-map-marker "></i> 
                <span class="labels">Розташування:</span>
                <?php foreach($this->program['locations'] as $type): ?>
                    <a href="<?php echo uri::getLink('programs/list/location/'.$type['id']); ?>"><?php echo $type['label']; ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        
		<div class="project-content">
			<div class="inner">
                <?php if($this->program['required_amount'] > 0): ?>
                    <?php 
                        $need = $this->program['required_amount'];
                        $has = $this->program['received_amount'];
                        if($has/$need*100 <= 100){
                            $percents = $has/$need*100;
                        } else {
                           $percents = 100;
                        }
                    ?>
                    <div class="all-money">
                        <p>Загальна сумма збору:</p>
                        <span><?php echo $need; ?> грн.</span>
                    </div>
                    <div class="progress part-of-money">
                        <div class="progress-bar progress-bar-warning progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $percents; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $percents; ?>%">
                            <p data-has="<?php echo $has; ?>"><?php echo $has; ?> грн.</p>
                        </div>
                    </div>
                <?php endif; ?>
				<a href="#" class="join helpProgrBtn" data-id="<?php echo $this->program['id']?>">Допомогти</a>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
		<div class="project-description">
			<?php echo $this->program['description']?>
			<div class="clearfix"></div>
		</div>
		<div class="volunteers">
			<span class="title text-center">Волонтери</span>
            <ol>
                <?php foreach($this->donated as $donat): ?>
				<li>
                    <?php 
                        if($donat['first_name'] != ''){
                            echo $donat['first_name'].' '.$donat['last_name'];
                        } else {
                            echo $donat['login'];
                        }
                    ?>
                </li>
                <?php endforeach; ?>
			</ol>
			<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="clearfix"></div>
</div>
<!--Donate Wnd-->
<div id="donateWnd" style="display: none;" title="Пожертвувати">
	<form id="donateForm" action="<?php echo uri::getLink('programs/donate')?>">
        <p>Пожертва відбувається на ментальному рівні, миттєво, ми віримо що ви справді надіслали би гроші :)</p>
		<?php echo html::text('amount',array('attrs' => 'class="form-control"'))?>
		<?php echo html::hidden('pid')?><br>
		<input type="submit" class="btn btn-primary" name="donate" value="<?php lang::_e('DONATE')?>" />
		<div id="donateFormMsg"></div>
	</form>
</div>