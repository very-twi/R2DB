<?php

/**
 * config.php
 * 
 * Config class
 * 
 * Copyright 2013 Malishev Dmitry <dima.malishev@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */


define ('R2DB_ROOT_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);

/**
 * Config class, used to contain necessary configuration parameters
 *  
 */
class R2DB_Config {
    
    private $DB_PARAMS = array(
        'default' => array(
            'DB_HOST' => 'localhost',
            'DB_NAME' => 'command_center',
            'DB_USER' => 'root',
            'DB_PSW'  => ''
        )
    );
    
    const DB_TYPE    = 'pdo_mysql';
    
    protected static $instance = null;
   
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new R2DB_Config();
        }

        return self::$instance;
    }

    function getDbParameter($key, $link_name = 'default') {
        if (empty($this->DB_PARAMS[$link_name]) || empty($this->DB_PARAMS[$link_name][$key])) {
            // error
        }
        
        return $this->DB_PARAMS[$link_name][$key];

    }
    
    function getDbParameterGroup($key) {
        if (empty($this->DB_PARAMS[$key])) {
            // error
        }
        
        return $this->DB_PARAMS[$key];

    }
    
    
   
}
