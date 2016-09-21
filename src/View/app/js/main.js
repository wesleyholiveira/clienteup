angular.module('clienteUp', ['ngRoute']);
const root = 'src/View/app';
const baseUrl = window.location.origin;
angular.module('clienteUp').constant('paths', {
	root: root,
	js: root + '/js',
	css: root + '/css',
	img: root + '/img',
	templates: root + '/templates',
	apiURL: 'http://localhost/clienteup/app.php'
});
angular.module('clienteUp').config(['$httpProvider', function($httpProvider) {

	$httpProvider.interceptors.push('loaderInterceptor');

}]);
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
angular.module('clienteUp').controller('AutenticacaoClienteController', ['$rootScope', '$scope', '$location', function($rootScope, $scope, $location) {
	
	if($rootScope.logado === false)
		$location.path('/sem-autorizacao');

}]);
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
angular.module('clienteUp').controller('CadastrarController', ['$rootScope', '$scope', '$location', '$timeout', '$filter', 'jQueryFactory', 'clienteAPI', 'cepAPI', function($rootScope, $scope, $location, $timeout, $filter, jQueryFactory, clienteAPI, cepAPI) {

	var storage = $rootScope.storage;
	$scope.status = undefined;
	$('[name^="CPF"]').mask('000.000.000-00');
	$('[name^="CEP"]').mask('00000-000');
	$('[name^="telefone"]').mask('(00) 0000-0000D', {
		translation: {
			'D': {
				pattern: /[0-9]/,
				optional: true
			}
		}
	});

	$scope.buscarCEP = function(cep) {
		cep = $filter('sanitize')(cep);
		cepAPI.getInfos(cep).then(function(response) {
			var resposta = response.data;
			if(resposta.error !== true) {
				$scope.cadastro.cidade = resposta.localidade;
				$scope.cadastro.endereco = resposta.logradouro;
			}else {
				$scope.status = false;
				$scope.mensagem = 'CEP não encontrado.';
			}
		});
	};

	$scope.cadastrar = function() {
		clienteAPI.cadastrar($scope.cadastro)
		.then(function(response) {

			$scope.status = true;
			$scope.mensagem = 'Cliente cadastrado com sucesso!';

			clienteAPI.autenticar($scope.cadastro)
			.then(function(response) {

				var token = response.data.mensagem;
				storage.setItem('acessoToken', token);
				
				$timeout(function() {

					if(!token) {
						$location.path('/sem-autorizacao');
						return false;
					}

					$location.path('/cliente/pesquisa');

				}, 1000);

			});

		}, function(response) {
			$scope.status = false;
			$scope.mensagem = response;
		});

		$('html, body').animate({scrollTop: 0}, 500);
		
	};

}]);
angular.module('clienteUp').controller('CuponsController', ['$scope', 'cupomAPI', 'paths', function($scope, cupomAPI, paths) {
	
	const imgDiretorio = paths.img + '/dist';

	cupomAPI.listar().then(function(retorno) {
		$scope.cupons = retorno.data;
	}, function(err) {
		console.log(err);
	});

}]);
angular.module('clienteUp').controller('LoginController', ['$rootScope', '$scope', '$location', 'clienteAPI', function($rootScope, $scope, $location, clienteAPI) {
	
	var storage = sessionStorage;
	$scope.status = undefined;

	if($rootScope.logado === true)
		$location.path('/cliente/meus-pontos');

	$scope.enviar = function() {
		
		clienteAPI.autenticar($scope.login)
		.then(function(response) {

			$scope.status = undefined;

			var token = response.data.mensagem;
			var dadosCliente = response.data.cliente;

			storage.setItem('acessoToken', token);
			storage.setItem('dadosCliente', dadosCliente);

			$rootScope.logado = true;
			$rootScope.cliente = JSON.parse(dadosCliente);
			$rootScope.cliente.senha = '';
			$location.path('/cliente/meus-pontos');

		}, function(response) {

			$scope.status = false;
			$rootScope.logado = false;
			$scope.mensagem = response;
			
		});
	};

}]);
angular.module('clienteUp').controller('MeusPontosController', ['$scope', function($scope) {

	$scope.meusPontos = [];
	
}]);
angular.module('clienteUp').controller('PesquisaController', ['$scope', '$timeout', 'clienteAPI', function($scope, $timeout, clienteAPI) {
	
	$scope.enviar = function() {
		clienteAPI.cadastrarPesquisa($scope.pesquisa)
		.then(function(response) {

			$scope.status = true;
			$scope.mensagem = 'Pesquisa realizada com sucesso!';

		}, function(response) {

			$scope.status = false;
			$scope.mensagem = response;

		});
	}

}]);
angular.module('clienteUp').controller('PosUpController', ['$scope', '$timeout', 'clienteAPI', function($scope, $timeout, clienteAPI) {
	
	$scope.enviar = function() {
		clienteAPI.cadastrarPosVenda($scope.posVenda)
		.then(function(response) {

			$scope.status = true;
			$scope.mensagem = 'Pós Venda realizada com sucesso!';

		}, function(response) {

			$scope.status = false;
			$scope.mensagem = response;

		});
	}

}]);
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
angular.module('clienteUp').filter('sanitize', function() {
	
	return function(input) {
		return input.replace(/\D/g, '');
	};

});
angular.module('clienteUp').factory('jQueryFactory', ['$window', function($window) {
	return $window.$;
}]);
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
angular.module('clienteUp').factory('cepAPI', ['$http', 'paths', function($http, paths) {

	const url = paths.apiURL;
	return {
	
		getInfos: function(cep) {
			return $http.get('https://viacep.com.br/ws/' + cep + '/json/', {cache: true});
		}

	};

}]);
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
angular.module('clienteUp').factory('cupomAPI', ['$http', 'paths', function($http, paths) {
	
	const url = paths.apiURL;
	return {
		listar: function() {
			return $http.get(url + '/cupom', {cache: true});
		}
	};

}]);
/* ========================================================================
 * Bootstrap: collapse.js v3.3.6
 * http://getbootstrap.com/javascript/#collapse
 * ========================================================================
 * Copyright 2011-2015 Twitter, Inc.
 * Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
 * ======================================================================== */


+function ($) {
  'use strict';

  // COLLAPSE PUBLIC CLASS DEFINITION
  // ================================

  var Collapse = function (element, options) {
    this.$element      = $(element)
    this.options       = $.extend({}, Collapse.DEFAULTS, options)
    this.$trigger      = $('[data-toggle="collapse"][href="#' + element.id + '"],' +
                           '[data-toggle="collapse"][data-target="#' + element.id + '"]')
    this.transitioning = null

    if (this.options.parent) {
      this.$parent = this.getParent()
    } else {
      this.addAriaAndCollapsedClass(this.$element, this.$trigger)
    }

    if (this.options.toggle) this.toggle()
  }

  Collapse.VERSION  = '3.3.6'

  Collapse.TRANSITION_DURATION = 350

  Collapse.DEFAULTS = {
    toggle: true
  }

  Collapse.prototype.dimension = function () {
    var hasWidth = this.$element.hasClass('width')
    return hasWidth ? 'width' : 'height'
  }

  Collapse.prototype.show = function () {
    if (this.transitioning || this.$element.hasClass('in')) return

    var activesData
    var actives = this.$parent && this.$parent.children('.panel').children('.in, .collapsing')

    if (actives && actives.length) {
      activesData = actives.data('bs.collapse')
      if (activesData && activesData.transitioning) return
    }

    var startEvent = $.Event('show.bs.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    if (actives && actives.length) {
      Plugin.call(actives, 'hide')
      activesData || actives.data('bs.collapse', null)
    }

    var dimension = this.dimension()

    this.$element
      .removeClass('collapse')
      .addClass('collapsing')[dimension](0)
      .attr('aria-expanded', true)

    this.$trigger
      .removeClass('collapsed')
      .attr('aria-expanded', true)

    this.transitioning = 1

    var complete = function () {
      this.$element
        .removeClass('collapsing')
        .addClass('collapse in')[dimension]('')
      this.transitioning = 0
      this.$element
        .trigger('shown.bs.collapse')
    }

    if (!$.support.transition) return complete.call(this)

    var scrollSize = $.camelCase(['scroll', dimension].join('-'))

    this.$element
      .one('bsTransitionEnd', $.proxy(complete, this))
      .emulateTransitionEnd(Collapse.TRANSITION_DURATION)[dimension](this.$element[0][scrollSize])
  }

  Collapse.prototype.hide = function () {
    if (this.transitioning || !this.$element.hasClass('in')) return

    var startEvent = $.Event('hide.bs.collapse')
    this.$element.trigger(startEvent)
    if (startEvent.isDefaultPrevented()) return

    var dimension = this.dimension()

    this.$element[dimension](this.$element[dimension]())[0].offsetHeight

    this.$element
      .addClass('collapsing')
      .removeClass('collapse in')
      .attr('aria-expanded', false)

    this.$trigger
      .addClass('collapsed')
      .attr('aria-expanded', false)

    this.transitioning = 1

    var complete = function () {
      this.transitioning = 0
      this.$element
        .removeClass('collapsing')
        .addClass('collapse')
        .trigger('hidden.bs.collapse')
    }

    if (!$.support.transition) return complete.call(this)

    this.$element
      [dimension](0)
      .one('bsTransitionEnd', $.proxy(complete, this))
      .emulateTransitionEnd(Collapse.TRANSITION_DURATION)
  }

  Collapse.prototype.toggle = function () {
    this[this.$element.hasClass('in') ? 'hide' : 'show']()
  }

  Collapse.prototype.getParent = function () {
    return $(this.options.parent)
      .find('[data-toggle="collapse"][data-parent="' + this.options.parent + '"]')
      .each($.proxy(function (i, element) {
        var $element = $(element)
        this.addAriaAndCollapsedClass(getTargetFromTrigger($element), $element)
      }, this))
      .end()
  }

  Collapse.prototype.addAriaAndCollapsedClass = function ($element, $trigger) {
    var isOpen = $element.hasClass('in')

    $element.attr('aria-expanded', isOpen)
    $trigger
      .toggleClass('collapsed', !isOpen)
      .attr('aria-expanded', isOpen)
  }

  function getTargetFromTrigger($trigger) {
    var href
    var target = $trigger.attr('data-target')
      || (href = $trigger.attr('href')) && href.replace(/.*(?=#[^\s]+$)/, '') // strip for ie7

    return $(target)
  }


  // COLLAPSE PLUGIN DEFINITION
  // ==========================

  function Plugin(option) {
    return this.each(function () {
      var $this   = $(this)
      var data    = $this.data('bs.collapse')
      var options = $.extend({}, Collapse.DEFAULTS, $this.data(), typeof option == 'object' && option)

      if (!data && options.toggle && /show|hide/.test(option)) options.toggle = false
      if (!data) $this.data('bs.collapse', (data = new Collapse(this, options)))
      if (typeof option == 'string') data[option]()
    })
  }

  var old = $.fn.collapse

  $.fn.collapse             = Plugin
  $.fn.collapse.Constructor = Collapse


  // COLLAPSE NO CONFLICT
  // ====================

  $.fn.collapse.noConflict = function () {
    $.fn.collapse = old
    return this
  }


  // COLLAPSE DATA-API
  // =================

  $(document).on('click.bs.collapse.data-api', '[data-toggle="collapse"]', function (e) {
    var $this   = $(this)

    if (!$this.attr('data-target')) e.preventDefault()

    var $target = getTargetFromTrigger($this)
    var data    = $target.data('bs.collapse')
    var option  = data ? 'toggle' : $this.data()

    Plugin.call($target, option)
  })

}(jQuery);
