<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
            <div class="clearfix">
                <h3 class="content-title pull-left"><?php lang::_e('DASHBOARD'); ?></h3>
            </div>
        </div>
    </div>
</div>

<h3 class="text-center"><?php lang::_e('TOTALS_LABEL'); ?></h3>
<div class="col-lg-4">
    <div class="dashbox panel panel-default">
        <div class="panel-body">
           <div class="panel-left blue">
                <i class="fa fa-envelope-o  fa-3x"></i>
           </div>
           <div class="panel-right text-center">
                <div class="title">Підписників</div>
                <div class="number"><?php echo $this->data['totals']['subscribers']?></div>                
           </div>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="dashbox panel panel-default">
        <div class="panel-body">
           <div class="panel-left green">
                <i class="fa fa-repeat fa-3x"></i>
           </div>
           <div class="panel-right text-center">
                <div class="title">Оновлень</div>
                <div class="number"><?php echo $this->data['totals']['news']?></div>                
           </div>
        </div>
    </div>
</div>

<div class="col-lg-4">
    <div class="dashbox panel panel-default">
        <div class="panel-body">
           <div class="panel-left yellow">
                <i class="fa fa-money fa-3x"></i>
           </div>
           <div class="panel-right text-center">
                <div class="title">Пожертв</div>
                <div class="number"><?php echo $this->data['totals']['donated']?></div>                
           </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>