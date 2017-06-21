<?php 
	//meals class
	class Meals
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
		 * add new meal function
		 * @param $title   
		 * @param $category
		 * @param $meal_description
		 * @param $meal_image
		 * @param $price
		 * @return boolean
		 */
		public function addMeal($title, $category, $meal_description, $meal_image, $price)
		{
			// query
			$this->connection->query("INSERT INTO `meals`(`meal_title`, `category`, `meal_description`, `meal_image`, `meal_price`) VALUES ('$title', $category, '$meal_description', '$meal_image' ,$price)");
			// check if the query id done
			if ($this->connection->affected_rows > 0)
				return true;
			return false;
		}

		/**
		 * delete meal function
		 * @param   $id
		 * @return boolean   
		 */
		public function deleteMeal($id)
		{
			// query
			$this->connection->query("DELETE FROM `meals` WHERE `meal_id`=$id");
			// check if the quey is done
			if ($this->connection->affected_rows > 0)
				return true;
			return false;
		}

		/**
		 * update meal function
		 * @param  $id      
		 * @param  $title   
		 * @param  $category
		 * @param  $meal_description
		 * @param  $meal_image
		 * @param  $price   
		 * @return  boolean       
		 */
		public function updateMeal($id, $title, $category, $meal_description, $meal_image, $price)
		{
			// sql query
			$sql = "UPDATE `meals` SET ";

			if (strlen($title) > 0)
				$sql .= " `meal_title`='$title',";

			if (strlen($category) > 0)
				$sql .= " `category`=$category,";

			if (strlen($meal_description) > 0)
				$sql .= " `meal_description`='$meal_description',";

			if (strlen($meal_image) > 0)
				$sql .= " `meal_image`='$meal_image',";

			if (strlen($price) > 0)
				$sql .= " `meal_price`=$price,";

			// check if the sql query have ',' before 'WHERE' or not
            if(strpos($sql, ',', strlen($sql) - 2) !== false)
                $sql = substr($sql, 0, -1);

			$sql .= " WHERE `meal_id`=$id";
			// query 
			$this->connection->query($sql);
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
		public function getMeals($extra='')
		{
			// query
			$result = $this->connection->query("SELECT `meals`.*, `meals_categories`.`category_title` FROM `meals` LEFT JOIN `meals_categories` ON `meals`.`category` = `meals_categories`.`category_id` $extra ORDER BY `meals`.`meal_id` DESC");

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
		 * get meals by category id
		 * @param  $category_id
		 * @return             
		 */
		public function getMealsByCategoryId($category_id)
		{
			// use getMeals function
			$meals = $this->getMeals("WHERE `category` = $category_id");
			// check if there is result returned 
			if ($meals && count($meals) > 0)
				return $meals;
			return null;
		}

		/**
		 * get meals by order id function
		 * @param $order_id 
		 * @return array|null          
		 */
		public function getMealsByOrderId($order_id)
		{
			$result = $this->connection->query("SELECT `meals`.`meal_title`, `meals`.`meal_price` ,`orders_meals`.`qunatity` FROM `orders` LEFT JOIN `orders_meals` ON `orders`.`order_id` = `orders_meals`.`order` LEFT JOIN `meals` ON `orders_meals`.`meal` = `meals`.`meal_id` WHERE `orders`.`order_id` = $order_id");

			if ($result->num_rows > 0)
			{
				$meals = array();
				while ($row = $result->fetch_assoc()) 
					$meals[] = $row;

				return $meals;
			}

			return null;
		}

		/**
		 * get meal by id function
		 * @param  $id
		 * @return array|null 
		 */
		public function getMealById($id)
		{
			// use getMeals function 
			$meals = $this->getMeals("WHERE `meal_id`= $id");
			// check if there is result returned 
			if ($meals && count($meals) > 0)
				return $meals[0];

			return null;
		}

		/**
		 * search meal function
		 * @param  $title
		 * @return array|null 
		 */
		public function searchMeal($title)
		{
			// use getMeals function 
			$meals = $this->getMeals("WHERE `meal_title` LIKE '%$title%'");
			// check if there is result returned 
			if ($meals && count($meals) > 0)
				return $meals;

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