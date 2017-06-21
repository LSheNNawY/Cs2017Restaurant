<?php 
	//orders class
	class Orders
	{
		private $connection;
		/**
		 * start database connection
		 * class constructor
		 */
		public function __construct()
		{
			$this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		}

		/**
		 * add new order
		 * @param $order_id          
		 * @param $client_id         
		 * @param $order_total_price 
		 * @return boolean
		 */
		public function addOrder($order_id, $client_id, $order_total_price)
		{
			// query
			$this->connection->query("INSERT INTO `orders`(`order_id`, `client`, `order_total_price`) VALUES ($order_id, $client_id, $order_total_price)");
			// check if the query id done
			if ($this->connection->affected_rows > 0)
				return true;
			return false;
		}

		/**
		 * delete order function
		 * @param   $id
		 * @return boolean   
		 */
		public function deleteOrder($id)
		{
			// query
			$this->connection->query("DELETE FROM `orders` WHERE `order_id` = $id");
			// check if the quey is done
			if ($this->connection->affected_rows > 0)
				return true;
			return false;
		}

		/**
		 * update meal function
		 * @param  $order_id     
		 * @param  $order_total_price   
		 * @param  $order_status
		 * @return  boolean       
		 */
		public function updateOrder($order_id, $order_status)
		{		
			// query 
			$this->connection->query("UPDATE `orders` SET `order_status` = $order_status WHERE `order_id` = $order_id");
			// check if the query is done
			if ($this->connection->affected_rows > 0)
				return true;

			/* echo $this->connection->error; */
			return false;
		}

		/**
		 * get all meals function
		 * @param  string $extra
		 * @return array|null     
		 */
		public function getOrders($extra='')
		{
			// query
			$result = $this->connection->query("SELECT `orders`.*, `users`.`user_name` FROM `orders` LEFT JOIN `users` ON `orders`.`client` = `users`.`user_id` $extra ORDER BY `orders`.`order_time` DESC");

			// check if there is meals returned
			if ($result->num_rows > 0)
			{
				$meals = array();

				while ($row = $result->fetch_assoc())
					$meals[] = $row;

				return $meals;
			}
			// return null if there is no meal founded
			return null;
		}

		/**
		 * get orders by client id
		 * @param  $category_id
		 * @return             
		 */
		public function getOrdersByClientId($client_id)
		{
			// use getOrders function
			$orders = $this->getOrders("WHERE `client` = $client_id");
			// check if there is result returned 
			if ($orders && count($orders) > 0)
				return $orders;

			return null;
		}

		/**
		 * get orders by status
		 * @param  $category_id
		 * @return             
		 */
		public function getOrdersByStatus($order_status)
		{
			// use getOrders function
			$orders = $this->getOrders("WHERE `order_status` = $order_status");
			// check if there is result returned 
			if ($orders && count($orders) > 0)
				return $orders;

			return null;
		}

		/**
		 * get orders by id function
		 * @param  $id
		 * @return array|null 
		 */
		public function getOrderById($id)
		{
			// use getOrders function 
			$orders = $this->getOrders("WHERE `order_id`=$id");
			// check if there is result returned 
			if ($orders && count($orders) > 0)
				return $orders[0];

			return null;
		}

		/**
		 * end database connection
		 */
		public function __destruct()
		{
			$this->connection->close();
		}
	}