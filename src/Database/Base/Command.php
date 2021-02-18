<?php

namespace Database\Base;


abstract class Command
{
    protected Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }
}