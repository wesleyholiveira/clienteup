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