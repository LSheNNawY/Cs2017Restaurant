<?php
	require ('globals.php');
	require ('includes/meals.class.php');
	require ('includes/orders_meals.class.php');

	$active = 'order';

	// order meals ids stored in session
	$sessionMeals = (isset($_SESSION['meals']))? $_SESSION['meals'] : [];
	// meals class object
	$mealsObject = new Meals();
	// array to store meals info
	$mealsInfo = [];

	// foreach on meals ids stored in session 
	foreach ($sessionMeals as $meal_id) {
		// get meal by id and assign it to $meal variable
		$meal = $mealsObject->getMealById($meal_id);
		// if result returned push it to $mealsInfo array
		if ($meal && count($meal) > 0)
			$mealsInfo[] = $meal;
	}


	include ('templates/front/header.html');
	include ('templates/front/order.html');
	include ('templates/front/footer.html');