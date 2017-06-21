<?php
	// orders meals relation class
	class Orders_meals
	{
	    private $connection;

	    /**
	     * start database connection
	     * orders_meals constructor.
	     */
	    public function __construct()
	    {
	        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	    }

	    /**
	     * add order meals function
	     * @param $order_id
	     * @param $mealsArr [big array of meals' arrays]
	     */
	    public function addOrderMeals($order_id, $mealsArr)
	    {
	    	// first unrepeated query part
	        $sql = "INSERT INTO `orders_meals` (`order`, `meal`, `quantity`) VALUES "; 
	        // check if user choose more than on meal
			if (count($mealsArr) > 1)
			{
				foreach ($mealsArr as $meal) 
				{
					$meal_id = $meal['meal_id'];
					$quantity = $meal['quantity'];
					$sql .= " ($order_id, $meal_id, $quantity),";
				}
			}
			else 
			{
				$meal_id = $mealsArr[0]['meal_id'];
				$quantity = $mealsArr[0]['quantity'];
				$sql .= " ($order_id, $meal_id, $quantity)";
			}

			// check if there is useless comma at the end of the query
			if (strpos($sql, ',', strlen($sql) - 2))
				$sql = substr($sql, 0, -1);

			$this->connection->query($sql);

			if ($this->connection->affected_rows > 0)
				return true;

			echo $this->connection->error;
			return false;
	    }

	    /**
	     * delete order meal
	     * @param  $table_id
	     * @return boolean       
	     */
	    public function removeOrderMeal($order_id, $meal_id)
	    {
	        $this->connection->query("DELETE FROM `orders_meals` WHERE `order` = $order_id AND `meal` = $meal_id");

	        if ($this->connection->affected_rows > 0)
	            return true;

	        return false;
	    }
	}