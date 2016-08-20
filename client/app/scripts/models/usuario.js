(function() {
	var Usuario = function($resource) {
		return $resource('http://localhost:9000/v1/usuarios/:usuarioId', {usuarioId: '@id'});
	};

	Usuario.$inject = [ '$resource' ];

	angular.module('app').factory('Usuario', Usuario);
})();