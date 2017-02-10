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
        <script src="js/servicios.js"></script>
        <script src="js/controlador.js"></script>
        <style>
          .angular-google-map-container { height: 500px;}
        </style>
    </head>
    <body>
      <div ng-controller="controlador as ctrl" ng-cloak layout="column">
        <md-toolbar layout="row" class="md-toolbar-tools">
          <md-button class="md-icon-button" hide-gt-sm ng-click="ctrl.toggleNav()">
            <md-icon md-svg-icon="moto" class="md-accent"></md-icon>
          </md-button>
          <h1>Pulpo</h1>
          <md-button class="md-warn">{{ctrl.message}}</md-button>
        </md-toolbar>
        <div flex layout="row">
          <md-sidenav class="md-whiteframe-4dp" md-is-locked-open="$mdMedia('gt-sm')"
            md-component-id="left" ng-click="app.toggleList()">
            <div layout="column" layout-padding layout-margin layout-fill >
              <md-switch md-invert ng-model="ctrl.interruptor" ng-change="ctrl.onChange(ctrl.interruptor)">
                Encender/Apagar
              </md-switch>
              <md-button class="md-raised md-primary" ng-click="ctrl.nuevo()">Agregar</md-button>
            </div>
          </md-sidenav>
          <md-content flex id="content">
            <ui-gmap-google-map center="ctrl.map.center" zoom="ctrl.map.zoom" options="ctrl.map.options" events="ctrl.map.events">
              <ui-gmap-marker ng-repeat="(key, value) in ctrl.markers" coords="value" idkey="key" click="ctrl.clicMarker(key)">
              </ui-gmap-marker>
              <ui-gmap-polyline ng-repeat="(key, value) in ctrl.rutas" path="value" stroke="ctrl.stroke"></ui-gmap-polyline>
            </ui-gmap-google-map>
          </md-content>
        </div>
      </div>
    </body>
</html>
