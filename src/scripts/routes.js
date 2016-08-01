(function() {
    var routeConfig = function($routeProvider) {
        $routeProvider.when("/", {
            controller: "IndexController",
            templateUrl: "src/views/index/index.html" 
        });
    };
    
    routeConfig.$inject = [ "$routeProvider" ];
    
    angular.module("myApp").config(routeConfig);
})();