<?php
/**
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */

/**
 * Description of Konstruct_Collection
 *
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class Konstruct_Collection {
    
    protected $_keys;
    protected $_values;
    
    public function getElement($key, $default = null) {
        if( !isset($this->_values[$key]) ) {
            return $default;
        }
        
        return $this->_values[$key];
    }
    
    public function setElement($element, $key, $before = null, $after = null) {
        $this->_values[$key] = $element;
        
//        if( is_null($before) && is_null($after) ) {
//            $this->_keys[] = $this->_values[$key];
//            return $this;
//        }
        
        $keyIndex = array_search($key, $this->_keys);
        
        if( $keyIndex !== false ) {
            array_splice($this->_keys, $keyIndex, 1);
        }
        
        $beforeKeyIndex = $before ? array_search($before, $this->_keys) : false;
        $afterKeyIndex = $after ? array_search($after, $this->_keys) : false;
        
        if( !($beforeKeyIndex || $afterKeyIndex) ) {
            $this->_keys[] = $this->_values[$key];
            return $this;
        }
    }
}