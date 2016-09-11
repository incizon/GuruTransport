<?php
require_once 'appUtil.php';
require_once 'Driver.php';

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
        case 'addDriver':
            Driver::addDriver($mData->data,$user);
            break;
        case 'getDrivers':
            Driver::getDriver();
            break;
        case 'modifyDriver':

            break;
        default:
            # code...
            break;
    }

