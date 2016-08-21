(function() {
	var FilmeDirective = function() {
		return {
			restrict: 'E',
			scope: {
				filme: '=filme'
			},
			templateUrl : 'views/directives/filme.html',
			link: function(scope) {
				scope.assistirFilme = function() {
					$("#assistir-filme").attr('src', scope.filme.linkYoutube + '?autoplay=1&amp;rel=0&amp;controls=0&amp;showinfo=0');
					$('#modal-watch-video').openModal();
				}

				scope.generos = [];
				
				scope.generos[1] = "Ação";
				scope.generos[2] = "Aventura";
				scope.generos[3] = "Comédia";
				scope.generos[4] = "Documentário";
				scope.generos[5] = "Drama";
				scope.generos[6] = "Suspense";
				scope.generos[7] = "Terror";
				scope.generos[1000] = "Outro";				
			}
		};
	}

	angular.module('app').directive('filme', FilmeDirective);
	
})();