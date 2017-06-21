<?php
	require ('../globals.php');
	require ('../includes/tables.class.php');

	// check login
	if (!checkLogin() && !checkAdminLogin())
		exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

	if (count($_POST) > 0)
	{
		$table_id = $_POST['table_id'];
		// success and failure varables
        $success = '';
        $error = '';
        // collect result variables in array
        $resultArr = array();
        // deleting table by id
		$tableObject = new Tables();
		$table = $tableObject->deleteTable($table_id);
		// check if table deleted 
		if ($table)
		    $success = 'Table deleted successfully';
		else
		    $error = 'Error deleting table';

		// adding success and error variables to result array
        $resultArr['success'] = $success;
        $resultArr['error'] = $error;
        // encoding result array as json to use with ajax
        echo json_encode($resultArr);
	}