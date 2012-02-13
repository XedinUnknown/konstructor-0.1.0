<?php

/**
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */

/**
 * Xedin_Structure_Array_Consistent
 *
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class Xedin_Structure_Array_Consistent extends Xedin_Structure_Array {
    
    public function offsetUnset($offset) {
        parent::offsetUnset($offset);
        $this->splice($offset, 1);
        return $this;
    }
}