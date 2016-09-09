angular.module('clienteUp').controller('AutenticacaoClienteController', ['$rootScope', '$scope', '$location', function($rootScope, $scope, $location) {
	
	if($rootScope.logado === false)
		$location.path('/sem-autorizacao');

}]);