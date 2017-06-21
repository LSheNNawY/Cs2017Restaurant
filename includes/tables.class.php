<?php

class Tables
{
    private $connection;

    /**
     * DB Connection
     * tables constructor.
     */

    public function __construct()
    {
        $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    }


    /**
     * add new table
     * @param $title  
     * @param $numbers
     * @return boolean
     */
    public function addTable($title, $numbers)
    {
        $this->connection->query("INSERT INTO `tables`(`table_title`,`table_chairs_numbers`) VALUES ('$title',$numbers)");

        if($this->connection->affected_rows>0)
            return true;

        return false;
    }

    /**
     * delete table
     * @param $id
     * @return bool
     */
    public function deleteTable($id)
    {
        $this->connection->query("DELETE FROM `tables` WHERE `table_id` = $id");

        if($this->connection->affected_rows > 0)
            return true;

        return false;
    }

    /**
     * Update Table
     *
     * @param $id
     * @param $title
     * @param $description
     * @param $available
     * @return bool
     */
    public function updateTable($id, $title, $number, $available)
    {
        $sql = "UPDATE `tables` SET ";

        if(strlen($title) > 0)
            $sql .= " `table_title` = '$title',";
        if(strlen($number) > 0)
            $sql .= " `table_chairs_numbers` = $number,";
        if(strlen($available) > 0)
            $sql .= " `table_availability` = $available,";

        // check if the sql query have ',' before 'WHERE' or not
        if(strpos($sql, ',', strlen($sql) - 2) !== false)
            $sql = substr($sql, 0, -1);

        $sql .= " WHERE `table_id` = $id";

        $this->connection->query($sql);

        if($this->connection->affected_rows > 0)
            return true;

        return false;
    }

    /**
     * get all tables
     * @param string $extra
     * @return array|null
     */

    public function getTables($extra='')
    {
        $result = $this->connection->query("SELECT * FROM `tables` $extra");
        if($result->num_rows > 0)
        {
            $tables = array();

            while ($row = $result->fetch_assoc())
                $tables[]=$row;

            return $tables;
        }

        return null;
    }


    public function getTablesByAvailDate($unAvail = array()){
        $tables = $this->getTables();
        $avialTables = [];

        foreach ($tables as $table)
        {
            if (!in_array($table['table_id'], $unAvail)) 
                $avialTables[] = $table;

        }
        return $avialTables;
    }

    /**
     * get all chairs number
     * @return array|null
     */
    public function getTablesByChairs($number)
    {
        $tables = $this->getTables("WHERE `table_chairs_numbers` = '$number'");

        if ($tables && count($tables) > 0)
            return $tables;

        return null;
    }


    /**
     * get table By Id
     * @param $id
     * @return mixed|null
     */
    public function getTableById($id)
    {
        $tables = $this->getTables("WHERE `table_id` = $id");

        if($tables && count($tables)>0)
            return $tables[0];

        return null;
    }

    /**
     * close the db connection
     */
    public function __destruct()
    {
        $this->connection->close();
    }
}
