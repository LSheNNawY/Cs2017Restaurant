<?php
    class Users
    {
        private $connection;

        /**
         * DB Connection
         * users constructor.
         */
        public function __construct()
        {
            $this->connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        }

        /**
         * add user function
         * @param $username
         * @param $password
         * @param $email   
         * @param $phone   
         * @param $address 
         * @param integer $type    
         * @return boolean   
         */
        public function addUser($username, $password, $email, $phone, $address, $type = 3)
        {
            // hashing password 
            $hash       = hashPassword($password);
            //escaping special characters 
            $username   = $this->connection->escape_string($username);
            $email      = $this->connection->escape_string($email);
            $phone      = $this->connection->escape_string($phone);
            $address    = $this->connection->escape_string($address);

            // query
            $this->connection->query("INSERT INTO `users` (`user_name`, `user_password`, `user_email`, `user_address`, `user_phone`, `user_type`) VALUES ('$username', '$hash', '$email', '$address', '$phone', $type)");
            // check insertion process
            if($this->connection->affected_rows>0)
                return true;

            return false;
        }

        /**
         * delete user function
         * @param  $id
         * @return boolean   
         */
        public function deleteUser($id)
        {
            $this->connection->query("DELETE FROM `users` WHERE `user_id` = $id");
            // check deleting process
            if($this->connection->affected_rows>0)
                return true;

            return false;
        }

        /**
         * update user function
         * @param $id      
         * @param $name    
         * @param $password
         * @param $email   
         * @param $phone   
         * @param $address 
         * @param $type    
         * @return boolean         
         */
        public function updateUser($id, $username, $password, $email, $address, $phone, $type)
        {
            // hashing password
            $hash = hashPassword($password);

            $sql = "UPDATE `users` SET ";

            if(strlen($username) > 0){
                $username   = $this->connection->escape_string($username);
                $sql .= " `user_name` = '$username',";
            }

            if(strlen($password) > 0)
                $sql .= " `user_password` = '$hash',";

            if(strlen($email) > 0){
                $email      = $this->connection->escape_string($email);
                $sql .= " `user_email` = '$email',";
            }

            if(strlen($address) > 0){
                $address    = $this->connection->escape_string($address);
                $sql .= " `user_address` = '$address',";
            }

            if(strlen($phone) > 0){
                $phone      = $this->connection->escape_string($phone);
                $sql .= " `user_phone` = '$phone',";
            }

            if(strlen($type)>0)
                $sql .= " `user_type` = $type,";

            // check if the sql query have ',' before 'WHERE' or not
            if(strpos($sql, ',', strlen($sql) - 2) !== false)
                $sql = substr($sql, 0, -1);

            $sql .= " WHERE `user_id` = $id";

            $this->connection->query($sql);

            if($this->connection->affected_rows>0)
              return true;
          
            echo $this->connection->error;
            return false;
        }

        /**
         * get all users function
         * @param  string $extra
         * @return array|null       
         */
        public function getUsers($extra='')
        {
            $result = $this->connection->query("SELECT * FROM `users` $extra");

            if($result->num_rows>0)
            {
                $users = array();
                while ($row = $result->fetch_assoc())
                    $users[]=$row;

                return $users;
            }

            return null;
        }

        /**
         * get user by id
         * @param $id 
         * @return  mixed|null 
         */
        public function getUserById($id)
        {
            $users = $this->getUsers("WHERE `user_id` = $id");

            if($users && count($users)>0)
                return $users[0];

            return null;
        }

        /**
         * user login function
         * @param $username
         * @param $password
         * @return array|null
         */
        public function login($useremail, $password)
        {
            // hashed password
            $hash       = hashPassword($password);
            $useremail  = $this->connection->escape_string($useremail);

            
            $admins = $this->getUsers("WHERE `user_email` = '$useremail' AND `user_password` = '$hash' LIMIT 1");

            if($admins && count($admins) > 0)
                return $admins[0];

            return null;
        }

        /**
         * destructor
         * close mysql connection
         */
        public function __destruct()
        {
            $this->connection->close();
        }
    }
