<?php
/**
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class GraftA extends Xedin_Konstructable_Base {
    
//    public function __construct() {
//        $args = func_get_args();
//        call_user_func_array(array('parent', '__construct'), $args);
//    }
    
    protected function _construct() {
        $this->_konstruct(array('GraftC', 'GraftB', 'GraftC'));
    }
}