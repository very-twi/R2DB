<?php

/**
 * connection.php
 * 
 * Conection class
 * 
 * Copyright 2013 Malishev Dmitry <dima.malishev@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */


class Connection {
    
    private $conn = null;
    
    public function __construct($db_type = 'mysql', $link_name = 'default') {
        $this->conn = $this->getConnector($db_type, $link_name);
    }
    
    public function getConnector($db_type, $link_name) {
        $details = $this->resolveConnectionDetails($db_type);
        $className = $details['className'] . 'Connection';
        
        $connector_file = R2DB_ROOT_DIR . 'connectors' . DIRECTORY_SEPARATOR . $details['file'] . '.connector.php';
        if (!is_readable($connector_file)) {
            die('File is not readable ' . $connector_file); // TODO: handle errors better
        }
        
        require_once $connector_file;
        
        
        
        return new $className(R2DB_Config::getInstance()->getDbParameterGroup($link_name));
    }
    
    public function resolveConnectionDetails($db_type) {
        $details = array(
            'file'      => null,
            'className' => null
        );
        if (strpos(strtolower($db_type), 'mysql') !== false) {
            $details['className'] = 'MySql';
            $details['file'] = 'mysql';
            if (strpos(strtolower($db_type), 'pdo') !== false) {
                $details['className'] .= 'PDO';
                $details['file'] .= '.pdo';
                
            }
        }
        
        return $details;
    }
    
    public function __call($method_name, $arguments) {
        if (method_exists($this->conn, $method_name)) {
            return call_user_method_array($method_name, $this->conn, $arguments);
        }
    }
    
    
}
