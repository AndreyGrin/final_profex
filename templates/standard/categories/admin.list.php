<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="clearfix">
                <h3 class="content-title pull-left"><?php lang::_e('CATEGORIES_LIST'); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
<?php if(!empty($this->categories)) { ?>
	<table class="table table-hover">
        <thead>
            <tr>
                <?php foreach($this->categoriesFieldsList as $key => $field) { ?>
                    <th><?php echo $field['label']?></th>
                <?php }?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($this->categories as $p) { ?>
            <tr>
                <?php foreach($this->categoriesFieldsList as $key => $field) { ?>
                    <td>
                        <?php if($key == 'actions') {?>
                        <div class="btn-group">
                            <a href="<?php echo $this->module->getEditLink($p['id'])?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>
                            <a href="<?php echo $this->module->getRemoveLink($p['id'])?>"  class="btn btn-xs btn-danger" onclick="categoryRemoveClick(this); return false;"><i class="fa fa-times"></i></a>
                        </div>
                        <?php } else {
                            echo $p[ $key ];
                        }?>
                    </td>
                <?php }?>
            </tr>
            <?php }?>
        </tbody>
	</table>
<?php } else { ?>
	<div class="be-warning alert alert-warning"><?php lang::_e('NO_CATEGORIES_FOUND')?></div>
<?php }?> 
</div>