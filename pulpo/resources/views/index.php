<!DOCTYPE html>
<html ng-app="pulpo" >
    <head>
        <title>Pulpo</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular-material/1.1.3/angular-material.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular-animate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular-aria.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular-messages.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-material/1.1.3/angular-material.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-simple-logger/0.1.7/angular-simple-logger.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-google-maps/2.4.1/angular-google-maps.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.7.2/socket.io.min.js"></script>

        <script src="js/main.js"></script>
        <style>
          .angular-google-map-container { height: 500px;}
        </style>
    </head>
    <body>
      <div ng-controller="controlador as ctrl">
        <md-switch ng-model="interruptor" ng-change="ctrl.onChange(interruptor)">
          Switch: {{ctrl.message}}
        </md-switch>
        <ui-gmap-google-map center="ctrl.map.center" zoom="ctrl.map.zoom" options="ctrl.map.options">
          <ui-gmap-marker coords="ctrl.marker.coords" options="ctrl.marker.options" idkey="ctrl.marker.id">
          </ui-gmap-marker>
        </ui-gmap-google-map>
      </div>
    </body>
</html>
