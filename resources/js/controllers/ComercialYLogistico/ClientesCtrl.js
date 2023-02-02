angular.module('ClientesCtrl', [])
    .controller('ClientesCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog',
        function($scope, $rootScope, $http, $injector, $mdDialog) {

            var Ctrl = $scope;
            var Rs = $rootScope;

            Ctrl.filterDocumento = "";
            Ctrl.filterNombre = "";
            Ctrl.filterApellido = "";

            $scope.fichas;
          
        // function traerFichas(){

        // $http.post('/api/comercialylogistico/fichasorganizacion',{organizacion_id :  Rs.Usuario.organizacion_id})
        //         .then( (r) => {
        //         $scope.fichas = r.data;
        //         console.log("Fichas Tecnicas", $scope.fichas);
        //         });

        // };

        // traerFichas();
            

            
            $scope.nuevoCliente = function (ev) {
                $mdDialog.show({
                  //controller: 'NuevoClienteCtrl',
                  templateUrl: 'Frag/ComercialYLogistico.AdicionarClienteDiag',
                  // Appending dialog to document.body to cover sidenav in docs app
                  // Modal dialogs should fully cover application to prevent interaction outside of dialog
                  parent: angular.element(document.body),
                  targetEvent: ev,
                  clickOutsideToClose: true,
                  fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
                }).then(function (answer) {
                  $scope.status = 'You said the information was "' + answer + '".';
                }, function () {
                  $scope.status = 'You cancelled the dialog.';
                });
            };



              //Funciones para las ventanas de los dialogos
              function DialogController($scope, $mdDialog) {

                //Funcion para ocultar
                $scope.hide = function () {
                  $mdDialog.hide();
                };
                
                //Funcion para cancelar
                $scope.cancel = function () {
                  $mdDialog.cancel();
                };
              }


        }

    ]);
