<?php
/**
 * Description of GraftA
 *
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class Xedin_Konstructable_Base implements Xedin_Konstructable_Interface {
    
    /** @var Konstructor */
    protected $_konstructor;
    
    protected $_konstructs;
    
    public function __construct() {
        $this->_konstructs = array();
        $this->_konstructor = 'Konstructor';
        $this->_construct();
    }
    
    protected function _construct() {
        return $this;
    }
    
    protected function _callKonstructorMethod($methodName, $args = array(), $konstructor = null) {
        if( is_null($konstructor) ) {
            $konstructor = $this->getKonstructor();
        }
        
        $method = array($konstructor, $methodName);
        if( is_string($konstructor) ) {
            $method = $konstructor . '::' . $methodName;
        }
        
        return call_user_func_array($method, $args);
    }
    
    protected function _setKonstructor($konstructor) {
        $this->_konstructor = $konstructor;
    }
    
    public function __call($name, $arguments) {
        return $this->callKonstructMethod($name, $arguments);
    }
    
# Implementing Konstructable_Interface =========================================
    
    protected function _konstruct($sourceClassName, $konstructor = null) {
        if( is_null($konstructor) ) {
            $konstructor = $this->getKonstructor();
        }
        $this->_callKonstructorMethod( 'konstruct', array(&$this->_konstructs, $sourceClassName), $konstructor );
    }
    
    public function getKonstructMethod($methodName, $konstructName = null) {
        return $callback = $this->_callKonstructorMethod('getKonstructMethod', array(&$this->_konstructs, $methodName, $konstructName));
    }
    
    public function callKonstructMethod($methodName, $arguments = null, $konstructName = null) {
        $callback = $this->getKonstructMethod($methodName, $konstructName);
        if( !$callback ) {
            $message = 'Method "' . $methodName . '" does not exist in ';
            if( !$this->hasKonstructs() ) { 
                $message .= get_class($this) . '. This class uses no konstructs.';
            }
            else {
                $message .= 'neither ' . get_class($this) . ' nor in ' . implode(' or ', array_keys($this->getKonstructs()));
            }
            throw new Exception($message);
        }
        
        return call_user_func_array($callback, $arguments);
    }
    
    public function getKonstructState($konstructName, $stateName) {
        
    }
    
    public function setKonstructState($konstructName, $stateName, $stateValue) {
        
    }
    
    public function hasKonstructMethod($methodName, $konstructName = null) {
        return (bool)$this->getKonstructMethod($methodName, $konstructName);
    }
    
    public function getKonstructs() {
        return $this->_callKonstructorMethod('getKonstructs', array(&$this->_konstructs));
    }
    
    public function hasKonstructs() {
        return (bool)$this->_callKonstructorMethod('getKonstructsCount', array(&$this->_konstructs));
    }
    
    public function getKonstructor() {
        return $this->_konstructor;
    }
}