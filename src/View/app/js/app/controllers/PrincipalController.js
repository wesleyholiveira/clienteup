angular.module('clienteUp').controller('PrincipalController', ['$rootScope', '$scope', '$location', 'jQueryFactory', function($rootScope, $scope, $location, jQueryFactory) {
	
	var padrao = 'Carregando...';
	$rootScope.logado = sessionStorage.getItem('acessoToken') || false;
	$rootScope.cliente = sessionStorage.getItem('dadosCliente') || false;

	if($rootScope.cliente !== false) {
		$rootScope.cliente = JSON.parse($rootScope.cliente);
		$rootScope.cliente.senha = '';
	}

	$rootScope.loading = padrao;

	$scope.topo = function() {
		$('html, body').animate({scrollTop: 0}, 500);
	};

	$scope.limparLoader = function() {
		$rootScope.loading = padrao;
		$rootScope.loader = false;
	};

	$scope.sair = function() {
		sessionStorage.setItem('acessoToken', '');
		$rootScope.logado = false;
		$rootScope.cliente = false;
		$location.path('/');
	};

}]);