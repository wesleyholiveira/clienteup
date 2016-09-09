angular.module('clienteUp').controller('PesquisaController', ['$scope', '$timeout', 'clienteAPI', function($scope, $timeout, clienteAPI) {
	
	$scope.enviar = function() {
		clienteAPI.cadastrarPesquisa($scope.pesquisa)
		.then(function(response) {

			$scope.status = true;
			$scope.mensagem = 'Pesquisa realizada com sucesso!';

		}, function(response) {

			$scope.status = false;
			$scope.mensagem = response;

		});
	}

}]);