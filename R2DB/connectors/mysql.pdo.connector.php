<?php

/**
 * mysql.pdo.connector.php
 * 
 * Mysql PDO connection handler class
 * 
 * Copyright 2013 Malishev Dmitry <dima.malishev@gmail.com>
 * 
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */


class MySqlPDOConnection extends AbstractConnector {
    
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
    
    public function Execute($query) {
        if (func_num_args() == 1) {
            return $this->conn->query($query)->fetch();
        }

        $args = func_get_args();
        $rs = $this->conn->query($this->autoQuote(array_shift($args), $args))->execute(PDO::FETCH_ASSOC);
        
        return $rs;
    }
    
    public function GetOne($query) {
        if (func_num_args() == 1) {
            return $this->conn->query($query)->fetch();
        }

        $args = func_get_args();
        $rs = $this->conn->query($this->autoQuote(array_shift($args), $args))->fetch(PDO::FETCH_ASSOC);
        
        return $rs;
    }
    
    public function GetAll($query) {
        if (func_num_args() == 1) {
            return $this->conn->query($query)->fetchAll();
        }

        $args = func_get_args();
        $rs = $this->conn->query($this->autoQuote(array_shift($args), $args))->fetchAll(PDO::FETCH_ASSOC);
        
        return $rs;
    }
    
    public function autoQuote($query, array $args) {
        $i = strlen($query) - 1;
        $c = count($args);

        while ($i--) {
            if ('?' === $query[$i] && false !== $type = strpos('sia', $query[$i + 1])) {
                if (--$c < 0) {
                    throw new InvalidArgumentException('Too little parameters.');
                }

                if (0 === $type) {
                    $replace = $this->conn->quote($args[$c]);
                } elseif (1 === $type) {
                    $replace = intval($args[$c]);
                } elseif (2 === $type) {
                    foreach ($args[$c] as &$value) {
                        $value = $this->conn->quote($value);
                    }
                    $replace = '(' . implode(',', $args[$c]) . ')';
                }

                $query = substr_replace($query, $replace, $i, 2);
            }
        }

        if ($c > 0) {
            throw new InvalidArgumentException('Too many parameters.');
        }

        return $query;
    }
    
}
