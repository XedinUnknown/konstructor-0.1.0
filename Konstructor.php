<?php
/**
 * This class will construct the resulting classes from grafts.
 *
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class Konstructor {
    
    protected static $_errorExceptionClassName = 'Xedin_Exception';
    
    const DUPLICATE_ACTION_IGNORE = 'ignore';
    const DUPLICATE_ACTION_REPLACE = 'replace';
    const DUPLICATE_ACTION_STOP = 'stop';
    const DUPLICATE_ACTION_THROW = 'throw';
    
    const DESTINATION_INDEX_OBJECT = '_knstrctr_object';
    const DESTINATION_INDEX_FUNCTION_MAP  = '_knstrctr_function_map';
    
    public static function konstruct(&$destination, $source, $duplicateAction = self::DUPLICATE_ACTION_IGNORE) {
        $sourceIsDelegate = ( is_array($source) && isset($source[self::DESTINATION_INDEX_OBJECT]) );
        
        /*
         * If source is an array, but not a delegate, treat as array of source
         * classes/objects and konstruct them all.
         */
        if( is_array($source) && !$sourceIsDelegate ) {
            foreach( $source as $_className ) {
                if( !self::konstruct($destination, $_className, $duplicateAction) ) {
                    break;
                }
            }
            
            return true;
        }
        
        $delegate = array();
        
        /*
         * If source is not an array and not a delegate, treat as a single
         * class/object and normalize.
         */
        if( !$sourceIsDelegate ) {
            $delegate[self::DESTINATION_INDEX_OBJECT] = ( is_string($source) ? new $source : $source);
        }
        
        /**
         * If source is a string, and class with this name does not exist,
         * throw error.
         */
        if( is_string($delegate[self::DESTINATION_INDEX_OBJECT]) && !class_exists($delegate[self::DESTINATION_INDEX_OBJECT], true) ) {
            self::throwError('Could not konstruct %1$s: source class does not exist.', $delegate[self::DESTINATION_INDEX_OBJECT]);
        }
        
        /**
         * If source is an array which is a delegate, check whether the object
         * index is a string or an object, and if string - instantiate.
         */
        $delegate[self::DESTINATION_INDEX_OBJECT] = ( is_string($delegate[self::DESTINATION_INDEX_OBJECT]) 
                ? new $delegate[self::DESTINATION_INDEX_OBJECT]
                : $delegate[self::DESTINATION_INDEX_OBJECT] );
        
        $sourceClassName = ( is_string($delegate[self::DESTINATION_INDEX_OBJECT])
                ? $delegate[self::DESTINATION_INDEX_OBJECT]
                : get_class($delegate[self::DESTINATION_INDEX_OBJECT]) );
        
        if( isset($destination[$sourceClassName]) ) {
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
        
        $destination[$sourceClassName] = $delegate;
        return true;
    }
    
    public static function getKonstructMethod($destination, $methodName, $konstructName = null) {
        foreach( $destination as $className => $_config ) {
            $_object = $_config[self::DESTINATION_INDEX_OBJECT];
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