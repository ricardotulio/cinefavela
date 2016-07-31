(function() {
    angular.module("myApp", [ "ngRoute" ]);
    
    angular.element(document).ready(function() {
      angular.bootstrap(document, ['myApp']);
    });
})();