angular.module('clienteUp').factory('cupomAPI', ['$http', 'paths', function($http, paths) {
	
	const url = paths.apiURL;
	return {
		listar: function() {
			return $http.get(url + '/cupom', {cache: true});
		}
	};

}]);