(function() {
	var AutenticacaoController = function($rootScope, $scope, Autenticacao, $http) {
		$scope.erroLogin = false;

		$scope.login = function(usuario) {
			$('#modal-login .modal-content').hide();
			$('#modal-login .modal-content.loading').css('display', 'flex');

			Autenticacao.autentica(usuario).then(function(response) {
				localStorage.setItem('token_acesso', response.data.data.token_acesso);
				$http.defaults.headers.common['Authorization'] = response.data.data.token_acesso;

				$('#modal-login').closeModal();
				$('#modal-inscrever-filme').openModal();
				$rootScope.usuarioLogado = true;
			}, function() {
				$('#modal-login .modal-content.loading').css('display', 'none');
				$('#modal-login .modal-content:not(.loading)').show();
				$('#modal-login input').addClass('invalid');
  				$scope.erroLogin = true;		
			});
		}
	}

	AutenticacaoController.$inject = [ '$rootScope', '$scope', 'Autenticacao', '$http' ];

	angular.module('app').controller('AutenticacaoController', AutenticacaoController);
})();