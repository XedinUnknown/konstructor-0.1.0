<?php

/**
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */

/**
 * An array that forces numeric values.
 *
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class Xedin_Structure_Array_Numeric extends Xedin_Structure_Array {
    
    public function __construct($array = array()) {
        parent::__construct( array_values($array) );
    }
    
    public function offsetSet($offset, $value) {
        if( !is_numeric($offset) ) {
            return $this;
        }
        
        parent::offsetSet( intval($offset), $value );
        return $this;
    }
    
    public function offsetGet($offset) {
        if( !is_numeric($offset) ) {
            return null;
        }
        
        return parent::offsetGet( intval($offset) );
    }
}