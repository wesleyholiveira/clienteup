angular.module('clienteUp').config(['$routeProvider', '$locationProvider', 'paths', function($routeProvider, $locationProvider, paths) {

	// $locationProvider.html5Mode({enabled: true,requireBase: true});
	const templates = paths.templates + '/dist/';

	$routeProvider
		.when('/', {
			templateUrl: templates + 'index.html'
		}).when('/busca', {
			templateUrl: templates + 'index.html',
			controller: 'BuscaController'
		}).when('/como-funciona', {
			templateUrl: templates + 'como-funciona.html'
		}).when('/cliente/meus-pontos', {
			templateUrl: templates + 'meus-pontos.html'
		}).when('/cliente/cadastrar', {
			templateUrl: templates + 'cadastrar.html'
		}).when('/cliente/login', {
			templateUrl: templates + 'login.html'
		}).when('/cliente/pesquisa', {
			templateUrl: templates + 'pesquisa.html',
		}).when('/cliente/pos-venda', {
			templateUrl: templates + 'pos-venda.html'
		}).when('/termos-de-uso', {
			templateUrl: templates + 'termos-uso.html'
		}).when('/brindes', {
			templateUrl: templates + 'brindes.html'
		}).when('/vale-presente', {
			templateUrl: templates + 'vale-presente.html'
		}).when('/sobre-nos', {
			templateUrl: templates + 'sobre-nos.html'
		}).when('/imprensa', {
			templateUrl: templates + 'imprensa.html'
		}).when('/sem-autorizacao', {
			templateUrl: templates + 'sem-autorizacao.html'
		}).when('/404', {
			templateUrl: templates + '404.html'
		}).otherwise({redirectTo: '/404'});

}]);