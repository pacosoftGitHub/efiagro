angular.module('NuevaFichaTecnicaCtrl', [])
    .controller('NuevaFichaTecnicaCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog',
        function($scope, $rootScope, $http, $injector, $mdDialog) {

            var Ctrl = $scope;
            var Rs = $rootScope;


            $scope.hide = function () {
                $mdDialog.hide();
            };
          
            $scope.cancel = function () {
                $mdDialog.cancel();
            };

        }

    ]);