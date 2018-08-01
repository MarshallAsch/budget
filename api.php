<?php

include "database.php";


	//if they are making a authorized post request
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //do the correct action baised on the AJAX request
        switch($_POST["action"])
        {
            case "insert":
                echo json_encode(insertTransaction($_POST["date"], $_POST["amount"], $_POST["tag"], $_POST["description"]));
                break;
            case "edit":
                echo json_encode(editTransaction($_POST["id"], $_POST["date"], $_POST["amount"], $_POST["tag"], $_POST["description"]));
                break;
            case "getMonth":
                echo json_encode(getTotalsForMonth($_POST["year"], $_POST["month"]));
                break;
            default:
                $arr = array('status' => 400, 'type' => "unknown", 'errorCode' =>"invalid request");
                //return the responce
                echo json_encode($arr);
        }

        return;
    }
    else{
    	$arr = array('status' => 400, 'type' => "unknown", 'errorCode' =>"invalid request");
        //return the responce
        echo json_encode($arr);
        return;
    }






