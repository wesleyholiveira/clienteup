angular.module('clienteUp').controller('CadastrarController', ['$rootScope', '$scope', '$location', '$timeout', '$filter', 'jQueryFactory', 'clienteAPI', 'cepAPI', function($rootScope, $scope, $location, $timeout, $filter, jQueryFactory, clienteAPI, cepAPI) {

	var storage = $rootScope.storage;
	$scope.status = undefined;
	$('[name^="CPF"]').mask('000.000.000-00');
	$('[name^="CEP"]').mask('00000-000');
	$('[name^="telefone"]').mask('(00) 0000-0000D', {
		translation: {
			'D': {
				pattern: /[0-9]/,
				optional: true
			}
		}
	});

	$scope.buscarCEP = function(cep) {
		cep = $filter('sanitize')(cep);
		cepAPI.getInfos(cep).then(function(response) {
			var resposta = response.data;
			if(resposta.error !== true) {
				$scope.cadastro.cidade = resposta.localidade;
				$scope.cadastro.endereco = resposta.logradouro;
			}else {
				$scope.status = false;
				$scope.mensagem = 'CEP não encontrado.';
			}
		});
	};

	$scope.cadastrar = function() {
		clienteAPI.cadastrar($scope.cadastro)
		.then(function(response) {

			$scope.status = true;
			$scope.mensagem = 'Cliente cadastrado com sucesso!';

			clienteAPI.autenticar($scope.cadastro)
			.then(function(response) {

				var token = response.data.mensagem;
				storage.setItem('acessoToken', token);
				
				$timeout(function() {

					if(!token) {
						$location.path('/sem-autorizacao');
						return false;
					}

					$location.path('/cliente/pesquisa');

				}, 1000);

			});

		}, function(response) {
			$scope.status = false;
			$scope.mensagem = response;
		});

		$('html, body').animate({scrollTop: 0}, 500);
		
	};

}]);