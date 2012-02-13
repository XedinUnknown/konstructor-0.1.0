<?php
/**
 * Description of Konstructable_Interface
 *
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
interface Xedin_Konstructable_Interface {
    
    public function getKonstructMethod($methodName, $konstructName = null);
    
    public function hasKonstructMethod($methodName, $konstructName = null);
    
    public function callKonstructMethod($konstructName, $methodName, $arguments = null);
    
    public function getKonstructState($konstructName, $stateName);
    
    public function setKonstructState($konstructName, $stateName, $stateValue);
}