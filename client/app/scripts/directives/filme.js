(function() {
	var FilmeDirective = function() {
		return {
			restrict: 'E',
			scope: {
				filme: '=filme'
			},
			templateUrl : 'views/directives/filme.html'
		};
	}

	angular.module('app').directive('filme', FilmeDirective);
	
})();