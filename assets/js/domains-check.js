var domainsCheck = angular.module('domainsCheck', []);

domainsCheck.controller('CheckAvailiability', ['$scope', '$http',
  function ($scope, $http) {
    $http.post('/action/domains/get_is_available', {'domain': 'uawebs.net'})
			.success(function(data) {
				$scope.domains = data.domain;
				$scope.currency = data.currency;
    	});
  }]);