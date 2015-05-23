<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="clearfix">
                <h3 class="content-title pull-left"><?php $this->edit ? lang::_e('EDIT_PROGRAM') : lang::_e('CREATING_PROGRAM'); ?></h3>
            </div>
        </div>
    </div>
</div>
                        
<form action="<?php echo uri::getAdminLink('programs/save')?>" id="saveProgramForm">
    <div id="saveProgramMsg"></div>
    
    <div class="col-md-8">
        <div class="form-group">
            <label for="program_title"><?php lang::_e('PROGRAM_LABEL'); ?></label>
            <?php echo html::text('label', array('value' => $this->edit ? $this->program['label'] : '', 'attrs' => 'id="program_title" class="form-control"')); ?>
        </div>
        <div class="form-group">
            <label for="program_description"><?php lang::_e('PROGRAM_DESC'); ?></label>
            <?php echo html::textarea('description', array('value' => $this->edit ? $this->program['description'] : '', 'attrs' => 'class="form-control ckeditor"')); ?>
        </div>
		<div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-picture-o"></i> <strong><?php lang::_e('Зображення')?></strong></div>
            <div class="panel-body">
				<div id="uploadFilesShell">
					<p><?php lang::_e('DRAG_OR_SELECT_FILES')?></p>
				</div>
				<div style="clear: both;"></div>
				<ul id="progrPhotosShell">
					<li class="example progrPhotoCell thumbnail">
						<img class="progrPhoto" src="" />
						<a class="progrRemovePhoto" href="<?php echo uri::getAdminLink('programs/removeImage')?>" onclick="removeProgrImg(this); return false;"><span class="glyphicon glyphicon-trash"></span> <?php lang::_e('REMOVE')?></a>
					</li>
				</ul>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 program-sidebar">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-check-square-o"></i> <strong><?php lang::_e('PROGRAM_PARAMS')?></strong></div>
            <div class="panel-body">
				<div class="form-group">
                    <label for="program_categories"><?php lang::_e('CATEGORIES'); ?></label>
                    <?php echo html::selectlist('categories_ids', array(
						'options' => $this->categoriesList,
						'value' => $this->edit ? $this->program['categories_ids'] : '', 
						'attrs' => 'id="program_categories" class="form-control chosen"')); ?>
                </div>
				<div class="form-group">
                    <label for="program_locations"><?php lang::_e('LOCATIONS'); ?></label>
                    <?php echo html::selectlist('locations_ids', array(
						'options' => $this->locationsList,
						'value' => $this->edit ? $this->program['locations_ids'] : '', 
						'attrs' => 'id="program_locations" class="form-control chosen"')); ?>
                </div>
				<div class="form-group help_types_labels">
					<div><?php lang::_e('HELP_TYPES')?></div>
					<div>
						<?php if(!empty($this->helpTypesList)) {
							foreach($this->helpTypesList as $id => $label) { ?>
								<label><?php echo html::checkbox('help_types_ids[]', array(
									'value' => $id,
									'checked' => $this->edit ? in_array($id, $this->program['help_types_ids']) : false,
								))?>&nbsp;<?php echo $label?></label>
							<?php }
						}?>
					</div>
                </div>
				<div class="form-group">
					<label for="required_amount"><?php lang::_e('REQUIRED_AMOUNT'); ?></label>
					<?php echo html::text('required_amount', array('value' => $this->edit ? $this->program['required_amount'] : '', 'attrs' => 'id="required_amount" class="form-control"')); ?>
				</div>
				<div class="form-group">
					<label for="received_amount"><?php lang::_e('RECEIVED_AMOUNT'); ?></label>
					
					<?php echo html::text('received_amount', array('value' => $this->edit ? $this->program['received_amount'] : '', 'attrs' => 'id="received_amount" disabled class="form-control"')); ?>
				</div>
                <?php echo html::hidden('id', array('value' => $this->edit ? $this->program['id'] : ''))?>
                <?php echo html::submit('save', array('value' => lang::_('SAVE_PROGRAM'), 'attrs' => 'class="btn btn-primary"'))?>
            </div>
        </div>
        
        <a href="<?php echo uri::getLink('administrator/news/add/'.$this->program['id'])?>" class="btn btn-grey"><i class="fa fa-plus-circle"></i> Додати новину в проект</a><br>
        
        <?php 
            $news_list = rs('news.model.getListForProgr', $this->program['id'], array('label','id')); 
            if($news_list){
                echo '<ol class="news-admin-list">';
                foreach($news_list as $news){
                    echo '<li><a href="'.uri::getLink('administrator/news/edit/'.$news['id']).'">'.$news['label'].'</a></li>';
                }
                echo '</ol>';
            }
        ?>
    </div>
</form>
