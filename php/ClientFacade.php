<?php
require_once 'appUtil.php';
require_once 'Client.php';

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
        case 'addClient':
            Client::addClient($mData->data,$user);
            break;
        case 'getClient':
            Client::getClient();
            break;
        case 'modifyClient':

            break;
        default:
            # code...
            break;
    }

