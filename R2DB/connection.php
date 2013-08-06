<?php

class Connection {
    
    public function __construct($db_type = 'mysql', $link_name = 'default') {
        return $this->getConnector($db_type, $link_name);
        
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
    
    
}
