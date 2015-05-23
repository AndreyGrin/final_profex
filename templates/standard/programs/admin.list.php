<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="clearfix">
                <h3 class="content-title pull-left"><?php lang::_e('PROGRAMS_LIST'); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-default">
<?php if(!empty($this->programs)) { ?>
	<table class="table table-hover">
        <thead>
            <tr>
                <?php foreach($this->programsFieldsList as $key => $field) { ?>
                    <th><?php echo $field['label']?></th>
                <?php }?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($this->programs as $p) { ?>
            <tr>
                <?php foreach($this->programsFieldsList as $key => $field) { ?>
                    <td>
                        <?php if($key == 'actions') {?>
                        <div class="btn-group">
							<a title="<?php lang::_e('NEWS')?>" data-pid="<?php echo $p['id']?>" href="#" class="btn btn-xs btn-success progrNewsListBtn"><i class="fa fa-list"></i></a>
                            <a href="<?php echo $this->module->getEditLink($p['id'])?>" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i></a>
                            <a href="<?php echo $this->module->getRemoveLink($p['id'])?>"  class="btn btn-xs btn-danger" onclick="programRemoveClick(this); return false;"><i class="fa fa-times"></i></a>
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
	<!-- News dialog Wnd -->
	<div id="newsWnd" style="display: none;">
		<a id="addNewsBtn" href=""><?php lang::_e('ADD_NEWS')?></a><br />
		<div id="newsWndLoader" style="display: none;"><img src="<?php echo URL_ROOT; ?>/img/preloader.GIF"> Завантаження</div>
		<table id="newsList" style="display: none;">
			<tr id="newsListExampleRow" style="display: none;">
				<td class="newsLabel"></td>
				<td class="newsAdded"></td>
				<td class="newsActions">
					<a href="#" data-id="" data-pid="" class="btn btn-xs btn-warning newsEditLink"><i class="fa fa-pencil"></i></a>
					<a href="#" data-id="" class="btn btn-xs btn-danger newsRemoveLink" onclick="newsRemoveClick(this); return false;"><i class="fa fa-times"></i></a>
				</td>
			</tr>
		</table>
	</div>
<?php } else { ?>
	<div class="be-warning alert alert-warning"><?php lang::_e('NO_PROGRAMS_FOUND')?></div>
<?php }?> 
</div>