<?php
class html {
    static public function nameToClassId($name) {
        return str_replace(array('[', ']'), '', $name);
    }
    static public function textarea($name, $params = array('attrs' => '', 'value' => '', 'rows' => 3, 'cols' => 50)) {
        $params['rows'] = isset($params['rows']) ? $params['rows'] : 3;
        $params['cols'] = isset($params['cols']) ? $params['cols'] : 50;
		$params['value'] = isset($params['value']) ? $params['value'] : '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		if(isset($params['placeholder'])) {
			$params['attrs'] .= ' placeholder="'. $params['placeholder']. '"';
		}
		if(isset($params['required'])) {
			$params['attrs'] .= ' required ';
		}
        return '<textarea name="'.$name.'" '.$params['attrs'].' rows="'.$params['rows'].'" cols="'.$params['cols'].'">'.
                $params['value'].
                '</textarea>';
    }
    static public function input($name, $params = array('attrs' => '', 'type' => 'text', 'value' => '')) {
		$params['type'] = isset($params['type']) ? $params['type'] : '';
		$params['value'] = isset($params['value']) ? $params['value'] : '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		if(isset($params['placeholder'])) {
			$params['attrs'] .= ' placeholder="'. $params['placeholder']. '"';
		}
		if(isset($params['required'])) {
			$params['attrs'] .= ' required ';
		}
        return '<input type="'.$params['type'].'" name="'.$name.'" value="'.$params['value'].'" '.$params['attrs'].' />';
    }
	static public function email($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'email';
        return self::input($name, $params);
    }
    static public function text($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'text';
        return self::input($name, $params);
    }
	static public function reset($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'reset';
        return self::input($name, $params);
    }
    static public function password($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'password';
        return self::input($name, $params);
    }
    static public function hidden($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'hidden';
        return self::input($name, $params);
    }
    static public function checkbox($name, $params = array('attrs' => '', 'value' => '', 'checked' => '')) {
		$params['checked'] = isset($params['checked']) ? $params['checked'] : '';
		$params['value'] = isset($params['value']) ? $params['value'] : 1;
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        $params['type'] = 'checkbox';
        if($params['checked'])
            $params['checked'] = 'checked';
        $params['attrs'] .= ' '.$params['checked'];
        return self::input($name, $params);
    }
    static public function checkboxlist($name, $params = array('options' => array(), 'attrs' => '', 'checked' => '', 'delim' => '<br />', 'usetable' => 5), $delim = '<br />') {
		$params['options'] = isset($params['options']) ? $params['options'] : '';
		$params['delim'] = isset($params['delim']) ? $params['delim'] : $delim;
		$params['usetable'] = isset($params['usetable']) ? $params['usetable'] : '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        $out = '';
        if(!strpos($name, '[]')) {
            $name .= '[]';
        }
        $i = 0;
        if($params['options']) {
            if(!isset($params['delim']))
                $params['delim'] = $delim;
            if($params['usetable']) $out .= '<table><tr>';
			if(isset($params['value'])) {
				if(!is_array($params['value']))
					$params['value'] = array($params['value']);
				foreach($params['options'] as $j => $v) {
					$params['options'][$j]['checked'] = (isset($v['checked']) && $v['checked']) ? $v['checked'] : in_array($v['id'], $params['value']);
				}
			}
            foreach($params['options'] as $v) {
                if($params['usetable']) {
                    if($i != 0 && $i%$params['usetable'] == 0) $out .= '</tr><tr>';
                    $out .= '<td>';
                }
                $out .= self::checkbox($name, array(
                    'attrs' => $params['attrs'],
                    'value' => $v['id'],
                    'checked' => $v['checked']
                ));
                $out .= '&nbsp;'. $v['text']. $params['delim'];
                if($params['usetable']) $out .= '</td>';
                $i++;
            }
            if($params['usetable']) $out .= '</tr></table>';
        }
        return $out;
    } 
    static public function submit($name, $params = array('attrs' => '', 'value' => '')) {
        $params['type'] = 'submit';
        return self::input($name, $params);
    }
	static public function inputImage($name, $params = array('attrs' => '', 'value' => '', 'src' => '')) {
		$params['type'] = 'image';
		if(!isset($params['attrs']))
			$params['attrs'] = '';
		$params['attrs'] .= ' src="'. $params['src']. '"';
        return self::input($name, $params);
	}
    static public function selectbox($name, $params = array('attrs' => '', 'options' => array(), 'value' => '')) {
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		$params['value'] = isset($params['value']) ? $params['value'] : '';
        $out = '';
        $out .= '<select name="'.$name.'" '.$params['attrs'].'>';
        if(!empty($params['options'])) {
            foreach($params['options'] as $k => $v) {
                $selected = ($k == $params['value'] ? 'selected="true"' : '');
                $out .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
            }
        }
        $out .= '</select>';
        return $out;
    }
    static public function selectlist($name, $params = array('attrs'=>'', 'size'=> 5, 'options' => array(), 'value' => '')) {
		$params['size'] = isset($params['size']) ? $params['size'] : '';
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
		$params['value'] = isset($params['value']) ? $params['value'] : array();
		$params['multiple'] = isset($params['multiple']) ? $params['multiple'] : true;
        $out = '';
        if(!strpos($name, '[]')) 
            $name .= '[]';
        if (!isset($params['size']) || !is_numeric($params['size']) || $params['size'] == '') {
            $params['size'] = 5;
        }
        $out .= '<select '. ($params['multiple'] ? 'multiple="multiple" ' : ''). 'size="'.$params['size'].'" name="'.$name.'" '.$params['attrs'].'>';
        if(!empty($params['options'])) {
            foreach($params['options'] as $k => $v) {
                $selected = (is_array($params['value']) && in_array($k, $params['value']) ? 'selected="true"' : '');
                $out .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
            }
        }
        $out .= '</select>';
        return $out; 
    }
    static public function button($params = array('attrs' => '', 'value' => '')) {
        return '<button '.$params['attrs'].'>'.$params['value'].'</button>';
    }
    static public function inputButton($params = array('attrs' => '', 'value' => '')) {
		if(!is_array($params))
			$params = array();
		$params['type'] = 'button';
        return self::input('', $params);
    }
    static public function radiobuttons($name, $params = array('attrs' => '', 'options' => array(), 'value' => '', '')) {
		$params['value'] = isset($params['value']) ? $params['value'] : '';
		$params['options'] = isset($params['options']) ? $params['options'] : array();
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        $out = '';
        foreach($params['options'] as $key => $val) {
            $checked =($key == $params['value']) ? 'checked' : '';
            $out .= self::input($name, array('attrs' => $params['attrs'].' '.$checked, 'type' => 'radio', 'value' => $key)).' '.$val.'<br />';
        }
        return $out;
    }
    static public function radiobutton($name, $params = array('attrs' => '', 'value' => '', 'checked' => '')) {
        $params['type'] = 'radio';
		$params['checked'] = isset($params['checked']) ? $params['checked'] : false;
		$params['attrs'] = isset($params['attrs']) ? $params['attrs'] : '';
        if($params['checked'])
            $params['attrs'] .= ' checked';
        return self::input($name, $params);
    }
	static public function generateNonce($key) {
		return md5(date('H d/m/Y'). SECRET_HASH. $key);	// Nonce will be valid 1 hour
	}
	static public function formEnd($key) {
		return self::hidden('_nonce', array('value' => self::generateNonce($key)));
	}
	static public function formValid($key) {
		$validateVal = req::getVar('_nonce');
		return !empty($validateVal) && $validateVal == self::generateNonce($key);
	}
}