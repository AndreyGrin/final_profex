<div class="categories">
    <h3><?php lang::_e('CATEGORIES'); ?></h3>
    <?php 
        $parents = array();
        $childs = array();
        
        foreach($this->categories as $c) { 
        
            if($c['parent_id'] == 0){
                $arr = Array();
                
                if($c['id'] == 2){
                    $arr['icon'] = '<img src="'.URL_ROOT.'/templates/standard/images/medical.jpg' .'" alt="" />';
                }
                
                if($c['id'] == 7){
                    $arr['icon'] = '<img src="'.URL_ROOT.'/templates/standard/images/army.jpg' .'" alt="" />';
                }
                
                if($c['id'] == 12){
                    $arr['icon'] = '<img src="'.URL_ROOT.'/templates/standard/images/peoples.jpg' .'" alt="" />';
                }
                
                if($c['id'] == 17){
                    $arr['icon'] = '<img src="'.URL_ROOT.'/templates/standard/images/lost.jpg' .'" alt="" />';
                }
                
                $arr['data'] = $c;
                
                $parents[] = $arr;
            } else {
                $childs[] = $c;
            }
        }
        
        $delay = 2;
        foreach($parents as $parent){
            if(frame::_()->isHome()){
                echo '<div class="col-md-3 col-sm-3 col-xs-12 projects-category animated" data-animtype="fadeInUp"
                                             data-animrepeat="0"
                                             data-animspeed="0.5s"
                                             data-animdelay="0.'.$delay++.'s">';
            } else {
                echo '<div class="col-md-3 col-sm-3 col-xs-12 projects-category">';
            }
            echo $parent['icon'];
            echo '<a href="'.rs('categories.getLink', $parent['data']).'" class="main-category">'.$parent['data']['label'].'</a>';
            
			echo '<div class="sub">';
            foreach($childs as $child){
                if($child['parent_id'] == $parent['data']['id']){
                    echo '<a href="'.rs('categories.getLink', $child).'" class="sub-category">'.$child['label'].'</a>'; 
                }
            }
			echo '</div>';
            
            echo '</div>';
        }
    ?>
</div>
<div class="clearfix"></div>