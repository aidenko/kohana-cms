var domainsList = angular.module('domainsList', ['checklist-model']);

domainsList.controller('GetList', ['$scope', '$http',
	function ($scope, $http) {
    
		$scope.user = {
			domains: ['camp']			
		};
		
		$http.post('/action/domains')
			.success(function(data) {
				$scope.domains = data.domain;
				$scope.currency = data.currency;
    	});

    $scope.orderProp = 'sdo_name';
    
    //$scope.user.selected = [];
    
    $scope.checkAvailability = function () {
	    
			var check_name = $scope.check_name;
			
			if(typeof(check_name) != 'undefined')
			{
				//console.log($scope.domains);
				console.log($scope.user.domains);
				
				$http.post('/action/domains/get_is_available', {'name':check_name, 'domains': $scope.user.domains})
				.success(function(data) {
					//$scope.domains = data.domain;
					//$scope.currency = data.currency;
	    	});	
			}
			
			
			
	  };
	  
	  $scope.addDomaintoCheck = function(checkbox)
	  {
	  	
	  };
  }]);