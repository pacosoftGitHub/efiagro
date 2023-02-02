<div flex layout=column>

    <md-button class="md-icon-button abs no-margin s30 no-padding" style="top: 8px;left: 0;" href="#/Home">
        <md-icon md-font-icon="fa-chevron-left fa-lg fa-fw text-primary"></md-icon>
    </md-button>
    <div layout class="bg-primary md-short" md-theme="Transparent"
        ng-show="Secciones[Estado.ruta[2]].length > 1 && Secciones[Estado.ruta[2]][0].navegacion == 'superior'">
        <md-tabs flex>
            <md-tab ng-repeat="S in Secciones[Estado.ruta[2]]" label="@{{S . texto == NULL ?  S . subseccion : S . texto  }}"
                md-active="(S.subseccion_slug == Estado.ruta[3])"
                ng-click="navegarSubseccion(S.seccion_slug, S.subseccion_slug)"></md-tab>
        </md-tabs>
    </div>
    {{-- <div flex layout>
        <md-sidenav md-is-locked-open="true" class="w200 overflow-y"
            ng-show="Secciones[Estado.ruta[2]].length > 1 && Secciones[Estado.ruta[2]][0].navegacion == 'izquierda'"
            md-whiteframe=2 layout=column>
            <div ng-repeat="grupo in ['ORGANIZACIÓN', 'CONFIGURACIÓN','FINCA', 'LOTE', ]">
                <md-subheader>@{{ grupo }}</md-subheader>
                <div ng-repeat="S in Secciones[Estado.ruta[2]] | filter:{grupo:grupo}:true" class="Pointer padding-5-10"
                    ng-class="{ 'text-bold bg-light-grey': (S.subseccion_slug == Estado.ruta[3]) }"
                    ng-click="navegarSubseccion(S.seccion_slug, S.subseccion_slug)">
                    @{{ S . subseccion }}
                </div>
            </div>
        </md-sidenav>
        <div id="Subseccion" flex layout ui-view></div>
    </div> --}}

    {{--  --}}
    <div layout="row" ng-controller="SeccionCtrl" >

        <div ng-show="Secciones[Estado.ruta[2]].length > 1 && Secciones[Estado.ruta[2]][0].navegacion == 'izquierda'">

            <md-sidenav class="md-sidenav-left" style="width: 230px; top: 40px;" md-component-id="closeEventsDisabled"
                md-whiteframe="4">
                <md-toolbar class="md-theme-indigo">
                    <h1 ng-click="toggleSidenav()" class="md-toolbar-tools ">Administración</h1>
                </md-toolbar>
                <md-content layout-margin="">
                    <p ng-show="Secciones[Estado.ruta[2]].length > 1 && Secciones[Estado.ruta[2]][0].navegacion == 'izquierda'"
                        md-whiteframe=2 layout=column>
                    <div ng-repeat="grupo in ['ORGANIZACIÓN', 'CONFIGURACIÓN','FINCA', 'LOTE', ]" class="no-margin">
                        <md-subheader>@{{ grupo }}</md-subheader>
                        <div ng-repeat="S in Secciones[Estado.ruta[2]] | filter:{grupo:grupo}:true"
                            class="Pointer padding-1-5"
                            ng-class="{ 'text-bold bg-light-grey': (S.subseccion_slug == Estado.ruta[3]) }"
                            ng-click="navegarSubseccion(S.seccion_slug, S.subseccion_slug)">
                            @{{ S . subseccion }}
                        </div>
                    </div>
                    </p>
                </md-content>

            </md-sidenav>
            <div>
                <md-button ng-click="toggleSidenav()" class="md-raised md-primary">
                    Menú <i class="fas fa-bars"></i>
                </md-button>
            </div>
        </div>
        <div id="Subseccion" flex layout ui-view></div>
    </div>
    {{--  --}}

</div>
