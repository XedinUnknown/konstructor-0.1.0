<?php

/**
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */

/**
 * This class will construct the resulting classes from grafts.
 *
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class Konstructor {
    
    protected static $_konstructPropertyName = '__xedKonstructs';
    protected static $_errorExceptionClassName = 'Xedin_Exception';
    
    const DUPLICATE_ACTION_IGNORE = 'ignore';
    const DUPLICATE_ACTION_REPLACE = 'replace';
    const DUPLICATE_ACTION_STOP = 'stop';
    const DUPLICATE_ACTION_THROW = 'throw';
    
    public static function konstruct(&$destination, $sourceClassName, $duplicateAction = self::DUPLICATE_ACTION_IGNORE) {
        if( is_array($sourceClassName) ) {
            foreach( $sourceClassName as $_className ) {
                if( !self::konstruct($destination, $_className, $duplicateAction) ) {
                    break;
                }
            }
            
            return true;
        }
        
        if( !class_exists($sourceClassName, true) ) {
            self::throwError('Could not konstruct %1$s: source class does not exist.', $sourceClassName);
        }
        
        if( isset($destination[$sourceClassName]) ) {
            switch( $duplicateAction ) {
                case self::DUPLICATE_ACTION_IGNORE:
                    return true;
                    
                case self::DUPLICATE_ACTION_STOP:
                    return false;
                    
                default:
                case self::DUPLICATE_ACTION_THROW:
                    self::throwError('Could not konstruct %1$s: already exists.', $sourceClassName);
            }
        }
        
        $destination[$sourceClassName] = new $sourceClassName;
        return true;
    }
    
    public static function getKonstructMethod($destination, $methodName, $konstructName = null) {
        foreach( $destination as $className => $_object ) {
            if( method_exists($_object, $methodName) ) {
                return array($_object, $methodName);
            }
            
            if( ($_object instanceof Konstructable_Interface) && $method = $_object->getKonstructMethod() ) {
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