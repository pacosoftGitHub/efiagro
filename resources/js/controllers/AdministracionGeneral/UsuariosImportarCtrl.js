angular.module('UsuariosImportarCtrl', [])
    .controller('UsuariosImportarCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'usuarios',
        function($scope, $rootScope, $http, $injector, $mdDialog, usuarios) {

            var Ctrl = $scope;
            var Rs = $rootScope;

            Ctrl.UsuariosImportar = usuarios.data;
            console.log(Ctrl.UsuariosImportar);


            $scope.hide = function () {
                $mdDialog.hide();
            };
          
            $scope.cancel = function () {
                $mdDialog.cancel();
            };
          
            $scope.answer = function (answer) {
                $mdDialog.hide(answer);
            };

        }

    ]);
