<!doctype html>
<html lang="es" ng-app="App" ngs-strict-di>

	<head>
		<meta charset="UTF-8">
		<title>{{ env('APP_NAME') }}</title>
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimal-ui">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">

		<link   rel="stylesheet"              		href="/css/libs.min.css?202010051927" />
		<link   rel="stylesheet"              		href="/css/app.min.css?202010051927" />
		

		<script type="application/javascript" src="/js/libs.min.js"></script>
		<script defer type="application/javascript" src="/js/app.min.js?202010051927"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjjB89k3h2YU7w4NTNQ6euTDtuQ8IeH7g"></script>
		<script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script>
		{{-- Geli --}}
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/danialfarid-angular-file-upload/12.2.13/ng-file-upload.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/xlsx.full.min.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js"></script>
		<script>
			$(document).ready(function(){
			  //$('[data-toggle="popover"]').popover();
			});
			</script>
	</head>

	<body layout ui-view></body>
	
</html>