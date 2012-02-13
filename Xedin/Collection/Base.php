<?php
/**
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */

/**
 * Description of Base
 *
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class Xedin_Collection_Base {
    
    /** @var Xedin_Structure_Array_Numeric */
    protected $_ids;
    
    /** @var array */
    protected $_items;
    
    /**
     * @return Xedin_Structure_Array_Numeric The ids of the items in this collection.
     */
    public function getIds() {
        return $this->_ids;
    }
    
    /**
     * The array of items in this collection.
     * @return type 
     */
    public function getItems() {
        return $this->_items;
    }
}