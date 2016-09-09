angular.module('clienteUp').filter('sanitize', function() {
	
	return function(input) {
		return input.replace(/\D/g, '');
	};

});