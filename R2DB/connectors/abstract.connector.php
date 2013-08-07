<?php

/**
 * abstract.connector.php
 * 
 * Abstract connector class
 * 
 * Copyright 2013 Malishev Dmitry <dima.malishev@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

abstract class AbstractConnector {
    
    public function Execute($query) {}
    
    public function GetOne($query) {}
    
    public function GetAll($query) {}
    
    public function autoQuote($query, array $args) {}
    
}
