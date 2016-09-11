myApp.controller("AddVehicleController", function ($scope, $http) {

    $scope.vehicle = {};

    $scope.addVehicle = function () {
        //Set Extra attribute in object to identify operation to be performed
        console.log("In add Vehicle");
        $scope.vehicle.opertaion = "addVehicle";
        $scope.submitted = false;
        $scope.errorMessage = "";
        $scope.warningMessage = "";
        $('#loader').css("display", "block");
        console.log($scope.vehicle);
        var config = {
            params: {
                data: $scope.vehicle
            }
        };
        //call service
        $http.post("php/VehicleFacade.php", null, config)
            .success(function (data) {
                $('#loader').css("display", "none");
                if (data.status == "success") {
                    $scope.warningMessage = data.message;
                    $('#warning').css("display", "block");
                } else {
                    $scope.errorMessage = data.message;
                    $('#error').css("display", "block");
                }
            })
            .error(function (data, status, headers, config) {
                console.log(data.error);
                $('#loader').css("display", "none");
                $scope.errorMessage = data.message;
                $('#error').css("display", "block");
            });

    };
});
myApp.controller("ViewVehicleController", function ($scope,$http) {

    console.log(" In View Vehicle Controller");
    $scope.vehicles=[];
    var data = {
        opertaion: "getVehicle"
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/VehicleFacade.php",null, config)
        .success(function (data) {
            $scope.vehicles=data;
            console.log($scope.vehicles);

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });
});
myApp.controller("AddDriverController", function ($scope, $http) {
    $scope.Driver = {};
    $scope.addDriver = function () {
        //Set Extra attribute in object to identify operation to be performed
        console.log("In add Driver");

        $scope.submitted = false;
        $scope.errorMessage = "";
        $scope.warningMessage = "";
        $('#loader').css("display", "block");

        var data = {
            data: $scope.Driver,
            opertaion: "addDriver"
        }
        var config = {
            params: {
                data: data,

            }
        };
        console.log(config);
        //call service
        $http.post("php/DriverFacade.php", null, config)
            .success(function (data) {
                console.log(data);
                $('#loader').css("display", "none");
                if (data.status == "success") {
                    $scope.warningMessage = data.message;
                    $('#warning').css("display", "block");

                } else {
                    $scope.errorMessage = data.message;
                    $('#error').css("display", "block");
                }
            })
            .error(function (data, status, headers, config) {
                console.log(data.error);
                $('#loader').css("display", "none");
                $scope.errorMessage = data.message;
                $('#error').css("display", "block");
            });

    };

});

myApp.controller("ViewDriversController", function ($scope) {

    console.log("View Drivers Controller");

    $scope.drivers = [
        {
            "driverName": "Driver1",
            "driverContact": "1234567890",
            "driverEmail": "driver1@gmail.com",
            "driverAddress": "Pune"
        },
        {
            "driverName": "Driver2",
            "driverContact": "9876543210",
            "driverEmail": "driver2@gmail.com",
            "driverAddress": "Mumbai"
        },
        {
            "driverName": "Driver3",
            "driverContact": "1234567890",
            "driverEmail": "driver3@gmail.com",
            "driverAddress": "Pune"
        },
        {
            "driverName": "Driver4",
            "driverContact": "9876543210",
            "driverEmail": "driver4@gmail.com",
            "driverAddress": "Nagar"
        },
        {
            "driverName": "Driver5",
            "driverContact": "1234567890",
            "driverEmail": "driver5@gmail.com",
            "driverAddress": "Nashik"
        }
    ];
});
myApp.controller("AddSupplierController", function ($scope, $http) {

    $scope.Supplier = {};
    $scope.addSupplier = function () {
        //Set Extra attribute in object to identify operation to be performed
        console.log("In add Supplier");

        $scope.submitted = false;
        $scope.errorMessage = "";
        $scope.warningMessage = "";
        $('#loader').css("display", "block");

        var data = {
            data: $scope.Supplier,
            opertaion: "addSupplier"
        }
        var config = {
            params: {
                data: data
            }
        };
        console.log(config);
        //call service
        $http.post("php/SupplierFacade.php", null, config)
            .success(function (data) {
                console.log(data);
                $('#loader').css("display", "none");
                if (data.status == "success") {
                    $scope.warningMessage = data.message;
                    $('#warning').css("display", "block");
                } else {
                    $scope.errorMessage = data.message;
                    $('#error').css("display", "block");
                }
            })
            .error(function (data, status, headers, config) {
                console.log(data.error);
                $('#loader').css("display", "none");
                $scope.errorMessage = data.message;
                $('#error').css("display", "block");
            });

    };

});

myApp.controller("ViewSuppliersController", function ($scope,$http) {

    console.log("In  View Retailers Controller");
    $scope.retailers = [
    ];
    var data = {
        opertaion: "getSupplier"
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/SupplierFacade.php",null, config)
        .success(function (data) {
            $scope.retailers=data;
            console.log($scope.retailers);

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });
});
myApp.controller("AddClientController", function ($scope, $http) {

    $scope.Client = {};
    $scope.addClient = function () {
        //Set Extra attribute in object to identify operation to be performed
        console.log("In add Supplier");

        $scope.submitted = false;
        $scope.errorMessage = "";
        $scope.warningMessage = "";
        $('#loader').css("display", "block");
        var data = {
            data: $scope.Client,
            opertaion: "addClient"
        }
        var config = {
            params: {
                data: data
            }
        };
        console.log(config);
        //call service
        $http.post("php/ClientFacade.php", null, config)
            .success(function (data) {
                console.log(data);
                $('#loader').css("display", "none");
                if (data.status == "success") {
                    $scope.warningMessage = data.message;
                    $('#warning').css("display", "block");
                    setTimeout(function () {
                        $('#warning').css("display", "none");
                        window.location="Client/AddClient";
                    }, 2000);
                } else {
                    $scope.errorMessage = data.message;
                    $('#error').css("display", "block");
                }
            })
            .error(function (data, status, headers, config) {
                console.log(data.error);
                $('#loader').css("display", "none");
                $scope.errorMessage = data.message;
                $('#error').css("display", "block");
            });

    };
});

myApp.controller("ViewClientsController", function ($scope,$http) {

    console.log("In View Clients Controller");

    $scope.clients = [ ];
    var data = {
        opertaion: "getClient"
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/ClientFacade.php",null, config)
        .success(function (data) {
            $scope.clients=data;
            console.log($scope.clients);

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });

});

myApp.controller("AddWorkOrderController", function ($scope, $http) {

    console.log("In Add Work Order Controller");

    $scope.process = {

        isMaintenance: false,
        sellingAmount: 0,
        purchaseAmount: 0
    };
    $scope.suppliers={};
    var data = {
        opertaion: "getSupplier"
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/SupplierFacade.php",null, config)
        .success(function (data) {
            $scope.suppliers=data;
            console.log($scope.suppliers);

        }).error(function (data, status, headers, config) {
            $('#loader').css("display", "none");
            $scope.errorMessage = data;
            $('#error').css("display", "block");
    });

    $scope.vehicles={};
    var data = {
        opertaion: "getVehicle"
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/VehicleFacade.php",null, config)
        .success(function (data) {
            $scope.vehicles=data;
            console.log($scope.vehicles);

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });

    $scope.clients={};
    var data = {
        opertaion: "getClient"
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/ClientFacade.php",null, config)
        .success(function (data) {
            $scope.clients=data;
            console.log($scope.clients);

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });

    $scope.drivers={};
    var data = {
        opertaion: "getDrivers"
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/DriverFacade.php",null, config)
        .success(function (data) {
            $scope.drivers=data;
            console.log($scope.drivers);

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });

    $scope.calculateTotal=function(){
        if($scope.process.sellingAmount!=undefined && $scope.process.sellingRate){
            $scope.process.sellingAmount=$scope.process.sellingQuantity * $scope.process.sellingRate;
        }
    }
    $scope.calculatePurchaseTotal=function(){
        if($scope.process.purchaseRate!=undefined && $scope.process.purchaseQuantity){
            $scope.process.purchaseAmount=$scope.process.purchaseRate * $scope.process.purchaseQuantity;
        }
    }
    $scope.getFormattedDate=function (input){
        var d = new Date(input);
        //var str = mydate.toString("dd-MM-yyyy");
        var curr_date = d.getDate();
        var curr_month = d.getMonth() + 1; //Months are zero based
        var curr_year = d.getFullYear();
        if(curr_month<=9)
            return curr_year + "-0" + curr_month + "-" + curr_date;

        return curr_year + "-" + curr_month + "-" + curr_date;
    }
    $scope.addWorkOrder=function(){
        $scope.errorMessage = "";
        $scope.warningMessage = "";
        $('#loader').css("display", "block");
        console.log($scope.process);
        $scope.process.purchaseDate=$scope.getFormattedDate($scope.process.purchaseDate);
        $scope.process.sellingDate=$scope.getFormattedDate($scope.process.sellingDate);

        var data = {
            data: $scope.process,
            opertaion: "addWorkorder"
        }
        var config = {
            params: {
                data: data
            }
        };
        console.log(config);
        //call service
        $http.post("php/ProcessFacade.php", null, config)
            .success(function (data) {
                console.log(data);
                $('#loader').css("display", "none");
                if (data.status == "success") {
                    $scope.warningMessage = data.message;
                    $('#warning').css("display", "block");
                    setTimeout(function () {
                        $('#warning').css("display", "none");
                        window.location="/#/WorkOrder/AddWorkOrder";
                    }, 2000);
                } else {
                    $scope.errorMessage = data.message;
                    $('#error').css("display", "block");
                }
            })
            .error(function (data, status, headers, config) {
                console.log(data.error);
                $('#loader').css("display", "none");
                $scope.errorMessage = data.message;
                $('#error').css("display", "block");
            });

    }
});
myApp.controller("ViewWorkOrdersController", function ($scope,$http) {

    console.log("In View Work Order Controller");

    $scope.Workorders=[];
    $scope.name="Suppliers and Clients"
    var data = {
        opertaion: "getWorkorders"
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/ProcessFacade.php",null, config)
        .success(function (data) {
            $scope.Workorders=data;
            console.log($scope.Workorders);

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });
});
myApp.controller("ViewClientwiseWorkOrdersController", function ($scope,$http,$stateParams) {

    console.log("In View Work Order Controller");

    console.log($stateParams.clientid);
    $scope.name="";
    $scope.Workorders=[];
    var data = {
        opertaion: "getClientWiseWorkorders",
        clientid:$stateParams.clientid
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/ProcessFacade.php",null, config)
        .success(function (data) {
            $scope.Workorders=data;
            $scope.name=$scope.Workorders[0].clientname;
            console.log($scope.Workorders);

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });
});


myApp.controller("addPaymentController", function ($scope,$http,$stateParams) {

    console.log("In add payment Controller");
    console.log($stateParams.clientid);
    $scope.Bills={};
    $scope.BillDetails={};
    $scope.BillDetails.totalamounttoBePaid=0;
    $scope.payment={};
    var data = {
        opertaion: "getBills",
        clientid:$stateParams.clientid
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/ProcessFacade.php",null, config)
        .success(function (data) {
            $scope.Bills=data;
            console.log($scope.Bills);

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });

    $scope.getBillDetails= function (billId) {

        console.log(billId);
        var data = {
            opertaion: "getBillbyId",

            billid:billId
        }
        var config = {
            params: {
                data: data
            }
        };
        $http.post("php/ProcessFacade.php",null, config)
            .success(function (data) {
                $scope.BillDetails=data;
                console.log($scope.BillDetails);

            }).error(function (data, status, headers, config) {
            $('#loader').css("display", "none");
            $scope.errorMessage = data;
            $('#error').css("display", "block");
        });

    }

    $scope.addPayment=function(){
        var data = {
            data:$scope.payment,
            opertaion: "addClientPayment"
        }
        var config = {
            params: {
                data: data
            }
        };
        console.log(config);
        //call service
        $http.post("php/ProcessFacade.php", null, config)
            .success(function (data) {
                $('#loader').css("display", "none");
                if (data.status == "success") {
                    $scope.warningMessage = data.message;
                    $('#warning').css("display", "block");
                    setTimeout(function () {
                        $('#warning').css("display", "none");
                        window.location="/#/WorkOrder/AddWorkOrder";
                    }, 2000);
                } else {
                    $scope.errorMessage = data.message;
                    $('#error').css("display", "block");
                }
            })
            .error(function (data, status, headers, config) {
                console.log(data.error);
                $('#loader').css("display", "none");
                $scope.errorMessage = data.message;
                $('#error').css("display", "block");
            });

    }
});


myApp.controller("invoiceController", function ($scope,$http,$stateParams) {

    console.log("In bill Controller");
    console.log($stateParams.clientid);
    $scope.bill = {
        totalBillAmount:0
    };
    $scope.billWorkorders=[];
    $scope.Workorders=[];
  //  $scope.totalBillAmount=0;
    var data = {
        opertaion: "getClientWiseWorkordersForInvoice",
        clientid:$stateParams.clientid
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/ProcessFacade.php",null, config)
        .success(function (data) {
            $scope.Workorders=data;
            console.log($scope.Workorders);
            $scope.clientname=$scope.Workorders[0].clientname;

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });

    $scope.addWorkorderTobill=function(workorder,workorderid,workorderAmount){

        if(workorder){
            console.log("in add"+workorderid);
            $scope.billWorkorders.push(workorderid);
            $scope.bill.totalBillAmount=$scope.bill.totalBillAmount+workorderAmount;
            console.log( $scope.bill.totalBillAmount);
        }else{
            console.log("in fail");
           for(var i=0;i<$scope.billWorkorders.length;i++){
               if($scope.billWorkorders[i]==workorderid){
                   $scope.billWorkorders.splice(i,1);
                   console.log( $scope.bill.totalBillAmount);
                   $scope.bill.totalBillAmount=$scope.bill.totalBillAmount-workorderAmount;
               }
           }
        }

    }

    $scope.createBill=function(){

        var data = {
            opertaion: "createBill",
            clientid:$stateParams.clientid,
            billData:$scope.bill,
            billWorkorders:$scope.billWorkorders
        }
        var config = {
            params: {
                data: data
            }
        };
        console.log(config);
        $http.post("php/ProcessFacade.php",null, config)
            .success(function (data) {
                $('#loader').css("display", "none");
                if (data.status == "success") {
                    $scope.warningMessage = data.message;
                    $('#warning').css("display", "block");
                    setTimeout(function () {
                        $('#warning').css("display", "none");
                    }, 2000);
                } else {
                    $scope.errorMessage = data.message;
                    $('#error').css("display", "block");
                }

            }).error(function (data, status, headers, config) {
                console.log(data);
                $('#loader').css("display", "none");
                $scope.errorMessage = data;
                $('#error').css("display", "block");
        });

    }
});
myApp.controller("viewClientInvoiceController", function ($scope,$http,$stateParams) {
    $scope.Invoices=[];
    var data = {
        opertaion: "getClientInvoices",
        clientid:$stateParams.clientid
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/ProcessFacade.php",null, config)
        .success(function (data) {
            $scope.Invoices=data;
            console.log($scope.Invoices);
            $scope.clientname=$scope.Invoices[0].clientname;

        }).error(function (data, status, headers, config) {
            $('#loader').css("display", "none");
            $scope.errorMessage = data;
            $('#error').css("display", "block");
    });
});
//SUPPLIER CONTROLLERS

myApp.controller("ViewSupplierwiseWorkOrdersController", function ($scope,$http,$stateParams) {

    $scope.Workorders=[];
    $scope.name="";
    var data = {
        opertaion: "getSupplierWiseWorkorders",
        supplierid:$stateParams.supplierid
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/ProcessFacade.php",null, config)
        .success(function (data) {
            $scope.Workorders=data;
            console.log($scope.Workorders);
            $scope.name=$scope.Workorders[0].suppliername;
            //JSONToCSVConvertor($scope.Workorders,"TEST_REPORT",true);
            $scope.clientname=$scope.Workorders[0].clientname;

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });
});


myApp.controller("invoiceSupplierController", function ($scope,$http,$stateParams) {
    $scope.Workorders=[];
    $scope.bill = {
        totalBillAmount:0
    };
    $scope.billWorkorders=[];
    $scope.clientname="";
    var data = {
        opertaion: "getSupplierWiseWorkordersFORInvoice",
        supplierid:$stateParams.supplierid
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/ProcessFacade.php",null, config)
        .success(function (data) {
            $scope.Workorders=data;
            console.log($scope.Workorders[0]);
            $scope.clientname=$scope.Workorders[0].clientname;

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });


    $scope.addWorkorderTobill=function(workorder,workorderid,workorderAmount){

        if(workorder){
            console.log("in add"+workorderid);
            $scope.billWorkorders.push(workorderid);
            $scope.bill.totalBillAmount=$scope.bill.totalBillAmount+workorderAmount;
            console.log( $scope.bill.totalBillAmount);
        }else{
            console.log("in fail");
            for(var i=0;i<$scope.billWorkorders.length;i++){
                if($scope.billWorkorders[i]==workorderid){
                    $scope.billWorkorders.splice(i,1);
                    console.log( $scope.bill.totalBillAmount);
                    $scope.bill.totalBillAmount=$scope.bill.totalBillAmount-workorderAmount;
                }
            }
        }

    }

    $scope.createBill=function(){

        var data = {
            opertaion: "createSupplierBill",
            supplierid:$stateParams.supplierid,
            billData:$scope.bill,
            billWorkorders:$scope.billWorkorders
        }
        var config = {
            params: {
                data: data
            }
        };
        console.log(config);
        $http.post("php/ProcessFacade.php",null, config)
            .success(function (data) {
                console.log(data);
                $('#loader').css("display", "none");
                if (data.status == "success") {
                    $scope.warningMessage = data.message;
                    $('#warning').css("display", "block");
                    setTimeout(function () {
                        $('#warning').css("display", "none");
                    }, 2000);
                } else {
                    $scope.errorMessage = data.message;
                    $('#error').css("display", "block");
                }

            }).error(function (data, status, headers, config) {
                console.log(data);
                $('#loader').css("display", "none");
                $scope.errorMessage = data;
                $('#error').css("display", "block");
        });

    }
});

myApp.controller("addSupplierPaymentController", function ($scope,$http,$stateParams) {
    console.log("In add payment Controller");
    console.log($stateParams.supplierid);
    $scope.Bills={};
    $scope.BillDetails={};
    $scope.BillDetails.totalamounttoBePaid=0;
    $scope.payment={};

    var data = {
        opertaion: "getSupplierBills",
        supplierid:$stateParams.supplierid
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/ProcessFacade.php",null, config)
        .success(function (data) {
            $scope.Bills=data;
            console.log($scope.Bills);

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });

    $scope.getBillDetails= function (billId) {

        console.log(billId);
        var data = {
            opertaion: "getBillbySupplierBillId",
            billid:billId
        }
        var config = {
            params: {
                data: data
            }
        };
        $http.post("php/ProcessFacade.php",null, config)
            .success(function (data) {
                $scope.BillDetails=data;
                console.log($scope.BillDetails);

            }).error(function (data, status, headers, config) {
            $('#loader').css("display", "none");
            $scope.errorMessage = data;
            $('#error').css("display", "block");
        });

    }

    $scope.addPayment=function(){
        var data = {
            data:$scope.payment,
            opertaion: "addSupplierPayment"
        }
        var config = {
            params: {
                data: data
            }
        };
        console.log(config);
        //call service
        $http.post("php/ProcessFacade.php", null, config)
            .success(function (data) {
                $('#loader').css("display", "none");
                if (data.status == "success") {
                    $scope.warningMessage = data.message;
                    $('#warning').css("display", "block");
                    setTimeout(function () {
                        $('#warning').css("display", "none");
                        window.location="/#/WorkOrder/AddWorkOrder";
                    }, 2000);
                } else {
                    $scope.errorMessage = data.message;
                    $('#error').css("display", "block");
                }
            })
            .error(function (data, status, headers, config) {
                console.log(data.error);
                $('#loader').css("display", "none");
                $scope.errorMessage = data.message;
                $('#error').css("display", "block");
            });

    }
});

myApp.controller("viewSupplierInvoiceController", function ($scope,$http,$stateParams) {
    $scope.Invoices=[];
    var data = {
        opertaion: "getSupplierInvoices",
        supplierid:$stateParams.supplierid
    }
    var config = {
        params: {
            data: data
        }
    };
    $http.post("php/ProcessFacade.php",null, config)
        .success(function (data) {
            $scope.Invoices=data;
            console.log($scope.Invoices);
            $scope.clientname=$scope.Invoices[0].clientname;

        }).error(function (data, status, headers, config) {
        $('#loader').css("display", "none");
        $scope.errorMessage = data;
        $('#error').css("display", "block");
    });
});


// REPORT
function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

    var CSV = '';
    //Set Report title in first row or line

    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";

        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {

            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);

        //append Label row with line break
        CSV += row + '\r\n';
    }

    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";

        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);

        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {
        alert("Invalid data");
        return;
    }

    //Generate a file name
    var fileName = "MyReport_";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");

    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension

    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");
    link.href = uri;

    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";

    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}