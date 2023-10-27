<?php

namespace Calculus\Helpers;

class DatabaseConnection
{
    /**
     * @var $db
     * @var $error
     */

    public $db;
    protected $error;

    public function __construct($host, $user, $password, $database, $port)
    {
        $driver = new \mysqli($host, $user, $password, $database, $port);
        $this->db = $driver;
    }

    public function catchException()
    {
        if ($this->db->error) {
            $this->error = $this->db->error;
        }

        return $this->error;
    }
}