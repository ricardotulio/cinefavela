(function() {
	var Filme = function($resource) {
		return $resource('http://localhost:9000/v1/filmes/:filmeId', {filmeId: '@id'});
	}

	Filme.$inject = [ '$resource' ];

	angular.module('app').factory('Filme', Filme);
})();