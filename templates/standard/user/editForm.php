<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="clearfix">
                <h3 class="content-title pull-left"><?php $this->edit ? lang::_e('EDIT_USER') : lang::_e('ADD_USER'); ?></h3>
            </div>
        </div>
    </div>
</div>
                        
<form action="<?php echo uri::getAdminLink('user/save')?>" id="saveUserForm">
    <div id="saveUserMsg"></div>
    
    <div class="col-md-8">
		<?php foreach($this->fieldsList as $key => $field) { ?>
			<?php
				if(in_array($key, array('actions'))) continue;
				$id = 'user_'. $key;
				$htmlParams = array(
					'value' => $this->edit ? $this->data[ $key ] : '',
					'attrs' => 'id="'. $id. '" class="form-control"',
				);
				$htmlType = 'text';
				if($key == 'role_id') {
					$htmlType = 'selectbox';
					$htmlParams['options'] = $this->rolesList;
				} elseif($key == 'active') {
					$htmlType = 'checkbox';
					$htmlParams['checked'] = (int) $htmlParams['value'];
					unset($htmlParams['value']);
				}
			?>
			<div class="form-group">
				<label for="<?php echo $field?>"><?php echo $field['label']; ?></label>
				<?php echo html::$htmlType($key, $htmlParams); ?>
			</div>
		<?php }?>
    </div>
    
    <div class="col-md-4 location-sidebar">
        <div class="panel panel-default">
            <div class="panel-heading"><i class="fa fa-shopping-cart"></i> <strong><?php lang::_e('USER_PARAMS')?></strong></div>
            <div class="panel-body">
                <?php echo html::hidden('id', array('value' => $this->edit ? $this->data['id'] : ''))?>
                <?php echo html::submit('save', array('value' => lang::_('SAVE_USER'), 'attrs' => 'class="btn btn-primary"'))?>
            </div>
        </div>
    </div>
</form>
