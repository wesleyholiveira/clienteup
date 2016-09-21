angular.module('clienteUp').factory('jQueryFactory', ['$window', function($window) {
	return $window.$;
}]);