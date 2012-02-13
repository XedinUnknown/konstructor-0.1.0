<?php
/**
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */

/**
 * A numeri
 *
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class Xedin_Structure_Array_Continuous extends Xedin_Structure_Array_Numeric {
    
    protected $_isContinuous;
    
    public function isContinuous() {
        return $this->_isContinuous;
    }
    
    public function offsetGet($offset) {
        if( !$this->isContinuous() ) {
            $this->makeContinuous();
        }
        parent::offsetGet($offset);
    }
    
    protected function _afterOffsetSet($offset, &$value) {
        parent::_afterOffsetSet($offset, $value);
        $this->_isContinuous = false;
        return $this;
    }
    
    protected function _afterOffsetUnset($offset) {
        parent::_afterOffsetUnset($offset);
        $this->_isContinuous = false;
    }
    
    public function makeContinuous() {
        $this->_array = array_values($array);
        $this->_isContinuous = true;
        
        return $this;
    }
}