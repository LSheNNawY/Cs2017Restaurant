<?php

class UsersTables
{
    private $connection;

    /**
     * DB Connection
     * users_tables constructor.
     */
    public function __construct()
    {
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    /**
     * Table reservation function
     * @param $time_start
     * @param $time_end
     * @param $user
     * @param $table
     * @return bool
     */
    public function userReservation($user, $table, $time_start)
    {
        $this->connection->query("INSERT INTO `users_tables` (`user`, `table`, `table_reservation_time_start`) VALUES ('$user', '$table', '$time_start')");

        if($this->connection->affected_rows > 0)
            return true;

        return false;
    }

    /**
     * delete or cancel reservation
     * @param  $user_id
     * @param  $table_id
     * @return boolean       
     */
    public function removeReservation($user_id, $table_id)
    {
        $this->connection->query("DELETE FROM `users_tables` WHERE `user` = $user_id AND `table` = $table_id");

        if ($this->connection->affected_rows > 0)
            return true;

        return false;
    }

    /**
     * get all tables reservations function
     * @param string $extra
     * @return array|null
     */
    public function getAllReservations($extra='')
    {
        $result = $this->connection->query("SELECT `users_tables`.*, `users`.`user_name`, `users`.`user_phone`, `tables`.`table_title` FROM `users_tables` LEFT JOIN `users` ON `users_tables`.`user` = `users`.`user_id` LEFT JOIN `tables` ON `users_tables`.`table` = `tables`.`table_id` $extra");

        if($result->num_rows> 0 )
        {
            $tables = array();
            while ($row = $result->fetch_assoc())
                $tables[]=$row;

            return $tables;
        }
        return null;
    }

    /**
     * ************for checking if user reload the page *****
     * @param $id
     * @return array|null
     */
    public function getReservationsByTableId($id)
    {
        $reservations = $this->getAllReservations("WHERE `table` = $id");

        if ($reservations && count($reservations) > 0)
            return $reservations;

        return null;
    }
    /**
     * get table reservations by user id
     * @param  $id
     * @return array|null
     */
    public function getReservationsByUserId($id)
    {
        // reuse getAllReservations function
        $reservations = $this->getAllReservations("WHERE `user` = $id");

        if ($reservations && count($reservations) > 0)
            return $reservations;

        return null;
    }
}