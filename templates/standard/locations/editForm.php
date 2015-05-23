<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="clearfix">
                <h3 class="content-title pull-left"><?php $this->edit ? lang::_e('EDIT_LOCATION') : lang::_e('CREATING_LOCATION'); ?></h3>
            </div>
        </div>
    </div>
</div>
                        
<form action="<?php echo uri::getAdminLink('locations/save')?>" id="saveLocationForm">
    <div id="saveLocationmMsg"></div>
    
    <div class="col-md-8">
        <div class="form-group">
            <label for="location_title"><?php lang::_e('LOCATION_LABEL'); ?></label>
            <?php echo html::text('label', array('value' => $this->edit ? $this->data['label'] : '', 'attrs' => 'id="location_title" class="form-control"')); ?>
        </div>
        <div class="form-group">
            <label for="location_parent"><?php lang::_e('LOCATION_PARENT'); ?></label>
            <?php echo html::selectbox('parent_id', array(
				'value' => $this->edit ? $this->data['parent_id'] : '', 
				'options' => $this->parentsList,
				'attrs' => 'id="location_parent" class="form-control"')); ?>
        </div>
    </div>
    
    <div class="col-md-4 location-sidebar">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-check-square-o"></i> <strong><?php lang::_e('LOCATION_PARAMS')?></strong></div>
            <div class="panel-body">
                <?php echo html::hidden('id', array('value' => $this->edit ? $this->data['id'] : ''))?>
                <?php echo html::submit('save', array('value' => lang::_('SAVE_LOCATION'), 'attrs' => 'class="btn btn-primary"'))?>
            </div>
        </div>
    </div>
</form>
