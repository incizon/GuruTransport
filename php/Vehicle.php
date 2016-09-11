<?php
require_once 'Database.php';
require_once 'appUtil.php';

/**
 * Created by IntelliJ IDEA.
 * User: LENOVO
 * Date: 2016-08-28
 * Time: 1:02 PM
 */
class Vehicle{

    public static function addVehicle($vehiclenumber,$vehicleDetails,$userId)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        try{
            $stmt=$conn->prepare("INSERT INTO `vehicle_master`(`vehiclenumber`, `vehicledetails`, `createdby`, `creationdate`, `lastmodifiedby`, `lastmodificationdate`)
                                  VALUES (:vehicleno,:vehicledetails,:lchnguserid,now(),:creuserid,now())");
            $stmt->bindParam(':vehicleno', $vehiclenumber, PDO::PARAM_STR, 10);
            $stmt->bindParam(':vehicledetails', $vehicleDetails, PDO::PARAM_STR, 10);
            $stmt->bindParam(':lchnguserid', $userId, PDO::PARAM_STR, 10);
            $stmt->bindParam(':creuserid', $userId, PDO::PARAM_STR, 10);
            if($stmt->execute()){

                echo AppUtil::getReturnStatus("success","Vehicle added succefully");
            }else{
                echo AppUtil::getReturnStatus("Fail","Please try again");
            }
        }catch(Exception $e){
            echo AppUtil::getReturnStatus("Fail","Something went wrong. please try again");
        }
    }
    public static function getVehicles()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT vehiclenumber,vehicleid,vehicledetails FROM vehicle_master");

        if ($stmt->execute()) {
            if($stmt->rowCount()>0){
                $result = $stmt->fetchAll();
                echo json_encode($result);
            }

        } else {
            $returnVal=array('status' => "Fail", 'message' => "Vehicles not found" );
            echo json_encode($returnVal);
        }
    }
}