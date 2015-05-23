<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="clearfix">
                <h3 class="content-title pull-left"><?php $this->edit ? lang::_e('EDIT_CATEGORY') : lang::_e('CREATING_CATEGORY'); ?></h3>
            </div>
        </div>
    </div>
</div>
                        
<form action="<?php echo uri::getAdminLink('categories/save')?>" id="saveCategoryForm">
    <div id="saveCategorymMsg"></div>
    
    <div class="col-md-8">
        <div class="form-group">
            <label for="category_title"><?php lang::_e('CATEGORY_LABEL'); ?></label>
            <?php echo html::text('label', array('value' => $this->edit ? $this->category['label'] : '', 'attrs' => 'id="category_title" class="form-control"')); ?>
        </div>
        <div class="form-group">
            <label for="category_parent"><?php lang::_e('CATEGORY_PARENT'); ?></label>
            <?php echo html::selectbox('parent_id', array(
				'value' => $this->edit ? $this->category['parent_id'] : '', 
				'options' => $this->parentsList,
				'attrs' => 'id="category_parent" class="form-control"')); ?>
        </div>
    </div>
    
    <div class="col-md-4 category-sidebar">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-check-square-o"></i> <strong><?php lang::_e('CATEGORY_PARAMS')?></strong></div>
            <div class="panel-body">
                <?php echo html::hidden('id', array('value' => $this->edit ? $this->category['id'] : ''))?>
                <?php echo html::submit('save', array('value' => lang::_('SAVE_CATEGORY'), 'attrs' => 'class="btn btn-primary"'))?>
            </div>
        </div>
    </div>
</form>
