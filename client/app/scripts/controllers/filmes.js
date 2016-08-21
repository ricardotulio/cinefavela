(function() {
	var FilmesController = function($rootScope, $scope, $routeParams, Filme) {
		$rootScope.usuarioLogado = localStorage.getItem('token_acesso') != undefined;

		$scope.tentouInscreverFilme = false;
		$scope.carregandoVideo = false;
		$rootScope.filmes = [];

		$scope.generos = [];
		
		$scope.generos[1] = "Ação";
		$scope.generos[2] = "Aventura";
		$scope.generos[3] = "Comédia";
		$scope.generos[4] = "Documentário";
		$scope.generos[5] = "Drama";
		$scope.generos[6] = "Suspense";
		$scope.generos[7] = "Terror";
		$scope.generos[1000] = "Outro";

		Filme.get(function(response) {
			$rootScope.filmes = response.data;
		});

		$scope.abrirFormularioInscricao = function() {
			var tokenAcesso = localStorage.getItem("token_acesso");
			
			if(tokenAcesso == null) {
				$scope.tentouInscreverFilme = true;
				$scope.abrirFormularioLogin();
			} else {
				$("#modal-inscrever-filme").openModal();
			}
		}

		$scope.abrirFormularioLogin = function() {
			$("#modal-login").openModal();
		}

		$scope.abrirFormularioCadastro = function() {
			$("#modal-cadastro").openModal();
		}

		$scope.cadastrarSe = function() {
			$scope.abrirFormularioCadastro();
			$('#modal-cadastro').openModal();
		}

		$scope.fechaAssistirFilme = function() {
			$("#assistir-filme").attr('src', '');
			$('#modal-watch-video').closeModal();	
		}

		if($routeParams.cadastrarSe == 1 && localStorage.getItem('token_acesso') == undefined) {
			$scope.abrirFormularioCadastro();
		}

		$scope.logout = function() {
			var tokenAcesso = localStorage.removeItem("token_acesso");
			location.reload();
		}
	}

	FilmesController.$inject = [ '$rootScope', '$scope', '$routeParams', 'Filme' ];

	angular.module('app').controller('FilmesController', FilmesController);
})();