angular
  .module('SeccionCtrl', [])
  .controller('SeccionCtrl', function ($scope, $mdSidenav) {
    $scope.toggleSidenav = buildToggler('closeEventsDisabled');

    function buildToggler(componentId) {
      return function() {
        $mdSidenav(componentId).toggle();
      };
    }
  });