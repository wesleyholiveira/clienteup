angular.module('clienteUp').config(['$httpProvider', function($httpProvider) {

	$httpProvider.interceptors.push('loaderInterceptor');

}]);