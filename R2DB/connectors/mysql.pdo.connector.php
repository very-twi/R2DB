<?php

class MySqlPDOConnection {
    
    protected $conn = null;
    
    public function __construct($connectionDetails = array()) {
        try {
            $this->conn = new PDO(
                'mysql:host=' . $connectionDetails['DB_HOST'] . ';dbname=' . $connectionDetails['DB_NAME'],
                $connectionDetails['DB_USER'],
                $connectionDetails['DB_PSW']
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } 
        catch (PDOException $e) {
            die('Database connection could not be established.');
        }
        
        return $this->conn;
    }
    
    public static function GetOne($query) {
        if (func_num_args() == 1) {
            return $this->conn->query($query)->fetch();
        }

        $args = func_get_args();
        $rs = $this->conn->query(self::autoQuote(array_shift($args), $args))->fetch();
        
        return $rs;
    }
    
}
