<?php
require_once 'Database.php';
require_once 'appUtil.php';

/**
 * Created by IntelliJ IDEA.
 * User: LENOVO
 * Date: 2016-08-28
 * Time: 1:02 PM
 */
class Supplier{

    public static function addSupplier($data,$userId)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        try{
            $stmt=$conn->prepare("INSERT INTO `supplier`(`suppliername`, `address`, `contactnumber`, `email`, `createdby`, `creationdate`, `lastmodificationdate`, `lastmodifiedby`)
                                  VALUES (:suppliername,:address,:contactnumber,:email,:creadtedby,now(),now(),:lastmodifyby)");
            $stmt->bindParam(':suppliername', $data->name, PDO::PARAM_STR, 10);
            $stmt->bindParam(':address', $data->address, PDO::PARAM_STR, 10);
            $stmt->bindParam(':contactnumber', $data->contact, PDO::PARAM_STR, 10);
            $stmt->bindParam(':email', $data->email, PDO::PARAM_STR, 10);
            $stmt->bindParam(':creadtedby', $userId, PDO::PARAM_STR, 10);
            $stmt->bindParam(':lastmodifyby', $userId, PDO::PARAM_STR, 10);
            if($stmt->execute()){
                echo AppUtil::getReturnStatus("success","Supplier added succefully");
            }else{
                echo AppUtil::getReturnStatus("Fail","Please try again");
            }
        }catch(Exception $e){
            echo AppUtil::getReturnStatus("Fail","Something went wrong. please try again");
        }
    }
    public static function getSupplier()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT `suppliername`,`supplierid`, `address`, `contactnumber`, `email` FROM supplier");

        if ($stmt->execute()) {
            if($stmt->rowCount()>0){
                $json_array=array();
                while ($result2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result = array();
                    $result['suppliername']=$result2['suppliername'];
                    $result['supplierid']=$result2['supplierid'];
                    $result['address']=$result2['address'];
                    $result['contactnumber']=$result2['contactnumber'];
                    $result['email']=$result2['email'];
                    array_push($json_array,$result);
                }
                $json = json_encode($json_array);
                echo $json;
//                echo AppUtil::getReturnStatus("success",$json);
            }

        } else {
            $returnVal=array('status' => "Fail", 'message' => "Vehicles not found" );
            echo json_encode($returnVal);
        }
    }

    public static function modifySupplier($data,$userId)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        try{
            $stmt=$conn->prepare("UPDATE `supplier` SET
                                        suppliername=:suppliername,
                                        address=:address,
                                        email=:email,
                                        contactnumber=:contactnumber,
                                        lastmodifiedby=:lastmodifyby,
                                        lastmodificationdate=now() WHERE supplierid=:supplierId");
            $stmt->bindParam(':supplierId', $data->supplierid, PDO::PARAM_STR, 10);
            $stmt->bindParam(':suppliername', $data->suppliername, PDO::PARAM_STR, 10);
            $stmt->bindParam(':address', $data->address, PDO::PARAM_STR, 10);
            $stmt->bindParam(':email', $data->email, PDO::PARAM_STR, 10);
            $stmt->bindParam(':contactnumber', $data->contactnumber, PDO::PARAM_STR, 10);
            $stmt->bindParam(':lastmodifyby', $userId, PDO::PARAM_STR, 10);

            if($stmt->execute()){
                echo AppUtil::getReturnStatus("success","Supplier Modified Succefully");

            }else{
                echo AppUtil::getReturnStatus("Fail","Please try again");
            }
        }catch(Exception $e){

            echo AppUtil::getReturnStatus("Fail","Something went wrong. please try again");
        }
    }
}