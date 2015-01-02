var domains = angular.module('domains', ['ngRoute', 'domainsList']);

domains.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/domains', {
        templateUrl: '/action/domains/get_template_list',
        controller: 'GetList'
      }).
      otherwise({
        redirectTo: '/domains'
      });
  }]);

