<?php


class AppUtil
{


    public static function getReturnStatus($status, $message)
    {
        $returnVal = array('status' => $status, 'message' => $message);
        return json_encode($returnVal);
    }

//switch ($searchBy) {
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
//$stmt=$conn->prepare($stmt);
//$stmt->bindParam(':keyword', $keyword);
    public static function getNameFromId($db, $conn, $keyword, $table, $id, $searchId)
    {

        $stmt = $conn->prepare("SELECT clientname FROM client WHERE clientid=" . $searchId);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {
                $name = "--";
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $name = $result["clientname"];

                return $name;
            } else {
                return "--";
            }

        } else {

            return "---";
        }
    }

    public static function getVehicleName($conn, $searchId)
    {

        $stmt = $conn->prepare("SELECT vehiclenumber FROM vehicle_master WHERE vehicleid=" . $searchId);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $name = $result["vehiclenumber"];

                return $name;
            } else {
                return "--";
            }

        } else {

            return "---";
        }
    }

    public static function getDriverName($conn, $searchId)
    {

        $stmt = $conn->prepare("SELECT drivername FROM driver WHERE driverid=" . $searchId);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $name = $result["drivername"];

                return $name;
            } else {
                return "--";
            }

        } else {

            return "---";
        }
    }

    public static function getSupplierName($conn, $searchId)
    {

        $stmt = $conn->prepare("SELECT suppliername FROM supplier WHERE supplierid=" . $searchId);

        if ($stmt->execute()) {
            if ($stmt->rowCount() > 0) {

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $name = $result["suppliername"];

                return $name;
            } else {
                return "--";
            }

        } else {

            return "---";
        }
    }
}


?>