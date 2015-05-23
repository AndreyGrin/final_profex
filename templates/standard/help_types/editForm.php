<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="clearfix">
                <h3 class="content-title pull-left"><?php $this->edit ? lang::_e('EDIT_HELP_TYPE') : lang::_e('CREATING_HELP_TYPE'); ?></h3>
            </div>
        </div>
    </div>
</div>
                        
<form action="<?php echo uri::getAdminLink('help_types/save')?>" id="saveHelpTypeForm">
    <div id="saveHelpTypemMsg"></div>
    
    <div class="col-md-8">
        <div class="form-group">
            <label for="type_title"><?php lang::_e('HELP_TYPE_LABEL'); ?></label>
            <?php echo html::text('label', array('value' => $this->edit ? $this->data['label'] : '', 'attrs' => 'id="type_title" class="form-control"')); ?>
        </div>
    </div>
    
    <div class="col-md-4 help_types-sidebar">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-shopping-cart"></i> <strong><?php lang::_e('HELP_TYPE_PARAMS')?></strong></div>
            <div class="panel-body">
                <?php echo html::hidden('id', array('value' => $this->edit ? $this->data['id'] : ''))?>
                <?php echo html::submit('save', array('value' => lang::_('SAVE_HELP_TYPE'), 'attrs' => 'class="btn btn-primary"'))?>
            </div>
        </div>
    </div>
</form>
