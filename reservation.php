<?php
    require ('globals.php');
    require ('includes/tables.class.php');
    require ('includes/users_tables.class.php');

    $active = 'reservation';
    $success = '';
    $error   = '';
    $resObject  = new UsersTables();
    //********************** start show tables *****************//
    if(isset($_POST['search']))
    {
         $d = isset($_POST['date'])? $_POST['date'] : '';
         $_SESSION['date'] = $d;
     
        $reservations = $resObject->getAllReservations();
        $tablesObject = new Tables();
        // store unAvailabletables
        $unavilTables = [];
        if (count($reservations) > 0) {
            foreach ($reservations as $reservation)
            {

                if ($d == $reservation['table_reservation_time_start'])
                    $unavilTables[] = $reservation['table'];
            }

            
        }
        // Available Tables 
        $avaiTables = $tablesObject->getTablesByAvailDate($unavilTables); 
    }
           
    //********************** End show tables *****************//

    //*************** Start  Reservation *************//
    
    elseif (isset($_SESSION['date']) && count($_POST)>0) 
    {
        // user id
        $user = $_SESSION['user']['user_id'];
        $id = $_POST['tableId'];
        
        // Reservations test
        $allReservations = $resObject->getReservationsByTableId($id);

        if(count($allReservations) > 0)
        {
            foreach ($allReservations as $reserv)
            {
                $timeStart = $reserv['table_reservation_time_start'];

                //check reservations if user click reload
                if (isset($timeStart) && ($_SESSION['date'] == $timeStart))
                {
                    $error = '<strong>Sorry :</strong> this table Is already booked please, select another table or change the date !';
                }
                elseif($resObject->userReservation($user,$id,$_SESSION['date']))
                {
                    $success = 'Reservation done';
                    break;
                }
                else
                    $error = '<strong>Error : </strong>Sorry, You have booked this table before !';
            }
        }
        else
        {
            $resObject->userReservation($user,$id,$_SESSION['date']);
            $success = 'Reservation done';
        }


    }

        
    //*************** End  Reservation *************//

    include ('templates/front/header.html');
    include ('templates/front/reservation.html');
    include ('templates/front/footer.html');
