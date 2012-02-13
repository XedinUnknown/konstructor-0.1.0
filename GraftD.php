<?php

/**
 * Description of GraftD
 *
 * @version 0.1.0
 * @author Xedin Unknown <xedin.unknown+xdn@gmail.com>
 */
class GraftD {
    
    protected $_surname;
    
    public function __construct($surname = 'Smith') {
        $this->_surname = $surname;
    }
    
    public function getSurname() {
        return $this->_surname;
    }
    
    public function setSurname($surname) {
        $this->_surname = $surname;
    }
}