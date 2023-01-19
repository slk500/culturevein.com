<?php


namespace Database\Base;


abstract class Repository
{
    protected Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
}