(function() {
	var AutenticacaoController = function($scope, Autenticacao) {
		$scope.login = function(usuario) {
			Autenticacao.autentica(usuario).then(function(response) {
				localStorage.setItem('token_acesso', response.data.data.token_acesso);
			}, function() {
				
			});
		}
	}

	AutenticacaoController.$inject = [ '$scope', 'Autenticacao' ];

	angular.module('app').controller('AutenticacaoController', AutenticacaoController);
})();