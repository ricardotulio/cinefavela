(function () {
  var config = function ($httpProvider, $sceDelegateProvider) {
    var tokenAcesso = localStorage.getItem('token_acesso');

    delete $httpProvider.defaults.headers.common['X-Requested-With'];

    $httpProvider.defaults.headers.common['Accept'] = 'application/json, text/javascript';
    $httpProvider.defaults.headers.common['Content-Type'] = 'application/json; charset=utf-8';
    $httpProvider.defaults.headers.common['Pragma'] = 'no-cache';

    if(tokenAcesso != undefined)
      $httpProvider.defaults.headers.common['Authorization'] = tokenAcesso;

    $httpProvider.defaults.useXDomain = true;

    $sceDelegateProvider.resourceUrlWhitelist(
      [
        'self',
        'https://www.youtube.com/**' 
        // '^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$'
      ]
    );
  }
  
  config.$inject = [ '$httpProvider', '$sceDelegateProvider' ];

  angular.module('app', ['ngRoute', 'ngResource', 'ngPassword', 'ui.materialize'])
    .config(config);

  angular.element(document).ready(function () {
    angular.bootstrap(document, ['app']);
  });
})();