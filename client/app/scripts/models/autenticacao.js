(function() {
	var Autenticacao = function($http) {
		return {
			autentica: function(usuario) {
				return $http.post('http://localhost:9000/v1/autenticacao', usuario);
			}
		}
	}

	Autenticacao.$inject = [ '$http' ];

	angular.module('app').factory('Autenticacao', Autenticacao);
})();