angular.module('clienteUp').controller('LoginController', ['$rootScope', '$scope', '$location', 'clienteAPI', function($rootScope, $scope, $location, clienteAPI) {
	
	var storage = sessionStorage;
	$scope.status = undefined;

	if($rootScope.logado === true)
		$location.path('/cliente/meus-pontos');

	$scope.enviar = function() {
		
		clienteAPI.autenticar($scope.login)
		.then(function(response) {

			$scope.status = undefined;

			var token = response.data.mensagem;
			var dadosCliente = response.data.cliente;

			storage.setItem('acessoToken', token);
			storage.setItem('dadosCliente', dadosCliente);

			$rootScope.logado = true;
			$rootScope.cliente = JSON.parse(dadosCliente);
			$rootScope.cliente.senha = '';
			$location.path('/cliente/meus-pontos');

		}, function(response) {

			$scope.status = false;
			$rootScope.logado = false;
			$scope.mensagem = response;
			
		});
	};

}]);