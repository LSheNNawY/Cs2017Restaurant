<?php 
	require ('../globals.php');
	require ('../includes/orders.class.php');

    // check login
    if (!checkLogin() && !checkAdminLogin())
        exit ('You are not logged in or not allowed to be here, to' . '<a href="login.php">Login</a>');

    if (count($_POST) > 0)
    {
        // order id comes with ajax
        $order_id = $_POST['order_id'];
        // success and failure varables
        $success = '';
        $error = '';
        // collect result variables in array
        $resultArr = array();
        // deleting order by id
        $orderObj = new Orders();
        // get order data to delete its image
        $orderData = $orderObj->getorderById($order_id);
        // delete order 
        $deleteOrder = $orderObj->deleteOrder($order_id);
        // check if the order updated successfully
        if($deleteOrder)            
            $success = 'Order deleted successfully';
        else
            $error = 'Error deleting order!';

        // adding success and error variables to result array
        $resultArr['success'] = $success;
        $resultArr['error'] = $error;
        // encoding result array as json to use with ajax
        echo json_encode($resultArr);
    } 
