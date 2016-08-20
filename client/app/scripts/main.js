(function () {
  var config = function ($sceDelegateProvider) {
    $sceDelegateProvider.resourceUrlWhitelist(
      [
        'self',
        'https://www.youtube.com/**' 
        // '^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$'
      ]
    );
  }
  
  config.$inject = [ "$sceDelegateProvider" ];

  angular.module('app', ['ngRoute', 'ngResource'])
    .config(config);

  angular.element(document).ready(function () {
    angular.bootstrap(document, ['app']);
  });
})();