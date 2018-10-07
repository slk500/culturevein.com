<?php

namespace Service;

use Console_Table;
use Repository\Database;

final class DatabaseHelper
{
    private $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    public function truncateTables(array $tables): void
    {
        $tablesNamesInDatabase = $this->getAllTablesNames();

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

    public function checkIsAllTablesAreEmpty()
    {
        $sql = "SHOW TABLE STATUS WHERE Rows > 0;";

        $result = $this->database->fetch($sql);

        $tablesNames = [];
        foreach ($result as $res) {
            $tablesNames [] = $res['Name'];
        }

        if ($tablesNames) {
            throw new \Exception(PHP_EOL . 'These tables are not empty:' . implode(',',$tablesNames));
        }
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

    public function getAllTablesNames(): array
    {
        $sql = "SHOW TABLES";

        $tablesNames = $this->database->fetch($sql);

        $result = [];
        foreach ($tablesNames as $tableName) {
            $result [] = $tableName['Tables_in_culture'];
        }

        return $result;
    }

    private function printTable($table, $result)
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
