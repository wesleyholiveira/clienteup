angular.module('clienteUp').factory('empresasAPI', ['$http', function($http) {
	return {
		getEmpresas: function(empresa) {
			return $http.get('http://localhost/financeiro/app.php/listarGrupos?busca='+ empresa);
		}
	};
}]);
