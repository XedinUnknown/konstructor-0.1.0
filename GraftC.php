<?php

/**
 * Description of GraftB
 *
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class GraftC {
    
    protected $_name;
    
    public function __construct($name = 'Anonimous2') {
        $this->_name = $name;
    }
    
    public function getName() {
        return $this->_name;
    }
}