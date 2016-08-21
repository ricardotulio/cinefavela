(function() {
  var HomeController = function($scope) {
  	$scope.enviarMensagem = function() {
  		$("section#contato .formulario").toggleClass('hide');
  		$("section#contato .loading").toggleClass('hide');

  		setTimeout(function() {
  			$("section#contato .loading").toggleClass('hide');
  			$("section#contato .mensagem-enviada").toggleClass('hide');
  		}, 1000);
  	}
  }
  
  HomeController.$inject = [ '$scope' ];
  
  angular.module('app').controller('HomeController', HomeController);
})();