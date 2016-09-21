angular.module('clienteUp').controller('BuscaController', ['$rootScope', '$filter', '$routeParams', 'jQueryFactory', function($rootScope, $filter, $routeParams, jQueryFactory) {
	
	$rootScope.matches = false;

	var empresas = [
		{
			id: 1,
			nomeEmpresa: 'Maná WEB'
		},
		{
			id: 2,
			nomeEmpresa: 'Savegnago'
		},
		{
			id: 3,
			nomeEmpresa: 'Cojiba'
		},
		{
			id: 4,
			nomeEmpresa: 'Usinas Chemicas'
		},
		{
			id: 5,
			nomeEmpresa: 'Orto Center'
		},
		{
			id: 6,
			nomeEmpresa: 'Docelar Presentes'
		},
		{
			id: 7,
			nomeEmpresa: 'Maran Calçados'
		},
		{
			id: 8,
			nomeEmpresa: 'Manázius'
		}
	];

	if($routeParams.q !== undefined) {
		$rootScope.busca = $routeParams.q;
		$rootScope.hasMatches();
	}

	$rootScope.hasMatches = function() {
		if(($rootScope.busca !== undefined) && $rootScope.busca.length > 3) {
			$rootScope.empresas = $filter('filter')(empresas, $rootScope.busca);
			$rootScope.matches = $rootScope.empresas.length;
		}else if($rootScope.busca === '') $rootScope.matches = false;

		$('html, body').animate({scrollTop: 0}, 500);

	};

	$rootScope.limparBusca = function() {
		$rootScope.busca = '';
		$rootScope.matches = false;
		$rootScope.loader = false;
	};

}]);