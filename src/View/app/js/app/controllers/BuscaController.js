angular.module('clienteUp').controller('BuscaController', ['$scope', '$filter', 'empresasAPI', function($scope, $filter, empresasAPI) {
	$scope.matches = false;
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
		}
	];

	$scope.hasMatches = function() {
		if(($scope.busca !== undefined) && $scope.busca.length > 3) {
			$scope.empresas = $filter('filter')(empresas, $scope.busca);
			$scope.matches = $scope.empresas.length;

			// empresasAPI.getEmpresas($scope.busca.toUpperCase())
			// .success(function(data) {
			// 	$scope.empresas = $filter('filter')(data.grupo, $scope.busca);
			// 	$scope.matches = $scope.empresas.length;
			// });
		}else if($scope.busca === '') $scope.matches = false;
	};

	$scope.limparBusca = function() {
		$scope.busca = '';
		$scope.matches = false;
	};

}]);