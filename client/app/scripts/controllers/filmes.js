(function() {
	var FilmesController = function($rootScope, $scope, $routeParams) {
		$scope.tentouInscreverFilme = false;
		$scope.carregandoVideo = false;
		$scope.filmes = [{
			titulo: "Romeu Most Die",
			sinopse: "asdiughiusadhgiuhasdighiasuhfgiuasdfhiguhasihgiuahfdsiguhaisdfughiuashdgiuhafsiughfiaudghiua", 
			thumbnail: "media/images/avatar.png",
			usuario: {
				nome: "Cristiano de Souza",
				avatar: "media/images/avatar.png"
			}
		},
		{
			titulo: "Romeu Most Die",
			sinopse: "Romeu Most Die, asdiughiusadhgiuhasdighiasuhfgiuasdfhiguhasihgiuahfdsiguhaisdfughiuashdgiuhafsiughfiaudghiua", 
			thumbnail: "media/images/avatar.png",
			usuario: {
				nome: "Cristiano de Souza",
				avatar: "media/images/avatar.png"
			}
		},
		{
			titulo: "Romeu Most Die",
			sinopse: "Romeu Most Die, asdiughiusadhgiuhasdighiasuhfgiuasdfhiguhasihgiuahfdsiguhaisdfughiuashdgiuhafsiughfiaudghiua", 
			thumbnail: "media/images/avatar.png",
			usuario: {
				nome: "Cristiano de Souza",
				avatar: "media/images/avatar.png"
			}
		},
		{
			titulo: "Romeu Most Die",
			sinopse: "Romeu Most Die, asdiughiusadhgiuhasdighiasuhfgiuasdfhiguhasihgiuahfdsiguhaisdfughiuashdgiuhafsiughfiaudghiua", 
			thumbnail: "media/images/avatar.png",
			usuario: {
				nome: "Cristiano de Souza",
				avatar: "media/images/avatar.png"
			}
		}];

		$scope.exibePreVisualizacao = function () {
			$(".modal-content").animate({scrollTop: $(".modal-content").height()+ 100}, 1000);

			$scope.carregandoVideo = true;
			$scope.exibirVideo = false;

			$scope.obtemIdVideoYouTube($scope.filme.video_url, function (id) {
				$scope.filme.video_url = "https://www.youtube.com/embed/" + id;
				$scope.carregandoVideo = false;
				$scope.exibirVideo = true;

				setTimeout(function() {
					$(".modal-content").animate({scrollTop: $(".modal-content").height() + 500}, 1000);
				}, 1500)
			});
		}

		$scope.abrirFormularioInscricao = function() {
			var tokenAcesso = localStorage.getItem("token_acesso");
			
			if(tokenAcesso == null) {
				$scope.tentouInscreverFilme = true;
				$scope.abrirFormularioLogin();
			}else {
				$("#modal-inscrever-filme").openModal();
			}
		}

		$scope.abrirFormularioLogin = function() {
			$("#modal-login").openModal();
		}

		$scope.abrirFormularioCadastro = function() {
			$("#modal-cadastro").openModal();
		}

		$scope.login = function() {
			var tokenAcesso = localStorage.setItem("token_acesso" , "userToker");

			$rootScope.usuario = {
				nome: "ricardo"
			};

			if($scope.tentouInscreverFilme) {
				$('#modal-login').closeModal();
				$scope.abrirFormularioInscricao();
			}
		}

		$rootScope.logout = function() {
			var tokenAcesso = localStorage.removeItem("token_acesso");
			location.reload();
		}

		$scope.cadastrarSe = function() {
			$scope.abrirFormularioCadastro();
			$('#modal-cadastro').openModal();
		}

		$scope.inscreverFilme = function (filme) {
			$scope.obtemIdVideoYouTube(filme.video_url, function (id) {
				filme.capa = "https://i.ytimg.com/vi/" + id + "/hqdefault.jpg";
				filme.usuario = {
					nome: "Ricardão",
					avatar: "media/images/avatar.png"
				};
				$scope.filmes.push(angular.copy(filme));
				$scope.filme = {};
			});
		}

		$scope.obtemIdVideoYouTube = function (videoUrl, callback, errorback) {
			var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
			var match = videoUrl.match(regExp);
			if (match && match[7].length == 11) {
				callback(match[7]);
			} else {
				errorback(null);
			}
		}

		if($routeParams.cadastrarSe == 1) {
			$scope.abrirFormularioCadastro();
		}

	}

	FilmesController.$inject = [ '$rootScope', '$scope', '$routeParams' ];

	angular.module('app').controller('FilmesController', FilmesController);
})();