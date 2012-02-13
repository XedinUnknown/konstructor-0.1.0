<?php
/**
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
/**
 * Description Xedin_Structure_Array Array
 *
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class Xedin_Structure_Array extends Xedin_Structure_Array_Base {
    
    /** @var bool The count flag. Indicates whether the number of elements needs to be recalculated. */
    protected $_isCountChanged;
    protected $_lastCount;
    
    public function isCountChanged() {
        return (bool)$this->_isCountChanged;
    }
    
    public function offsetUnset($offset) {
        $offset = $this->_beforeOffsetUnset($offset);
        
        if( $this->offsetExists($offset) ) {
            parent::offsetUnset($offset);
            $this->_isCountChanged = true;
            $this->_afterOffsetUnset($offset);
        }
        
        return $this;
    }
    
    public function offsetSet($offset, $value) {
        if( !$this->offsetExists($offset) ) {
            $this->_isCountChanged = true;
        }
        
        $offset = $this->_beforeOffsetSet($offset, $value);
        parent::offsetSet($offset, $value);
        $this->_afterOffsetSet( $this->offsetGet($offset) );
        
        return $this;
    }
    
    public function count() {
        
        if( $this->isCountChanged() ) {
            $this->_lastCount = count($this->_array);
        }
    }
    
    public function splice($offset, $length = 0, $replacement = null) {
        return array_splice($this->_array, $offset, $length, $replacement);
    }
    
    public function shift() {
        return array_shift($this->_array);
    }
    
    /**
     * Occurs before the offset is set, but after the count flag is modified.
     * Can potentially modify value.
     * 
     * @see offsetSet()
     * @param string|int $offset The offset that will be set.
     * @param mixed $value The value that will be set.
     * @return string|int The new offset.
     */
    protected function _beforeOffsetSet($offset, &$value) {
        return $offset;
    }
    
    /**
     * Occurs right after an offset has been set.
     * 
     * @see offsetSet()
     * @param string|int $offset The offset that was set.
     * @param mixed $value The value that was set.
     * @return \Xedin_Structure_Array This instance.
     */
    protected function _afterOffsetSet($offset, &$value) {
        return $this;
    }
    
    /**
     * Occurs when an offset is attempted to be unset, regardless whether
     * it exists and will be unset.
     * 
     * @param string|int $offset The offset that is about to be unset.
     * @return string|int The new offset.
     */
    protected function _beforeOffsetUnset($offset) {
        return $offset;
    }
    
    /**
     * Occurs right after an offset has been unset. The offset had to
     * previously exist for this event to occur.
     * 
     * @param string|int $offset The offset that has been unset.
     * @return \Xedin_Structure_Array This instance.
     */
    protected function _afterOffsetUnset($offset) {
        return $this;
    }
    
    /**
     * Occurs when the element count is attempter to be calculated, regardless
     * of whether the process is going to take place or not.
     * 
     * @return \Xedin_Structure_Array This instance.
     */
    protected function _beforeCount() {
        return $this;
    }
    
    /**
     * Occurs after the element count has been recalculated. The processing
     * had to have taken place for this event to occur.
     * @return \Xedin_Structure_Array This instance.
     */
    protected function _afterCount() {
        return $this;
    }
}