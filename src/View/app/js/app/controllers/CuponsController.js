angular.module('clienteUp').controller('CuponsController', ['$scope', 'cupomAPI', 'paths', function($scope, cupomAPI, paths) {
	
	const imgDiretorio = paths.img + '/dist';

	cupomAPI.listar().then(function(retorno) {
		$scope.cupons = retorno.data;
	}, function(err) {
		console.log(err);
	});

}]);