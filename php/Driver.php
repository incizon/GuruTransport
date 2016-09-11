<?php
require_once 'Database.php';
require_once 'appUtil.php';

/**
 * Created by IntelliJ IDEA.
 * User: LENOVO
 * Date: 2016-08-28
 * Time: 1:02 PM
 */
class Driver{

    public static function addDriver($data,$userId)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        try{
            $stmt=$conn->prepare("INSERT INTO `driver`(`drivername`, `address`, `email`, `contactnumber`, `creadtedby`, `creationdate`, `lastmodifyby`, `lastmodificationdate`)
                                  VALUES (:drivername,:address,:email,:contactnumber,:creadtedby,now(),:lastmodifyby,now())");
            $stmt->bindParam(':drivername', $data->name, PDO::PARAM_STR, 10);
            $stmt->bindParam(':address', $data->address, PDO::PARAM_STR, 10);
            $stmt->bindParam(':email', $data->email, PDO::PARAM_STR, 10);
            $stmt->bindParam(':contactnumber', $data->contact, PDO::PARAM_STR, 10);
            $stmt->bindParam(':creadtedby', $userId, PDO::PARAM_STR, 10);
            $stmt->bindParam(':lastmodifyby', $userId, PDO::PARAM_STR, 10);
            if($stmt->execute()){
                echo AppUtil::getReturnStatus("success","Driver added succefully");
            }else{
                echo AppUtil::getReturnStatus("Fail","Please try again");
            }
        }catch(Exception $e){
            echo AppUtil::getReturnStatus("Fail","Something went wrong. please try again");
        }
    }
    public static function getDriver()
    {

        $db = Database::getInstance();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT `drivername`,driverid, `address`, `email`, `contactnumber` FROM driver");

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