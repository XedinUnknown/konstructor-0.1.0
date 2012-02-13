<?php
/**
 * This class will construct the resulting classes from grafts.
 *
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class Konstructor {
    
    protected static $_konstructPropertyName = '__xedKonstructs';
    protected static $_errorExceptionClassName = 'Xedin_Exception';
    
    const DUPLICATE_ACTION_IGNORE = 'ignore';
    const DUPLICATE_ACTION_REPLACE = 'replace';
    const DUPLICATE_ACTION_STOP = 'stop';
    const DUPLICATE_ACTION_THROW = 'throw';
    
    public static function konstruct(&$destination, $source, $duplicateAction = self::DUPLICATE_ACTION_IGNORE) {
        if( is_array($source) ) {
            foreach( $source as $_className ) {
                if( !self::konstruct($destination, $_className, $duplicateAction) ) {
                    break;
                }
            }
            
            return true;
        }
        
        if( is_string($source) && !class_exists($source, true) ) {
            self::throwError('Could not konstruct %1$s: source class does not exist.', $source);
        }
        
        if( isset($destination[$source]) ) {
            switch( $duplicateAction ) {
                case self::DUPLICATE_ACTION_IGNORE:
                    return true;
                    
                case self::DUPLICATE_ACTION_STOP:
                    return false;
                    
                default:
                case self::DUPLICATE_ACTION_THROW:
                    self::throwError('Could not konstruct %1$s: already exists.', $source);
            }
        }
        
        if( is_string($source) ) {
            $source = new $source;
        }
        
        $sourceClassName = get_class($source);
        $destination[$sourceClassName] = $source;
        return true;
    }
    
    public static function getKonstructMethod($destination, $methodName, $konstructName = null) {
        foreach( $destination as $className => $_object ) {
            if( method_exists($_object, $methodName) ) {
                return array($_object, $methodName);
            }
            
            if( ($_object instanceof Xedin_Konstructable_Interface) && $method = $_object->getKonstructMethod($methodName, $konstructName) ) {
                return $method;
            }
        }
        
        return false;
    }
    
    public static function getKonstructPropertyName() {
        return self::$_konstructPropertyName;
    }
    
    public static function getErrorExceptionClassName() {
        return self::$_errorExceptionClassName;
    }
    
    public static function getKonstructs(&$source) {
        return $source;
    }
    
    public static function getKonstructsCount(&$source) {
        return (empty($source) ? 0 : count($source));
    }
    
    protected static function throwError($errorFormat, $variables = null) {
        $args = func_get_args();
        $errorFormat = $args[0];
        $errorText = $errorFormat;
        if( !empty($args) ) {
            $errorText = call_user_func_array('sprintf', $args);
        }
        $errorExceptionClassName = self::getErrorExceptionClassName();
        throw new $errorExceptionClassName($errorText);
    }
}