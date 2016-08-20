(function() {
  var routes = function($routeProvider) {
    $routeProvider.when('/', {
      templateUrl: 'views/home.html',
      controller: 'HomeController'
    })
    .when('/festival', {
      templateUrl: 'views/filmes.html',
      controller: 'FilmesController'
    });
  }
  
  routes.$inject = [ '$routeProvider' ];
  
  angular.module('app').config(routes);
})();