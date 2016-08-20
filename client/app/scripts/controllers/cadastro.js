(function() {
	var CadastroController = function($scope, Usuario) {
		$scope.cadastrar = function(novoUsuario) {
			var usuario = new Usuario(novoUsuario);
			usuario.$save();
		}
	};

	CadastroController.$inject = [ '$scope', 'Usuario' ];

	angular.module('app').controller('CadastroController', CadastroController);
})();