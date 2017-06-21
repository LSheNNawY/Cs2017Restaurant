<?php 
	require ('globals.php');

	// array of data sent with ajax response
	$dataArray = [];

	$meal_id = (isset($_GET['meal_id']))? (int)$_GET['meal_id'] : 0;

	if (isset($_SESSION['counter']) == false)
		$_SESSION['counter'] = 0;

	// check login
	if (checkLogin())
	{
		// add check var to dataArray
		$dataArray['check'] = 'logged';

		if ($meal_id > 0) 
		{
			// check if the meal id exists in session before
			if (in_array($meal_id, $_SESSION['meals']))
			{
				$dataArray['added'] = 'false';
				$dataArray['counter'] = $_SESSION['counter'];
			}
			else
			{
				$_SESSION['meals'][] = $meal_id;
				$_SESSION['counter'] += 1;
				$dataArray['added'] = 'true';
				$dataArray['counter'] = $_SESSION['counter'];
			}

		}

	}
	else
		$dataArray['check'] = 'not logged';


	echo json_encode($dataArray);
