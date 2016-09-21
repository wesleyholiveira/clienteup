angular.module('clienteUp').factory('clienteAPI', ['$http', 'paths', function($http, paths) {
	
	const url = paths.apiURL;
	return {
		cadastrar: function(dados) {
			return $http.post(url + '/cliente', dados);
		},
		autenticar: function(dados) {
			return $http.post(url + '/cliente/login', dados);
		},
		cadastrarPesquisa: function(dados) {
			return $http.post(url + '/cliente/pesquisa', dados);
		},
		cadastrarPosVenda: function(dados) {
			return $http.post(url + '/cliente/pos-venda', dados);
		}
	};

}]);