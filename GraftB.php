<?php

/**
 * Description of GraftB
 *
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class GraftB extends Xedin_Konstructable_Base {
    
    protected $_name;
    
    public function __construct($name = 'Anonimous', $surname = 'Smith') {
        $args = func_get_args();
        $this->_name = array_shift($args);
        call_user_func_array(array('parent', '__construct'), $args);
    }
    
    public function getName() {
        return $this->_name;
    }
}