angular.module('clienteUp').factory('cepAPI', ['$http', 'paths', function($http, paths) {

	const url = paths.apiURL;
	return {
	
		getInfos: function(cep) {
			return $http.get('https://viacep.com.br/ws/' + cep + '/json/', {cache: true});
		}

	};

}]);