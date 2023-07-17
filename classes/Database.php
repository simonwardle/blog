<?php

/**
 * Database
 * 
 * A connection to the database
 */
class Database
{
    protected $db_host;
    protected $db_user;
    protected $db_pass;
    protected $db_name;

    public function __construct($host, $user, $password, $name)
    {
        $this->db_host = $host;
        $this->db_user = $user;
        $this->db_pass = $password;
        $this->db_name = $name;

    }
    /**
     * Get the database connection
     * 
     * @return PDO object Connection to the database server
     */
    public function getConn()
    {
        $dsn = 'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name . ';charset=utf8';

        try {

            return new PDO($dsn, $this->db_user, $this->db_pass);
        } catch (PDOException $e) {

            echo $e->getMessage();
            exit;
        }
    }
}
