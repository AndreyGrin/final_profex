<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="clearfix">
                <h3 class="content-title pull-left"><?php $this->edit ? lang::_e('EDIT_NEWS') : lang::_e('ADD_NEWS'); ?></h3>
            </div>
        </div>
    </div>
</div>
                        
<form action="<?php echo uri::getAdminLink('news/save')?>" id="saveNewsForm">
    <div id="saveNewsMsg"></div>
    
    <div class="col-md-8">
        <div class="form-group">
            <label for="news_title"><?php lang::_e('NEWS_LABEL'); ?></label>
            <?php echo html::text('label', array('value' => $this->edit ? $this->data['label'] : '', 'attrs' => 'id="news_title" class="form-control"')); ?>
        </div>
		<div class="form-group">
            <label for="news_description"><?php lang::_e('NEWS_CONTENT'); ?></label>
            <?php echo html::textarea('description', array('value' => $this->edit ? $this->data['description'] : '', 'attrs' => 'class="form-control ckeditor"')); ?>
        </div>
    </div>
    
    <div class="col-md-4 location-sidebar">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-shopping-cart"></i> <strong><?php lang::_e('NEWS_PARAMS')?></strong></div>
            <div class="panel-body">
				<div class="form-group">
					<label for="notify_subscribers"><?php lang::_e('NOTIFY_SUBSCRIBERS'); ?></label>
					<?php echo html::checkbox('notify_subscribers', array(
						'value' => 1, 
						'checked' => 1,
						'attrs' => 'id="notify_subscribers" class="form-control"')); ?>
				</div>
				<?php echo html::hidden('pid', array('value' => $this->pid))?>
                <?php echo html::hidden('id', array('value' => $this->edit ? $this->data['id'] : ''))?>
                <?php echo html::submit('save', array('value' => lang::_('SAVE_NEWS'), 'attrs' => 'class="btn btn-primary"'))?>
            </div>
        </div>
        
        <a href="<?php echo frame::_()->getModule('programs')->getEditLink($this->pid)?>" class="button">Повернутися до проекту</a>
    </div>
</form>
