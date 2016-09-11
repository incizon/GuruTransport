var myApp=angular.module("myApp",['ui.router']);

myApp.config(function($stateProvider,$urlRouterProvider,$locationProvider){

	$urlRouterProvider.otherwise("/dashboard");

	$stateProvider

	.state('addWorkOrder',{

			url:"/WorkOrder/AddWorkOrder",
			templateUrl:"html/AddWorkOrder.html",
		    controller:'AddWorkOrderController'
	})
	.state('viewWorkOrders',{

		url:"/WorkOrder/ViewWorkOrders",
        templateUrl:"html/ViewWorkorder.html",
		controller:'ViewWorkOrdersController'
	})
	.state('addVehicle',{

			url:"/Vehicle/AddVehicle",
			templateUrl:"html/AddVehicle.html",
			controller:"AddVehicleController"	
	})

	.state('viewVehicles',{

			url:"/Vehicle/ViewVehicle",
			templateUrl:"html/ViewVehicles.html",
			controller:"ViewVehicleController"		
	})
	.state('addDriver',{

			url:"/Driver/AddDriver",
			templateUrl:"html/AddDriver.html",
			controller:"AddDriverController"	
	})

	.state('viewDrivers',{

			url:"/Driver/ViewDrivers",
			templateUrl:"html/ViewDrivers.html",
			controller:"ViewDriversController"		
	})

	.state('addSupplier',{

			url:"/Supplier/AddSupplier",
			templateUrl:"html/AddSupplier.html",
			controller:"AddSupplierController"
	})

	.state('viewSupplier',{

			url:"/Supplier/ViewSuppliers",
			templateUrl:"html/ViewSuppliers.html",
			controller:"ViewSuppliersController"
	})
	.state('addClient',{

			url:"/Client/AddClient",
			templateUrl:"html/AddClient.html",
			controller:"AddClientController"
	})

	.state('viewClients',{
			url:"/Client/ViewClient",
			templateUrl:"html/ViewClients.html",
			controller:"ViewClientsController"

	})
	.state('viewClientwiseWorkOrders',{
		url:"/View/ClientWorkorder?clientid",
		templateUrl:"html/ViewWorkorder.html",
		controller:"ViewClientwiseWorkOrdersController"
	})
	.state('addPayment',{
			url:"/Client/addPayment?clientid",
			templateUrl:"html/AddPayment.html",
			controller:"addPaymentController"
	})
	.state('viewInvoices',{
			url:"/Client/viewInvoices?clientid",
			templateUrl:"html/ViewInvoices.html",
			controller:"viewClientInvoiceController"
	})
	.state('createInvoice',{
			url:"/Client/createInvoice?clientid",
			templateUrl:"html/CreateInvoice.html",
			controller:"invoiceController"
	})
	.state('viewSupplierwiseWorkOrders',{
			url:"/View/SupplierWorkorder?supplierid",
			templateUrl:"html/ViewWorkorder.html",
			controller:"ViewSupplierwiseWorkOrdersController"
	})
	.state('createSupplierInvoice',{
			url:"/Supplier/createSupplierInvoice?supplierid",
			templateUrl:"html/CreateInvoice.html",
			controller:"invoiceSupplierController"
	})
	.state('addSupplierPayment',{
		url:"/Supplier/addSupplierPayment?supplierid",
		templateUrl:"html/AddPayment.html",
		controller:"addSupplierPaymentController"
	})
	.state('viewSupplierInvoice',{
			url:"/Supplier/viewInvoices?supplierid",
			templateUrl:"html/ViewInvoices.html",
			controller:"viewSupplierInvoiceController"
	})
	.state("dashboard",{
			url:"/"
	});

	// $locationProvider.html5Mode(true);

});

