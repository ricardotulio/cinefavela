(function() {
	var InscreverFilmeController = function($rootScope, $scope, Filme) {		
		$scope.obtemIdVideoYouTube = function (videoUrl, callback, errorback) {
			var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
			var match = videoUrl.match(regExp);
			if (match && match[7].length == 11) {
				callback(match[7]);
			} else {
				errorback(null);
			}
		}

		$scope.exibePreVisualizacao = function () {
			$(".modal-content").animate({scrollTop: $(".modal-content").height() + 100}, 1000);

			$scope.carregandoVideo = true;
			$scope.exibirVideo = false;

			$scope.obtemIdVideoYouTube($scope.filme.linkYoutube, function (id) {
				$scope.filme.capa = 'http://img.youtube.com/vi/' + id + '/default.jpg';
				$scope.filme.linkYoutube = "https://www.youtube.com/embed/" + id;
				$scope.carregandoVideo = false;
				$scope.exibirVideo = true;
				$scope.linkYoutubeValido = true;

				setTimeout(function() {
					$(".modal-content").animate({scrollTop: $(".modal-content").height() + 500}, 1000);
				}, 1500)
			}, function() {
				$scope.linkYoutubeValido = false;
			});
		}

		$scope.inscrever = function() {
			$('#modal-inscrever-filme .modal-content').hide();
			$('#modal-inscrever-filme .modal-content.loading').css('display', 'flex');

			var filme = new Filme(angular.copy($scope.filme));

			console.log($scope.filme);

			filme.$save(function(filme, response) {
				$rootScope.filmes.unshift(filme.data);
				$scope.filme = {};
				$('#modal-inscrever-filme').closeModal();
				$(".modal-content").animate({scrollTop: 0}, 500);
			}, function() {
				
			});

			$('#modal-inscrever-filme .modal-content.loading').css('display', 'none');
			$('#modal-inscrever-filme .modal-content').show();
		}		

	}

	InscreverFilmeController.$inject = [ '$rootScope', '$scope', 'Filme' ];

	angular.module('app').controller('InscreverFilmeController', InscreverFilmeController);
})()