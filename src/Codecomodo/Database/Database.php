<?php

namespace Codecomodo\Database;

use mysqli;

class Database
{
    protected $host;
    protected $user;
    protected $password;
    protected $database;
    protected $port;

    public $db;

    public function __construct()
    {
        $this->db = new mysqli($this->host, $this->user, $this->password, $this->database, $this->port);
    }
}