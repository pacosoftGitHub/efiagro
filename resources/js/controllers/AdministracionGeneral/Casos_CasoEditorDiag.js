angular.module('Casos_CasoEditorCtrl', [])
    .controller('Casos_CasoEditorCtrl', ['$scope', '$rootScope', '$http', '$injector', '$mdDialog', 'Articulo',
        function($scope, $rootScope, $http, $injector, $mdDialog, Articulo) {

            var Ctrl = $scope;
            var Rs = $rootScope;

            Ctrl.Cancel = $mdDialog.cancel;

            Ctrl.Caso = angular.copy(Caso);

            Ctrl.NovedadesCRUD = $injector.get('CRUD').config({
                base_url: '/api/casos/Novedades',
                limit: 1000,
                add_append: 'refresh',
            });

            Ctrl.getNovedades = () => {
                Ctrl.NovedadesCRUD.setScope('elcaso', Caso.id).get();
            }
            Ctrl.getCasos();

        }
    ]);