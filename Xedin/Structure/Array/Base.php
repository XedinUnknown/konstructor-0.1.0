<?php

/**
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */

/**
 * A basic OO wrapper around an array.
 *
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class Xedin_Structure_Array_Base implements ArrayAccess, Countable {
    protected $_array;
    
    public function __construct($array = array()) {
        if( is_array($array) ) {
            $this->_array = $array;
        }
    }
    
    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->_array[] = $value;
        } else {
            $this->_array[$offset] = $value;
        }
    }
    
    public function offsetExists($offset) {
        return isset($this->_array[$offset]);
    }
    
    public function offsetUnset($offset) {
        unset($this->_array[$offset]);
    }
    
    public function offsetGet($offset) {
        return isset($this->_array[$offset]) ? $this->_array[$offset] : null;
    }
    
    public function count() {
        return count($this->_array);
    }
}