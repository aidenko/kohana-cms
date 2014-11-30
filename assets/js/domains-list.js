var domainsList = angular.module('domainsList', []);

domainsList.controller('GetList', ['$scope', '$http',
  function ($scope, $http) {
    $http.post('/action/domains').success(function(data) {
			$scope.domains = data.domain;
			$scope.currency = data.currency;
    });

    $scope.orderProp = 'sdo_name';
  }]);