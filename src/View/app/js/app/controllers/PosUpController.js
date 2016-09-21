angular.module('clienteUp').controller('PosUpController', ['$scope', '$timeout', 'clienteAPI', function($scope, $timeout, clienteAPI) {
	
	$scope.enviar = function() {
		clienteAPI.cadastrarPosVenda($scope.posVenda)
		.then(function(response) {

			$scope.status = true;
			$scope.mensagem = 'Pós Venda realizada com sucesso!';

		}, function(response) {

			$scope.status = false;
			$scope.mensagem = response;

		});
	}

}]);