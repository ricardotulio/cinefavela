(function() {
	var CadastrarUsuarioController = function($scope, Usuario, Autenticacao, $http) {
		$scope.emailJaCadastrado = false;

		$scope.cadastrar = function(novoUsuario) {
			$('#modal-cadastro .modal-content.loading').css('display', 'flex');
			$('#modal-cadastro .modal-content:not(.loading)').hide();

			var usuario = new Usuario(novoUsuario);
			usuario.$save(function(usuario) {
				Autenticacao.autentica(usuario.data).then(function(response) {
					localStorage.setItem('token_acesso', response.data.data.token_acesso);
					$http.defaults.headers.common['Authorization'] = response.data.data.token_acesso;
				});

				$('#modal-cadastro').closeModal();
				$('#modal-inscrever-filme').openModal();
			}, function() {
				$scope.emailJaCadastrado = true;

				$('#modal-cadastro .modal-content.loading').css('display', 'none');
				$('#modal-cadastro .modal-content:not(.loading)').show();
			});
		}
	};

	CadastrarUsuarioController.$inject = [ '$scope', 'Usuario', 'Autenticacao', '$http' ];

	angular.module('app').controller('CadastrarUsuarioController', CadastrarUsuarioController);
})();