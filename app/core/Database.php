<?php

class Database
{
    // Property untuk koneksi ke Database
    private $host = DB_HOST;
    private $port = DB_PORT;
    private $dbname = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;

    // Property internal dari class Database
    private static $instance = null;
    private $pdo;
    private $columnName = "*";
    private $orderBy = "";
    private $count = 0;
    private $method = PDO::FETCH_OBJ;

    private function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->dbname", $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Koneksi dibuat.. <br>";
        } catch (PDOException $e) {
            die("Koneksi/Query bermasalah: " . $e->getMessage() . " (" . $e->getCode() . ")");
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance))
            self::$instance = new Database();
        return self::$instance;
    }

    public function runQuery($query, $bindValue = [])
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($bindValue);
        } catch (PDOException $e) {
            die("Koneksi/Query bermasalah: " . $e->getMessage() . " (" . $e->getCode() . ")");
        }
        $this->count = $stmt->rowCount();
        return $stmt;
    }

    public function getQuery($query, $bindValue = [])
    {
        $result = $this->runQuery($query, $bindValue)->fetchAll($this->method);
        $this->method = PDO::FETCH_OBJ;
        return $result;
    }

    public function fetchAssoc()
    {
        $this->method = PDO::FETCH_ASSOC;
    }

    public function get($tableName, $condition = "", $bindValue = [])
    {
        $query = "SELECT {$this->columnName} FROM {$tableName}" . " {$condition} " . $this->orderBy;
        $this->columnName = "*";
        $this->orderBy = "";
        return $this->getQuery($query, $bindValue);
    }

    public function select($columnName)
    {
        $this->columnName = $columnName;
        return $this;
    }

    public function orderby($columnName, $sortType = "ASC")
    {
        $this->orderBy = "ORDER BY {$columnName} {$sortType}";
        return $this;
    }

    public function getWhere($tableName, $condition)
    {
        $queryCondition = "WHERE {$condition[0]} {$condition[1]} ?";
        return $this->get($tableName, $queryCondition, [$condition[2]]);
    }

    public function getWhereOnce($tableName, $condition)
    {
        $result = $this->getWhere($tableName, $condition);
        if (!empty($result))
            return $result[0];
        else
            return false;
    }

    public function getLike($tableName, $columnName, $search)
    {
        $queryLike = "WHERE {$columnName} LIKE ?";
        return $this->get($tableName, $queryLike, [$search]);
    }

    public function check($tableName, $columnName, $dataValue)
    {
        $query = "SELECT {$columnName} FROM {$tableName} WHERE {$columnName} = ?";
        return $this->runQuery($query, [$dataValue])->rowCount();
    }

    public function count()
    {
        return $this->count;
    }

    public function insert($tableName, $data)
    {
        $dataKeys = array_keys($data);
        $dataValues = array_values($data);
        $query = "INSERT INTO $tableName (" . implode(", ", $dataKeys) . ") VALUES (" . str_repeat("?,", count($data) - 1) . "?)";
        $this->count = $this->runQuery($query, $dataValues)->rowCount();
        return true;
    }

    public function update($tableName, $data, $condition)
    {
        $dataKeys = array_keys($data);
        $dataValues = array_values($data);
        $setQuery = "";
        for ($i = 0; $i < count($data); $i++) {
            $setQuery .= "{$dataKeys[$i]} = ?";
            if ($i != count($data) - 1)
                $setQuery .= ", ";
        }
        $query = "UPDATE {$tableName} SET {$setQuery} WHERE {$condition[0]} {$condition[1]} ?";
        array_push($dataValues, $condition[2]);
        $this->count = $this->runQuery($query, $dataValues)->rowCount();
        return true;
    }

    public function delete($tableName, $condition)
    {
        $query = "DELETE FROM {$tableName} WHERE {$condition[0]} {$condition[1]} ?";
        $this->count = $this->runQuery($query, [$condition[2]])->rowCount();
        return true;
    }

    public function delete2($tableName, $condition, $condition2)
    {
        $query = "DELETE FROM {$tableName} WHERE {$condition[0]} {$condition[1]} ? AND {$condition2[0]} {$condition2[1]} ?";
        $this->count = $this->runQuery($query, [$condition[2], $condition2[2]])->rowCount();
        return true;
    }
}
