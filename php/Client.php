<?php
require_once 'Database.php';
require_once 'appUtil.php';

/**
 * Created by IntelliJ IDEA.
 * User: LENOVO
 * Date: 2016-08-28
 * Time: 1:02 PM
 */
class Client{

    public static function addClient($data,$userId)
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        try{
            $stmt=$conn->prepare("INSERT INTO `client`( `clientname`, `address`, `email`, `contactnumber`, `createdby`, `creationdate`, `lastmodificationdate`, `lastmodifiedby`)
                                  VALUES (:clientname,:address,:email,:contactnumber,:creadtedby,now(),now(),:lastmodifyby)");
            $stmt->bindParam(':clientname', $data->name, PDO::PARAM_STR, 10);
            $stmt->bindParam(':address', $data->address, PDO::PARAM_STR, 10);
            $stmt->bindParam(':email', $data->email, PDO::PARAM_STR, 10);
            $stmt->bindParam(':contactnumber', $data->contact, PDO::PARAM_STR, 10);
            $stmt->bindParam(':creadtedby', $userId, PDO::PARAM_STR, 10);
            $stmt->bindParam(':lastmodifyby', $userId, PDO::PARAM_STR, 10);
            if($stmt->execute()){
                echo AppUtil::getReturnStatus("success","Client added succefully");
            }else{
                echo AppUtil::getReturnStatus("Fail","Please try again");
            }
        }catch(Exception $e){
            echo AppUtil::getReturnStatus("Fail","Something went wrong. please try again");
        }
    }
    public static function getClient()
    {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        $stmt = $conn->prepare("SELECT `clientname`,`address`,`clientid`,`email`,`contactnumber` FROM client");

        if ($stmt->execute()) {
            if($stmt->rowCount()>0){
                $json_array=array();
                while ($result2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $result = array();
                    $result['clientid'] = $result2['clientid'];
                    $result['clientName'] = $result2['clientname'];
                    $result['clientAddress'] = $result2['address'];
                    $result['clientEmail'] = $result2['email'];
                    $result['clientContact'] = $result2['contactnumber'];
                    array_push($json_array,$result);
                }
                $json = json_encode($json_array);
                echo $json;
            }

        } else {
            $returnVal=array('status' => "Fail", 'message' => "Vehicles not found" );
            echo json_encode($returnVal);
        }
    }
}