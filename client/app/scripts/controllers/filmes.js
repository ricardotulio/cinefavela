(function() {
	var FilmesController = function($scope) {
		
		$scope.carregandoVideo = false;
		$scope.filmes = [];

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

	 	$scope.inscreverFilme = function (filme) {
	      $scope.obtemIdVideoYouTube(filme.video_url, function (id) {
	        filme.thumbnail = "https://i.ytimg.com/vi/" + id + "/hqdefault.jpg";
	        filme.usuario.avatar = "http://4.bp.blogspot.com/-j4dl9EFp56k/VZGfHo4q4jI/AAAAAAAAChw/BtWkmYFkd6U/s1600/anonimo.png";
	        $scope.filmes.push(filme);
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
	}

	FilmesController.$inject = [ '$scope' ];

	angular.module('app').controller('FilmesController', FilmesController);
})();