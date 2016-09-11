<?php
require_once 'appUtil.php';
require_once 'Supplier.php';

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
        case 'addSupplier':
            Supplier::addSupplier($mData->data,$user);
            break;
        case 'getSupplier':
            Supplier::getSupplier();
            break;
        case 'modifySupplier':

            break;
        default:
            # code...
            break;
    }

