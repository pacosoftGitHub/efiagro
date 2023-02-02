angular.module('App', [

    'ui.router',

    'ngStorage',
    'ngMaterial',
    'ngSanitize',

    'md.data.table',

    'ngFileUpload',
    //'angular-loading-bar',
    //'angularResizable',
    'nvd3',
    'ui.utils.masks',
    //'as.sortable',
    //'ngCsv',
    'angular-img-cropper',
    //'indexedDB',
    'enterStroke',
    'printThis',
    'textAngular',
    'SeccionCtrl',
    
    'CRUD',
    'CRUDDialogCtrl',
    'ConfirmDeleteCtrl',
    'ImageEditor_DialogCtrl',
    'BasicDialogCtrl',
    'Filters',

    'appRoutes',
    'appConfig',
    'appFunctions',

    'LoginCtrl',
    'MainCtrl',
    'HomeCtrl',

    'MiTecnicoAmigoCtrl',
    'ArticuloDiagCtrl',
    'SolicitudesDetalleCtrl',

    'UsuariosCtrl',
    'UsuariosOperadorCtrl',
    'UsuarioFincaCtrl', // Luigi
    'UsuariosImportarCtrl',
    'UsuarioOrganizacionCtrl', // Luigi
    'UsuarioLaboresCtrl', // Luigi
    'ArticulosCtrl',
    'Articulos_ArticuloEditorCtrl',
    'CasosCtrl', // Luigi
    'Casos_NovedadesCtrl', // Luigi
    'LineasProductivasCtrl', // Luigi
    //'MitecnicoAmigoInicioCtrl', // Luigi

    //Inicio Dev Angélica
    'ContactoCtrl',
    'ArticulomuroEditDialogCtrl',
    'ConfiguracionCtrl',
    'ListaEditDialogCtrl',
    'LotesFincaCtrl',
    'FincasMifincaCtrl',
    //Fin Dev Angélica

    'OrganizacionesCtrl',
    'OrganizacionDiagCtrl',
    'CultivosCtrl',
    'FincasCtrl',
    'FincaDiagCtrl',
    'PerfilesCtrl', // Luigi
    'EventosCtrl',
    'FincaEventosCtrl',

    // 'PerfilesCtrl',
    // Zonas Agroambientales
    'ZonasCtrl',
    'Zonas_ZonaEditorCtrl',
    'LaboresCtrl',
    'LaboresDiagCtrl',
    'LotesCtrl',
    'LoteDiagCtrl',
    'Labores_LaborEditorCtrl',

    'FondoRotatorio_CreditosCtrl', //CAOH
    'FondoRotatorio_NuevoCreditoDiagCtrl', //CAOH
    'FondoRotatorio_Creditos_PayDialogCtrl', //CAOH
    'FondoRotatorio__Creditos_CreditoDialogCtrl', //CAOH
    'FondoRotatorio__Creditos_ReciboDialogCtrl', //CAOH
    'CreditoSrv', //CAOH
    'OpcionesCtrl',
    'FondoRotatorio_ListadoCtrl', //CAOH
    'FondoRotatorio_MisCreditosCtrl', //CAOH
    'FondoRotatorio__EstadisticasCtrl', //CAOH
    'FondoRotatorio_ConfiguracionCtrl', //JCMR

    'Estadisticas__Data_RemarkCtrl',
    'Estadisticas__Chart_ColCtrl',
    'Estadisticas__Chart_BarCtrl',
    'Estadisticas__Chart_PieCtrl',
    'Estadisticas__Table_BasicCtrl',
    'Estadisticas__Table_WithSubtablesCtrl',
    'Estadisticas_RepDialogCtrl',

    //Controladores para la Seccion Logistica y Coemrcial
    'FichasTecnicasCtrl',
    'NuevaFichaTecnicaCtrl',
    'ClientesCtrl',

]);