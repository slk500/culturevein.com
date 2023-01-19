<?php

declare(strict_types=1);

namespace Tests;

use Console_Table;
use Database\Base\Database;

final class DatabaseHelper
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function truncate_all_tables(): void
    {
        $tables = $this->get_all_tables_names();

        $sql = 'SET FOREIGN_KEY_CHECKS = 0;';
        foreach ($tables as $table) {
            $sql .= "TRUNCATE $table;";
        }
        $sql .= 'SET FOREIGN_KEY_CHECKS = 1;';

        $this->database->execute($sql);
    }

    public function truncate_tables(array $tables): void
    {
        $tablesNamesInDatabase = $this->get_all_tables_names();

        foreach ($tables as $table) {
            $exist = in_array($table, $tablesNamesInDatabase);

            if (!$exist) {
                throw new \Exception("There is no table '$table'' in Database!");
            }
        }

        $sql = 'SET FOREIGN_KEY_CHECKS = 0;';
        foreach ($tables as $table) {
            $sql .= "TRUNCATE $table;";
        }
        $sql .= 'SET FOREIGN_KEY_CHECKS = 1;';

        $this->database->execute($sql);
    }

    public function are_tables_empty(): bool
    {
        $sql = "SHOW TABLE STATUS WHERE Rows > 0;"; //mysql

     //   $sql = "SELECT * FROM  `information_schema`.`TABLES` WHERE  `TABLE_ROWS` > 0"; //mariadb

        $result = $this->database->fetch($sql);

        $tablesNames = [];
        foreach ($result as $res) {
            $tablesNames [] = $res['Name']; //mysql
            //$tablesNames [] = $res['TABLE_NAME']; //mariadb
        }

        if ($tablesNames) {
            throw new \Exception(PHP_EOL . 'These tables are not empty:' . implode(',',$tablesNames));
        }

        return true;
    }
//
//    public function showTables(array $show = [], array $exclude = []): void
//    {
//        if (!$show) {
//            $tableNamesInDatabase = $this->getAllTablesNames();
//        }
//
//        $isAllTablesAreEmpty = true;
//
//        foreach ($tableNamesInDatabase as $tableName) {
//
//            if (in_array($tableName, $exclude)) {
//                continue;
//            }
//
//            $sql = "SELECT * FROM $tableName";
//
//            $stmt = $this->entityManager->getConnection()->prepare($sql);
//            $stmt->execute();
//
//            $result = $stmt->fetchAll();
//
//            if ($result) {
//                $isAllTablesAreEmpty = false;
//                $this->printTable($tableName, $result);
//            }
//        }
//
//        if ($isAllTablesAreEmpty) {
//            echo PHP_EOL .  'All tables are empty';
//        }
//    }

    public function get_all_tables_names(): array
    {
        $sql = "SHOW TABLES";

        $tables_names = $this->database->fetch($sql);

        $result = [];
        foreach ($tables_names as $key => $table_name) {
            $result [] = array_shift($table_name);
        }

        return $result;
    }

    private function print_table($table, $result)
    {
        $tbl = new Console_Table();
        $headers = array_keys(reset($result));
        array_unshift($headers, '#');
        $tbl->setHeaders($headers);

        echo PHP_EOL . $table . PHP_EOL;

        $counter = 1;
        foreach ($result as $row) {

            array_unshift($row, $counter);
            $tbl->addRow($row);

            $counter++;
        }
        echo $tbl->getTable();
        return $result;
    }
}
