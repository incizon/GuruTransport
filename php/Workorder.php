<?php
require_once 'Database.php';
require_once 'appUtil.php';

/**
 * Created by IntelliJ IDEA.
 * User: LENOVO
 * Date: 2016-08-28
 * Time: 1:02 PM
 */
class Workorder
{

    public static function addWorkorder($data, $userId)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $masterid = "";
        try {
            $stmt = $conn->prepare("INSERT INTO `process_master`(`clientid`, `supplierid`, `vehicleid`, `driverid`, `materialtype`,`date`, `createdby`, `creationdate`, `lastmodificationdate`, `lastmodifiedby`)
                                  VALUES (:clientid,:supplierid,:vehicleid,:driverid,:materialtype,:date1,:creadtedby,now(),now(),:lastmodifyby)");
            $stmt->bindParam(':clientid', $data->clientName, PDO::PARAM_STR, 10);
            $stmt->bindParam(':supplierid', $data->supplierName, PDO::PARAM_STR, 10);
            $stmt->bindParam(':vehicleid', $data->vehicleName, PDO::PARAM_STR, 10);
            $stmt->bindParam(':driverid', $data->driverName, PDO::PARAM_STR, 10);
            $stmt->bindParam(':materialtype', $data->materialtype, PDO::PARAM_STR, 10);
            $stmt->bindParam(':date1', $data->purchaseDate, PDO::PARAM_STR, 10);
            $stmt->bindParam(':creadtedby', $userId, PDO::PARAM_STR, 10);
            $stmt->bindParam(':lastmodifyby', $userId, PDO::PARAM_STR, 10);
            if ($stmt->execute()) {
                $masterid = $conn->lastInsertId();
                $stmt1 = $conn->prepare("INSERT INTO `process_supplier`(`processmasterid`, `purchasechallan`, `purchaserate`, `purchaseqty`, `purchaseamount`, `supervisor`, `purchasedate`)
                                  VALUES (:processmasterid,:purchasechallan,:purchaserate,:purchaseqty,:purchaseamount,:supervisor,:purchasedate)");
                $stmt1->bindParam(':processmasterid', $masterid, PDO::PARAM_STR, 10);
                $stmt1->bindParam(':purchasechallan', $data->supplierChallan, PDO::PARAM_STR, 10);
                $stmt1->bindParam(':purchaserate', $data->purchaseRate, PDO::PARAM_STR, 10);
                $stmt1->bindParam(':purchaseqty', $data->purchaseQuantity, PDO::PARAM_STR, 10);
                $stmt1->bindParam(':purchaseamount', $data->purchaseAmount, PDO::PARAM_STR, 10);
                $stmt1->bindParam(':supervisor', $data->supervisor, PDO::PARAM_STR, 10);
                $stmt1->bindParam(':purchasedate', $data->purchaseDate, PDO::PARAM_STR, 10);
                if ($stmt1->execute()) {
                    $stmt2 = $conn->prepare("INSERT INTO `process_client`(`processmasterid`, `sellingchallan`, `sellingrate`, `sellingqty`, `sellingamount`, `sellingdate`, `supervisor`)
                                  VALUES (:processmasterid,:sellingchallan,:sellingrate,:sellingqty,:sellingamount,:sellingdate,:supervisor)");
                    $stmt2->bindParam(':processmasterid', $masterid, PDO::PARAM_STR, 10);
                    $stmt2->bindParam(':sellingchallan', $data->clientChallan, PDO::PARAM_STR, 10);
                    $stmt2->bindParam(':sellingrate', $data->sellingRate, PDO::PARAM_STR, 10);
                    $stmt2->bindParam(':sellingqty', $data->sellingQuantity, PDO::PARAM_STR, 10);
                    $stmt2->bindParam(':sellingamount', $data->sellingAmount, PDO::PARAM_STR, 10);
                    $stmt2->bindParam(':sellingdate', $data->sellingDate, PDO::PARAM_STR, 10);
                    $stmt2->bindParam(':supervisor', $data->supervisorClient, PDO::PARAM_STR, 10);
                    if ($stmt2->execute()) {
                        if ($data->isMaintenance) {
                            $stmt3 = $conn->prepare("INSERT INTO `maintenance`(`processmasterid`,`type`, `amount`, `recieptnumber`)
                                  VALUES (:processmasterid,:type1,:amount,:recieptnumber)");
                            $stmt3->bindParam(':processmasterid', $masterid, PDO::PARAM_STR, 10);
                            $stmt3->bindParam(':type1', $data->maintenanceType, PDO::PARAM_STR, 10);
                            $stmt3->bindParam(':amount', $data->maintenanceAmount, PDO::PARAM_STR, 10);
                            $stmt3->bindParam(':recieptnumber', $data->receiptNumber, PDO::PARAM_STR, 10);
                            if ($stmt3->execute()) {
                                echo AppUtil::getReturnStatus("success", "Workorder added Successfully");
                            } else {
                                echo AppUtil::getReturnStatus("Fail", "Please try again");
                            }
                        } else {
                            echo AppUtil::getReturnStatus("success", "Workorder added Successfully");
                        }

                    }

                } else {
                    echo AppUtil::getReturnStatus("Fail", "Please try again");
                }

            } else {
                echo AppUtil::getReturnStatus("Fail", "Please try again");
            }
        } catch (Exception $e) {
            echo AppUtil::getReturnStatus("Fail", "Something went wrong. please try again");
        }
    }

    public static function createBill($data, $BillWorkorders, $billData, $userId)
    {

        $db = Database::getInstance();
        $conn = $db->getConnection();
        $success = false;
        $totalCount = count($BillWorkorders);

        try {
            $stmt = $conn->prepare("INSERT INTO `invoice_master`( `invoicenumber`, `clientid`, `invoicedate`, `totalamount`, `createdby`, `creationdate`, `lastmodificationdate`, `lastmodifiedby`)
                                  VALUES (:invoicenumber,:clientid,:invoicedate,:totalamount,:creadtedby,now(),now(),:lastmodifyby)");
            $stmt->bindParam(':invoicenumber', $billData->billNumber, PDO::PARAM_STR, 10);
            $stmt->bindParam(':clientid', $data->clientid, PDO::PARAM_STR, 10);
            $stmt->bindParam(':invoicedate', $billData->billDate, PDO::PARAM_STR, 10);
            $stmt->bindParam(':totalamount', $billData->totalBillAmount, PDO::PARAM_STR, 10);
            $stmt->bindParam(':creadtedby', $userId, PDO::PARAM_STR, 10);
            $stmt->bindParam(':lastmodifyby', $userId, PDO::PARAM_STR, 10);
            if ($stmt->execute()) {

                $masterid = $conn->lastInsertId();
                for ($x = 0; $x < $totalCount; $x++) {
                    $stmt1 = $conn->prepare("INSERT INTO `invoice_details` (`invoiceid`, `processmasterid`)
                                  VALUES (:invoiceid,:processmasterid)");
                    $stmt1->bindParam(':invoiceid',$masterid , PDO::PARAM_STR, 10);
                    $stmt1->bindParam(':processmasterid',$BillWorkorders[$x] , PDO::PARAM_STR, 10);

                    if ($stmt1->execute()) {
                        $success = true;
                    } else {
                        $success = false;
                    }

                }
                if ($success) {
                    echo AppUtil::getReturnStatus("success", "Bill added successfully");
                } else {
                    echo AppUtil::getReturnStatus("Fail", "Please try again");
                }

            } else {
                echo AppUtil::getReturnStatus("Fail", "Please try again");
            }
        } catch (Exception $e) {
            echo AppUtil::getReturnStatus("Fail", "Something went wrong. please try again");
        }
    }

    public static function getWorkorder($searchBy, $keyword)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $stmt = "SELECT * FROM process_master
              JOIN process_supplier ON process_master.processmasterid=process_supplier.processmasterid
              JOIN process_client ON process_master.processmasterid=process_client.	processmasterid";
//              JOIN maintenance ON process_master.processmasterid=maintenance.processmasterid";

//        switch ($searchBy) {
//            case'ClientName':
//                $stmt = $stmt . " WHERE product_master.productname LIKE :keyword ";
//                break;
//            case'DriverName':
//                $stmt = $stmt . " WHERE companymaster.companyName like :keyword";
//                break;
//            case'Vehicle':
//                $stmt = $stmt . " WHERE warehousemaster.wareHouseName like :keyword";
//                break;
//        }
        $stmt = $conn->prepare($stmt);
//        $stmt->bindParam(':keyword', $keyword);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $json_array = array();
                while ($result2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result = array();
                    $result['clientid'] = $result2['clientid'];
                    $result['createdby'] = $result2['createdby'];
                    $result['insertdate'] = $result2['date'];
                    $result['driverid'] = $result2['driverid'];
                    $result['materialtype'] = $result2['materialtype'];
//
                    $result['processclientid'] = $result2['processclientid'];
                    $result['processmasterid'] = $result2['processmasterid'];
                    $result['processsupplierid'] = $result2['processsupplierid'];
                    $result['purchaseamount'] = $result2['purchaseamount'];
                    $result['purchasechallan'] = $result2['purchasechallan'];

                    $result['purchasedate'] = $result2['purchasedate'];
                    $result['purchaseqty'] = $result2['purchaseqty'];
                    $result['purchaserate'] = $result2['purchaserate'];
//
                    $result['sellingamount'] = $result2['sellingamount'];

                    $result['sellingchallan'] = $result2['sellingchallan'];
                    $result['sellingdate'] = $result2['sellingdate'];
                    $result['sellingqty'] = $result2['sellingqty'];
                    $result['sellingrate'] = $result2['sellingrate'];
                    $result['supervisor'] = $result2['supervisor'];

                    $result['supplierid'] = $result2['supplierid'];

                    $result['vehicleid'] = $result2['vehicleid'];

                    $result['clientname'] = AppUtil::getNameFromId($db, $conn, "clientname", "client", "clientid", $result2['clientid']);
                    $result['drivername'] = AppUtil::getDriverName($conn, $result2['driverid']);
                    $result['suppliername'] = AppUtil::getSupplierName($conn, $result2['supplierid']);
                    $result['vehiclenumber'] = AppUtil::getVehicleName($conn, $result2['vehicleid']);

                    //    self::checkMaintenance($result,$conn);
                    $stmt1 = $conn->prepare("SELECT * FROM maintenance WHERE processmasterid=" . $result["processmasterid"]);

                    if ($stmt1->execute()) {
                        if ($stmt1->rowCount() > 0) {

                            $resultMaintenance = $stmt1->fetch(PDO::FETCH_ASSOC);

                            $result["maintenanceamount"] = $resultMaintenance["amount"];
                            $result['maintenancetype'] = $resultMaintenance['type'];
                            $result['recieptnumber'] = $resultMaintenance['recieptnumber'];
                            $result['maintenanceid'] = $resultMaintenance['maintenanceid'];

                        }
                    }

                    array_push($json_array, $result);
                }
                $json = json_encode($json_array);
                echo $json;
//                echo AppUtil::getReturnStatus("success",$json);
            }

        } else {
            $returnVal = array('status' => "Fail", 'message' => "Vehicles not found");
            echo json_encode($returnVal);
        }
    }

    public static function checkMaintenance($result, $conn)
    {

        $stmt = $conn->prepare("SELECT * FROM maintenance WHERE processmasterid=" . $result["processmasterid"]);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {

                $resultMaintenance = $stmt->fetch(PDO::FETCH_ASSOC);

                $result["maintenanceamount"] = $resultMaintenance["amount"];
                $result['maintenancetype'] = $resultMaintenance['type'];
                $result['recieptnumber'] = $resultMaintenance['recieptnumber'];
                $result['maintenanceid'] = $resultMaintenance['maintenanceid'];

            }

        }
    }

    public static function getClientWiesWorkorder($searchBy, $keyword)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        if(!strcmp("invoice",$searchBy)){
            $stmt = "SELECT * FROM process_master
              JOIN process_supplier ON process_master.processmasterid=process_supplier.processmasterid
              JOIN process_client ON process_master.processmasterid=process_client.	processmasterid WHERE process_master.clientid=:keyword AND process_master.processmasterid NOT IN (SELECT processmasterid FROM invoice_details)";

        }else{
            $stmt = "SELECT * FROM process_master
              JOIN process_supplier ON process_master.processmasterid=process_supplier.processmasterid
              JOIN process_client ON process_master.processmasterid=process_client.	processmasterid WHERE process_master.clientid=:keyword";

        }

        $stmt = $conn->prepare($stmt);
        $stmt->bindParam(':keyword', $keyword);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $json_array = array();
                while ($result2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result = array();
                    $result['clientid'] = $result2['clientid'];
                    $result['createdby'] = $result2['createdby'];
                    $result['insertdate'] = $result2['date'];
                    $result['driverid'] = $result2['driverid'];
                    $result['materialtype'] = $result2['materialtype'];
                    $result['processclientid'] = $result2['processclientid'];
                    $result['processmasterid'] = $result2['processmasterid'];
                    $result['processsupplierid'] = $result2['processsupplierid'];
                    $result['purchaseamount'] = $result2['purchaseamount'];
                    $result['purchasechallan'] = $result2['purchasechallan'];

                    $result['purchasedate'] = $result2['purchasedate'];
                    $result['purchaseqty'] = $result2['purchaseqty'];
                    $result['purchaserate'] = $result2['purchaserate'];
                    $result['sellingamount'] = $result2['sellingamount'];

                    $result['sellingchallan'] = $result2['sellingchallan'];
                    $result['sellingdate'] = $result2['sellingdate'];
                    $result['sellingqty'] = $result2['sellingqty'];
                    $result['sellingrate'] = $result2['sellingrate'];
                    $result['supervisor'] = $result2['supervisor'];

                    $result['supplierid'] = $result2['supplierid'];

                    $result['vehicleid'] = $result2['vehicleid'];

                    $result['clientname'] = AppUtil::getNameFromId($db, $conn, "clientname", "client", "clientid", $result2['clientid']);
                    $result['drivername'] = AppUtil::getDriverName($conn, $result2['driverid']);
                    $result['suppliername'] = AppUtil::getSupplierName($conn, $result2['supplierid']);
                    $result['vehiclenumber'] = AppUtil::getVehicleName($conn, $result2['vehicleid']);

                    $stmt1 = $conn->prepare("SELECT * FROM maintenance WHERE processmasterid=" . $result["processmasterid"]);

                    if ($stmt1->execute()) {
                        if ($stmt1->rowCount() > 0) {

                            $resultMaintenance = $stmt1->fetch(PDO::FETCH_ASSOC);

                            $result["maintenanceamount"] = $resultMaintenance["amount"];
                            $result['maintenancetype'] = $resultMaintenance['type'];
                            $result['recieptnumber'] = $resultMaintenance['recieptnumber'];
                            $result['maintenanceid'] = $resultMaintenance['maintenanceid'];

                        }
                    }

                    array_push($json_array, $result);
                }
                $json = json_encode($json_array);
                echo $json;
//                echo AppUtil::getReturnStatus("success",$json);
            }

        } else {
            $returnVal = array('status' => "Fail", 'message' => "Workorders not found");
            echo json_encode($returnVal);
        }
    }
    public static function getBillById($billID){
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = "SELECT * FROM invoice_master WHERE invoice_master.invoiceid=:keyword";
        $stmt = $conn->prepare($stmt);
        $stmt->bindParam(':keyword', $billID);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $json_array = array();
                while ($result2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result = array();
                    $stmt12 = "SELECT SUM(amountpaid) AS totalpaidamount FROM client_payment WHERE client_payment.invoiceid=:keyword";
                    $stmt12 = $conn->prepare($stmt12);
                    $stmt12->bindParam(':keyword',$result2['invoiceid'] );
                    if($stmt12->execute()){
                        $res=$stmt12->fetch(PDO::FETCH_ASSOC);
                        $result['totalpaidamount'] = $res['totalpaidamount'];
                    }
                    $result['invoiceid'] = $result2['invoiceid'];
                    $result['clientid'] = $result2['clientid'];
                    $result['createdby'] = $result2['createdby'];
                    $result['invoicenumber'] = $result2['invoicenumber'];
                    $result['totalamounttoBePaid'] = $result2['totalamount'];
                    $result['clientname'] = AppUtil::getNameFromId($db, $conn, "clientname", "client", "clientid", $result2['clientid']);

                    array_push($json_array, $result);
                }
                $json = json_encode($json_array);
                echo $json;
//                echo AppUtil::getReturnStatus("success",$json);
            }

        } else {
            $returnVal = array('status' => "Fail", 'message' => "Bills not found");
            echo json_encode($returnVal);
        }
    }
    public static function getBills($searchBy, $keyword)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $isPaid=false;
        if(!strcmp("all",$searchBy)){
            $stmt = "SELECT * FROM invoice_master WHERE invoice_master.clientid=:keyword AND isPaid=:isPaid";

        }else{
            $stmt = "SELECT * FROM process_master
              JOIN process_supplier ON process_master.processmasterid=process_supplier.processmasterid
              JOIN process_client ON process_master.processmasterid=process_client.	processmasterid WHERE process_master.clientid=:keyword";

        }
        $stmt = $conn->prepare($stmt);
        $stmt->bindParam(':keyword', $keyword);
        $stmt->bindParam(':isPaid', $isPaid);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $json_array = array();

                while ($result2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result = array();

                    $result['invoiceid'] = $result2['invoiceid'];
                    $result['clientid'] = $result2['clientid'];
                    $result['createdby'] = $result2['createdby'];
                    $result['invoicenumber'] = $result2['invoicenumber'];
                    $result['totalamounttoBePaid'] = $result2['totalamount'];
                    $result['clientname'] = AppUtil::getNameFromId($db, $conn, "clientname", "client", "clientid", $result2['clientid']);

                    array_push($json_array, $result);
                }
                $json = json_encode($json_array);
                echo $json;
//                echo AppUtil::getReturnStatus("success",$json);
            }

        } else {
            $returnVal = array('status' => "Fail", 'message' => "Bills not found");
            echo json_encode($returnVal);
        }
    }

    public static function addClientPayment($data,$userId){
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $masterid = "";
        $isCashPayment=false;
        $chequeNumber=" ";
        try {
            $stmt = $conn->prepare("INSERT INTO `client_payment`(`invoiceid`, `amountpaid`, `paymentdate`, `recievedBy`, `isCashPayment`, `createdby`, `creationdate`, `lastmodificationdate`, `lastmodifiedby`)
                                  VALUES (:invoiceid,:amountpaid,:paymentdate,:recievedBy,:isCashPayment,:creadtedby,now(),now(),:lastmodifyby)");
            $stmt->bindParam(':invoiceid', $data->invoiceid, PDO::PARAM_STR, 10);
            $stmt->bindParam(':amountpaid', $data->amountPaid, PDO::PARAM_STR, 10);
            $stmt->bindParam(':paymentdate', $data->paymentDate, PDO::PARAM_STR, 10);
            $stmt->bindParam(':recievedBy', $data->paymentReceiver, PDO::PARAM_STR, 10);
            if($data->paymentMode=="Cheque"){
                $isCashPayment=false;
            }else{
                $isCashPayment=true;
            }
            $stmt->bindParam(':isCashPayment',$isCashPayment, PDO::PARAM_STR, 10);
            $stmt->bindParam(':creadtedby', $userId, PDO::PARAM_STR, 10);
            $stmt->bindParam(':lastmodifyby', $userId, PDO::PARAM_STR, 10);
            if ($stmt->execute()) {

                $masterid = $conn->lastInsertId();
                $stmt1 = $conn->prepare("INSERT INTO `client_payment_mode`(`clientpaymentid`, `paymenttype`, `chequenumber`, `bankname`)
                                  VALUES (:clientpaymentid,:paymenttype,:chequenumber,:bankname)");
                $stmt1->bindParam(':clientpaymentid', $masterid, PDO::PARAM_STR, 10);
                $stmt1->bindParam(':paymenttype', $data->paymentMode, PDO::PARAM_STR, 10);
                if($data->paymentMode=="Cheque"){
                    $stmt1->bindParam(':chequenumber', $data->chequeNumber, PDO::PARAM_STR, 10);
                    $stmt1->bindParam(':bankname', $data->bankName, PDO::PARAM_STR, 10);
                }else{
                    $stmt1->bindParam(':chequenumber', $chequeNumber, PDO::PARAM_STR, 10);
                    $stmt1->bindParam(':bankname', $chequeNumber, PDO::PARAM_STR, 10);
                }

                if ($stmt1->execute()) {

                    $isPaid=true;

                    if($data->remainingAmount<=0){
                        $stmtUpdateInvoice=$conn->prepare("UPDATE invoice_master SET isPaid =:isPaid,lastmodificationdate=now(),lastmodifiedby=:lastmodifiedby
                                     WHERE invoiceid = :invoiceid");
                        $stmtUpdateInvoice->bindParam(':isPaid', $isPaid, PDO::PARAM_STR, 10);
                        $stmtUpdateInvoice->bindParam(':lastmodifiedby', $userId, PDO::PARAM_STR, 10);
                        $stmtUpdateInvoice->bindParam(':invoiceid', $data->invoiceid, PDO::PARAM_STR, 10);
                        if($stmtUpdateInvoice->execute()){

                        }

                    }
                    echo AppUtil::getReturnStatus("success", "Payment added Successfully");
                } else {
                    echo AppUtil::getReturnStatus("Fail", $stmt1->errorInfo());
                }

            } else {

                echo AppUtil::getReturnStatus("Fail",  $stmt->errorInfo());
            }
        } catch (Exception $e) {
            echo AppUtil::getReturnStatus("Fail", "Something went wrong. please try again");
        }
    }
    public static function getClientInvoices($searchBy, $keyword){
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $stmt = "SELECT * FROM invoice_master WHERE invoice_master.clientid=:keyword";
        $stmt = $conn->prepare($stmt);
        $stmt->bindParam(':keyword', $keyword);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $json_array = array();

                while ($result2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result = array();

                    $result['invoiceid'] = $result2['invoiceid'];
                    $result['clientid'] = $result2['clientid'];
                    $result['createdby'] = $result2['createdby'];
                    $result['invoicedate'] = $result2['invoicedate'];
                    $result['invoicenumber'] = $result2['invoicenumber'];
                    $result['totalamounttoBePaid'] = $result2['totalamount'];
                    $result['clientname'] = AppUtil::getNameFromId(null,$conn,null,null,null,$result2['clientid']);
                    array_push($json_array, $result);

                }
                $json = json_encode($json_array);
                echo $json;
            }

        } else {
            $returnVal = array('status' => "Fail", 'message' => "Bills not found");
            echo json_encode($returnVal);
        }
    }
/******************************************************************************************************************************/
    /**
     * @param $searchBy
     * @param $keyword
     */
    //SUPPLIER FUNCTIONS
    public static function getSupplierWiesWorkorder($searchBy, $keyword){
        $db = Database::getInstance();
        $conn = $db->getConnection();
        if(!strcmp("invoice",$searchBy)){
            $stmt = "SELECT * FROM process_master
              JOIN process_supplier ON process_master.processmasterid=process_supplier.processmasterid
              JOIN process_client ON process_master.processmasterid=process_client.	processmasterid WHERE process_master.supplierid=:keyword AND process_master.processmasterid NOT IN (SELECT 	processmasterid FROM supplier_invoice_details)";

        }else{
            $stmt = "SELECT * FROM process_master
              JOIN process_supplier ON process_master.processmasterid=process_supplier.processmasterid
              JOIN process_client ON process_master.processmasterid=process_client.	processmasterid WHERE process_master.supplierid=:keyword";

        }

        $stmt = $conn->prepare($stmt);
        $stmt->bindParam(':keyword', $keyword);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $json_array = array();
                while ($result2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result = array();
                    $result['clientid'] = $result2['clientid'];
                    $result['createdby'] = $result2['createdby'];
                    $result['insertdate'] = $result2['date'];
                    $result['driverid'] = $result2['driverid'];
                    $result['materialtype'] = $result2['materialtype'];
                    $result['processclientid'] = $result2['processclientid'];
                    $result['processmasterid'] = $result2['processmasterid'];
                    $result['processsupplierid'] = $result2['processsupplierid'];
//                    $result['purchaseamount'] = $result2['purchaseamount'];
//                    $result['purchasechallan'] = $result2['purchasechallan'];
//
//                    $result['purchasedate'] = $result2['purchasedate'];
//                    $result['purchaseqty'] = $result2['purchaseqty'];
//                    $result['purchaserate'] = $result2['purchaserate'];
//
                    $result['sellingamount'] = $result2['purchaseamount'];

                    $result['sellingchallan'] = $result2['purchasechallan'];
                    $result['sellingdate'] = $result2['sellingdate'];
                    $result['sellingqty'] = $result2['purchaseqty'];
                    $result['sellingrate'] = $result2['purchaserate'];
                    $result['supervisor'] = $result2['supervisor'];

                    $result['supplierid'] = $result2['supplierid'];

                    $result['vehicleid'] = $result2['vehicleid'];

                    $result['clientname'] = AppUtil::getNameFromId($db, $conn, "clientname", "client", "clientid", $result2['clientid']);
                    $result['drivername'] = AppUtil::getDriverName($conn, $result2['driverid']);
                    $result['suppliername'] = AppUtil::getSupplierName($conn, $result2['supplierid']);
                    $result['vehiclenumber'] = AppUtil::getVehicleName($conn, $result2['vehicleid']);

                    //    self::checkMaintenance($result,$conn);
                    $stmt1 = $conn->prepare("SELECT * FROM maintenance WHERE processmasterid=" . $result["processmasterid"]);

                    if ($stmt1->execute()) {
                        if ($stmt1->rowCount() > 0) {

                            $resultMaintenance = $stmt1->fetch(PDO::FETCH_ASSOC);

                            $result["maintenanceamount"] = $resultMaintenance["amount"];
                            $result['maintenancetype'] = $resultMaintenance['type'];
                            $result['recieptnumber'] = $resultMaintenance['recieptnumber'];
                            $result['maintenanceid'] = $resultMaintenance['maintenanceid'];

                        }
                    }

                    array_push($json_array, $result);
                }
                $json = json_encode($json_array);
                echo $json;
            }

        } else {
            $returnVal = array('status' => "Fail", 'message' => "Workorders not found");
            echo json_encode($returnVal);
        }
    }

    public static function createSupplierBill($data, $BillWorkorders, $billData, $userId)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $success = false;
        $totalCount = count($BillWorkorders);

        try {
            $stmt = $conn->prepare("INSERT INTO `supplier_invoice_master`(`supplierinvoicenumber`, `supplierid`, `supplierinvoicedate`, `totalamount`, `createdby`, `creationdate`, `lastmodificationdate`, `lastmodifiedby`)
                                  VALUES (:invoicenumber,:supplierid,:invoicedate,:totalamount,:creadtedby,now(),now(),:lastmodifyby)");
            $stmt->bindParam(':invoicenumber', $billData->billNumber, PDO::PARAM_STR, 10);
            $stmt->bindParam(':supplierid', $data->supplierid, PDO::PARAM_STR, 10);
            $stmt->bindParam(':invoicedate', $billData->billDate, PDO::PARAM_STR, 10);
            $stmt->bindParam(':totalamount', $billData->totalBillAmount, PDO::PARAM_STR, 10);
            $stmt->bindParam(':creadtedby', $userId, PDO::PARAM_STR, 10);
            $stmt->bindParam(':lastmodifyby', $userId, PDO::PARAM_STR, 10);
            if ($stmt->execute()) {

                $masterid = $conn->lastInsertId();
                for ($x = 0; $x < $totalCount; $x++) {
                    $stmt1 = $conn->prepare("INSERT INTO `supplier_invoice_details`( `supplierinvoiceid`, `processmasterid`)
                                  VALUES (:invoiceid,:processmasterid)");
                    $stmt1->bindParam(':invoiceid', $masterid, PDO::PARAM_STR, 10);
                    $stmt1->bindParam(':processmasterid',$BillWorkorders[$x] , PDO::PARAM_STR, 10);

                    if ($stmt1->execute()) {
                        $success = true;
                    } else {
                        $success = false;
                    }
                }
                if ($success) {
                    echo AppUtil::getReturnStatus("success", "Bill added successfully");
                } else {
                    echo AppUtil::getReturnStatus("Fail", "Please try again");
                }

            } else {
                echo AppUtil::getReturnStatus("Fail", $stmt->errorInfo());
            }
        } catch (Exception $e) {
            echo AppUtil::getReturnStatus("Fail", "Something went wrong. please try again");
        }
    }

    public static function getSupplierBills($searchBy, $keyword){
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $isPaid=false;
        if(!strcmp("all",$searchBy)){
            $stmt = "SELECT * FROM supplier_invoice_master WHERE supplier_invoice_master.supplierid=:keyword AND isPaid=:isPaid";

        }else{
            $stmt = "SELECT * FROM process_master
              JOIN process_supplier ON process_master.processmasterid=process_supplier.processmasterid
              JOIN process_client ON process_master.processmasterid=process_client.	processmasterid WHERE process_master.supplierid=:keyword";

        }
        $stmt = $conn->prepare($stmt);
        $stmt->bindParam(':keyword', $keyword);
        $stmt->bindParam(':isPaid', $isPaid);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $json_array = array();

                while ($result2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result = array();

                    $result['invoiceid'] = $result2['supplierinvoiceid'];
                    $result['clientid'] = $result2['supplierid'];
                    $result['createdby'] = $result2['createdby'];
                    $result['invoicenumber'] = $result2['supplierinvoicenumber'];
                    $result['totalamounttoBePaid'] = $result2['totalamount'];
                    $result['clientname'] = AppUtil::getSupplierName($conn,$result2['supplierid']);

                    array_push($json_array, $result);
                }
                $json = json_encode($json_array);
                echo $json;
//                echo AppUtil::getReturnStatus("success",$json);
            }

        } else {
            $returnVal = array('status' => "Fail", 'message' => "Bills not found");
            echo json_encode($returnVal);
        }
    }
    public static function getBillBySupplierId($billID){
        $db = Database::getInstance();
        $conn = $db->getConnection();

        $stmt = "SELECT * FROM supplier_invoice_master WHERE supplier_invoice_master.supplierinvoiceid=:keyword";
        $stmt = $conn->prepare($stmt);
        $stmt->bindParam(':keyword', $billID);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $json_array = array();
                while ($result2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result = array();
                    $stmt12 = "SELECT SUM(amountpaid) AS totalpaidamount FROM supplier_payment WHERE supplier_payment.supplierinvoiceid=:keyword";
                    $stmt12 = $conn->prepare($stmt12);
                    $stmt12->bindParam(':keyword',$result2['supplierinvoiceid'] );
                    if($stmt12->execute()){
                        $res=$stmt12->fetch(PDO::FETCH_ASSOC);
                        $result['totalpaidamount'] = $res['totalpaidamount'];
                    }
                    $result['invoiceid'] = $result2['supplierinvoiceid'];
                    $result['clientid'] = $result2['supplierid'];
                    $result['createdby'] = $result2['createdby'];
                    $result['invoicenumber'] = $result2['supplierinvoicenumber'];
                    $result['totalamounttoBePaid'] = $result2['totalamount'];
                    $result['clientname'] = AppUtil::getSupplierName($conn,  $result2['supplierid']);

                    array_push($json_array, $result);
                }
                $json = json_encode($json_array);
                echo $json;
//                echo AppUtil::getReturnStatus("success",$json);
            }

        } else {
            $returnVal = array('status' => "Fail", 'message' => "Bills not found");
            echo json_encode($returnVal);
        }
    }

    public static function addSupplierPayment($data,$userId){
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $masterid = "";
        $isCashPayment=false;
        $chequeNumber=" ";
        try {
            $stmt = $conn->prepare("INSERT INTO `supplier_payment`(`supplierinvoiceid`, `amountpaid`, `paymentdate`, `recievedBy`, `isCashPayment`, `createdby`, `creationdate`, `lastmodificationdate`, `lastmodifiedby`)
                                  VALUES (:invoiceid,:amountpaid,:paymentdate,:recievedBy,:isCashPayment,:creadtedby,now(),now(),:lastmodifyby)");
            $stmt->bindParam(':invoiceid', $data->invoiceid, PDO::PARAM_STR, 10);
            $stmt->bindParam(':amountpaid', $data->amountPaid, PDO::PARAM_STR, 10);
            $stmt->bindParam(':paymentdate', $data->paymentDate, PDO::PARAM_STR, 10);
            $stmt->bindParam(':recievedBy', $data->paymentReceiver, PDO::PARAM_STR, 10);
            if($data->paymentMode=="Cheque"){
                $isCashPayment=false;
            }else{
                $isCashPayment=true;
            }
            $stmt->bindParam(':isCashPayment',$isCashPayment, PDO::PARAM_STR, 10);
            $stmt->bindParam(':creadtedby', $userId, PDO::PARAM_STR, 10);
            $stmt->bindParam(':lastmodifyby', $userId, PDO::PARAM_STR, 10);
            if ($stmt->execute()) {

                $masterid = $conn->lastInsertId();
                $stmt1 = $conn->prepare("INSERT INTO `supplier_payment_mode`(`supplierpaymentid`, `paymenttype`, `chequenumber`, `bankname`)
                                  VALUES (:supplierpaymentid,:paymenttype,:chequenumber,:bankname)");
                $stmt1->bindParam(':supplierpaymentid', $masterid, PDO::PARAM_STR, 10);
                $stmt1->bindParam(':paymenttype', $data->paymentMode, PDO::PARAM_STR, 10);
                if($data->paymentMode=="Cheque"){
                    $stmt1->bindParam(':chequenumber', $data->chequeNumber, PDO::PARAM_STR, 10);
                    $stmt1->bindParam(':bankname', $data->bankName, PDO::PARAM_STR, 10);
                }else{
                    $stmt1->bindParam(':chequenumber', $chequeNumber, PDO::PARAM_STR, 10);
                    $stmt1->bindParam(':bankname', $chequeNumber, PDO::PARAM_STR, 10);
                }

                if ($stmt1->execute()) {

                    // Change status to paid if remaining amt is zero
                    $isPaid=true;

                    if($data->remainingAmount<=0){
                        $stmtUpdateInvoice=$conn->prepare("UPDATE supplier_invoice_master SET isPaid =:isPaid,lastmodificationdate=now(),lastmodifiedby=:lastmodifiedby
                                     WHERE supplierinvoiceid = :supplierinvoiceid");
                        $stmtUpdateInvoice->bindParam(':isPaid', $isPaid, PDO::PARAM_STR, 10);
                        $stmtUpdateInvoice->bindParam(':lastmodifiedby', $userId, PDO::PARAM_STR, 10);
                        $stmtUpdateInvoice->bindParam(':supplierinvoiceid', $data->invoiceid, PDO::PARAM_STR, 10);
                        if($stmtUpdateInvoice->execute()){

                        }
                    }

                    echo AppUtil::getReturnStatus("success", "Payment added Successfully");
                } else {
                    echo AppUtil::getReturnStatus("Fail", $stmt1->errorInfo());
                }

            } else {

                echo AppUtil::getReturnStatus("Fail",  $stmt->errorInfo());
            }
        } catch (Exception $e) {
            echo AppUtil::getReturnStatus("Fail", "Something went wrong. please try again");
        }
    }

    public static function getSupplierInvoices($searchBy, $keyword){
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $stmt = "SELECT * FROM supplier_invoice_master WHERE supplier_invoice_master.supplierid=:keyword";
        $stmt = $conn->prepare($stmt);
        $stmt->bindParam(':keyword', $keyword);
        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $json_array = array();
                while ($result2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result = array();
                    $result['invoiceid'] = $result2['supplierinvoiceid'];
                    $result['clientid'] = $result2['supplierid'];
                    $result['createdby'] = $result2['createdby'];
                    $result['invoicedate'] = $result2['supplierinvoicedate'];
                    $result['invoicenumber'] = $result2['supplierinvoicenumber'];
                    $result['totalamounttoBePaid'] = $result2['totalamount'];
                    $result['clientname'] = AppUtil::getSupplierName($conn,$result2['supplierid']);
                    array_push($json_array, $result);

                }
                $json = json_encode($json_array);
                echo $json;
            }

        } else {
            $returnVal = array('status' => "Fail", 'message' => "Bills not found");
            echo json_encode($returnVal);
        }
    }
}