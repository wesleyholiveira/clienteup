angular.module('clienteUp').factory('loaderInterceptor', ['$q', '$rootScope', '$httpParamSerializer', '$location', function($q, $rootScope, $httpParamSerializer, $location) {
	return {
		request: function(config) {
	
			if(config.url.indexOf('clienteup') > 0) {
				var pattern = /[cliente|empresa]/;
				var path = $location.path();
				path = path.split('/');

				var pathSize = path.length;
				var recurso = path[pathSize - 2];
				var subRecurso = path[pathSize - 1];

				if(recurso !== undefined) {
					if(pattern.test(recurso) && (subRecurso !== 'login' && subRecurso !== '')) {
						config.headers['X-Authorization'] = sessionStorage.getItem('acessoToken');
					}
				}
			}

			if(config.method === 'POST') {
				config.headers['Content-Type'] = 'application/x-www-form-urlencoded';
				config.transformRequest = function(data) {
					return $httpParamSerializer(data);
				};
			}
	
			$rootScope.loader = true;
			return config;
		},
		requestError: function(rejection) {
			return $q.reject(rejection);
		},
		response: function(response) {
			$rootScope.loader = false;
			return response;
		},
		responseError: function(rejection) {
			$rootScope.loader = false;

			if(rejection.status === 403)
				$location.path('/sem-autorizacao');
			
			if(rejection.status === 404)
				$location.path('/404');

			return $q.reject('Ocorreu um erro: ' + rejection.data.mensagem + ' [' + rejection.status + ']');
		}
	};
}]);