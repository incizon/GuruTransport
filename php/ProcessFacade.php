<?php
require_once 'appUtil.php';
require_once 'Workorder.php';

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
        case 'addWorkorder':
            Workorder::addWorkorder($mData->data,$user);
            break;
        case 'getWorkorders':
            Workorder::getWorkorder("","");
            break;
        case 'getClientWiseWorkorders':
            Workorder::getClientWiesWorkorder("clientid",$mData->clientid);
            break;
        case 'createBill':
            Workorder::createBill($mData,$mData->billWorkorders,$mData->billData,$user);
            break;
        case 'getClientWiseWorkordersForInvoice':
            Workorder::getClientWiesWorkorder("invoice",$mData->clientid);
            break;
        case 'getBills':
            Workorder::getBills("all",$mData->clientid);
            break;
        case 'getBillbyId':
            Workorder::getBillById($mData->billid);
            break;
        case 'addClientPayment':
            Workorder::addClientPayment($mData->data,$user);
            break;
        case 'getSupplierWiseWorkorders':
            Workorder::getSupplierWiesWorkorder("all",$mData->supplierid);
            break;
        case 'getSupplierWiseWorkordersFORInvoice':
            Workorder::getSupplierWiesWorkorder("invoice",$mData->supplierid);
            break;
        case 'createSupplierBill':
            Workorder::createSupplierBill($mData,$mData->billWorkorders,$mData->billData,$user);
            break;
        case 'getSupplierBills':
            Workorder::getSupplierBills("all",$mData->supplierid);
            break;
        case 'getBillbySupplierBillId':
            Workorder::getBillBySupplierId($mData->billid);
            break;
        case 'addSupplierPayment':
            Workorder::addSupplierPayment($mData->data,$user);
            break;
        case 'getClientInvoices':
            Workorder::getClientInvoices("all",$mData->clientid);
            break;
        case 'getSupplierInvoices':
            Workorder::getSupplierInvoices("all",$mData->supplierid);
            break;
        default:
            # code...
            break;
    }

