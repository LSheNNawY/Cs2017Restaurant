<?php 
	require ('globals.php');

	// delete a meal of an order
	if (isset($_POST['meal_id']))
	{
		$meal_id = $_POST['meal_id'];
		$meal_key = array_search($meal_id, $_SESSION['meals']);

		$result = [];

		if (isset($meal_key)) 
		{
			unset($_SESSION['meals'][$meal_key]);
			$result['delete'] = 'deleted';
			$session_meals_counter = count($_SESSION['meals']);
			$_SESSION['counter'] = $session_meals_counter;
			$result['count'] = $session_meals_counter;
		}
		else{
			$result['delete'] = 'not deleted';
		}

		echo json_encode($result);
	}


	// confirming the order befor ordering
	if (isset($_POST['order_info']))
	{
		$order_info = $_POST['order_info'];

		if (count($order_info) == 3) {

			$meals_ids_arr = $order_info[0];
			$meals_quant_arr = $order_info[1];
			$order_totla_price = $order_info[2];

			$combined_arr = array_combine($meals_ids_arr, $meals_quant_arr);

			$final_product_arr = [];

			foreach ($combined_arr as $key => $value) 
			{
				$final_product_arr[] = [
					'meal_id' => $key,
					'quantity'=> $value
				];
			}

			$_SESSION['order'] = $final_product_arr;
			$_SESSION['total_price'] = $order_totla_price;

			$responseData['done'] = 'done';
			echo json_encode($responseData);
		} else {
			$responseData['done'] = 'error';
		}
		
	}