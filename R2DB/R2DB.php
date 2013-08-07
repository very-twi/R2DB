<?php

/**
 * R2DB.php
 * 
 * Core class
 * 
 * Copyright 2013 Malishev Dmitry <dima.malishev@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';
require_once R2DB_ROOT_DIR . 'connection.php';
require_once R2DB_ROOT_DIR . 'connectors/abstract.connector.php';

class R2DB {
    
    static $use_link = 'default';
    protected static $instances = array();
    
    static public function getInstance($link_name = 'default') {
        if (empty(self::$instances[$link_name])) {
            self::$instances[$link_name] = new Connection(R2DB_Config::DB_TYPE, $link_name);
        }
        
        return self::$instances[$link_name];
    }
    
    static public function Execute($query, $arguments = array()) {
        return self::getInstance(self::$use_link)->Execute($query, $arguments);
    }
    
    static public function useLink($link_name = 'default') {
        R2DB::$use_link = $link_name;
    }
    
    static public function GetOne($query, $arguments = array()) {
        return self::getInstance(self::$use_link)->GetOne($query, $arguments);
    }
    
    static public function GetAll($query, $arguments = array()) {
        return self::getInstance(self::$use_link)->GetOne($query, $arguments);
    }
    
    static public function Delete() {
        
    }
    
    static public function Insert() {
        
    }
    
    static public function Update() {
        
    }
    
    //
    //  Shortcut functions
    //
    static public function q($query, $arguments = array()) {
        return self::getInstance(self::$use_link)->GetAll($query, $arguments);
    }
    
    static public function x($query, $arguments = array()) {
        return self::getInstance(self::$use_link)->Execute($query, $arguments);
    }
    
    
}
