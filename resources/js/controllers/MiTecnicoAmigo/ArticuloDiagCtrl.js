angular.module('ArticuloDiagCtrl', [])
    .controller('ArticuloDiagCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Articulo',
        function($scope, $rootScope, $http, $injector, $mdDialog, Articulo) {

            //console.info('ArticuloDiagCtrl');
            var Ctrl = $scope;
            var Rs = $rootScope;

            Ctrl.Salir = $mdDialog.cancel;
            Ctrl.Articulo = Articulo;

        }
    ]);