const mix = require('laravel-mix');
const libs = false;

if(libs){

	mix.styles([
    	'resources/css/*.css',
    ], 'public/css/libs.min.css')

	mix.scripts([

		'resources/js/libs/jquery.min.js',
		'resources/js/libs/angular.min.js',
		'resources/js/libs/angular-material.min.js',
		
		'resources/js/libs/jquery_plugins/*.js',
		'resources/js/libs/nvd3/*.js',
		'resources/js/libs/angular_modules/*.js',
	    
	    'resources/js/libs/other/moment.min.js',
	    'resources/js/libs/other/moment_es.js',
	    'resources/js/libs/other/xlsx.mini.min.js',
	    'resources/js/libs/other/jsstore.js',

	], 'public/js/libs.min.js');
	
};

mix.sass('resources/sass/app.scss', 'public/css/app.min.css');

mix.scripts([

	'resources/js/*.js',

	'resources/js/controllers/**/*.js',
	'resources/js/services/**/*.js',
	'resources/js/filters/**/*.js',
	'resources/js/directives/**/*.js',

], 'public/js/app.min.js');

