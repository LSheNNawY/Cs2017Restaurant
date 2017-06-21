<?php 
	require ('globals.php');
	require ('includes/orders.class.php');
	require ('includes/orders_meals.class.php');

	if (isset($_POST['checkout']))
	{
		$order_id = createUniqueRandomID();

		$order_arr = (isset($_SESSION['order']))? $_SESSION['order'] : [];

		$orders_meals_obj = new Orders_meals();
		$orders_obj = new Orders();

		// check if order have meals or not
		if (count($order_arr) > 0) {
			// add order to orders database table
			if ($orders_obj->addOrder($order_id, $_SESSION['user']['user_id'], $_SESSION['total_price'])){
				$responseData['done'] = 'done';
				// add order to database order_tables['bridge table']
				if ($orders_meals_obj->addOrderMeals($order_id, $order_arr))
				{
					unset($_SESSION['order']);
					unset($_SESSION['meals']);
					unset($_SESSION['total_price']);

					$_SESSION['counter'] = 0;

					$responseData['counter'] = $_SESSION['counter'];
					$responseData['order_meals'] = 'done';
				}
				else
					$responseData['order_meals'] = 'error';
			}
			else
				$responseData['done'] = 'error';
		} 
		else 
			$responseData['done'] = 'order must contain one or more item';


		echo json_encode($responseData);
	}


	


	



