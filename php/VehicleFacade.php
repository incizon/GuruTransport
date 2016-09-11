<?php
require_once 'appUtil.php';
require_once 'Vehicle.php';

/**
 * Created by IntelliJ IDEA.
 * User: Ajit
 * Date: 2016-08-28
 * Time: 12:26 PM
 */
//echo AppUtil::getReturnStatus("success","added succeefully");
    $mData = json_decode($_GET["data"]);
    $user="user";
    switch ($mData->opertaion) {
        case 'addVehicle':
            Vehicle::addVehicle($mData->vehiclename,$mData->vehiclenmber,$user);
            break;
        case 'getVehicle':
            Vehicle::getVehicles();
            break;
        case 'modifyVehicle':

            break;
        default:
            # code...
            break;
    }

