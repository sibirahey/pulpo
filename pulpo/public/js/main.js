
angular.module('pulpo', ['ngMaterial','uiGmapgoogle-maps'])
  .value("url","/motor")
  .value('socketURL',"localhost:5000")
  .config(function(uiGmapGoogleMapApiProvider,$mdIconProvider) {
    uiGmapGoogleMapApiProvider.configure({
      transport: 'https',
      isGoogleMapsForWork: false,
      china: false,
      v: '3' ,
      libraries: '',
      language: 'en',
      preventLoad: false,
    });
    $mdIconProvider
      .icon('moto', 'img/icons/moto.svg',24);
  })
  .service('socket', function ($rootScope,socketURL) {
    var socket = io.connect(socketURL);
    return {
      on: on,
      emit: emit
    };

    function on (eventName, callback) {
      socket.on(eventName, function (data) {
        $rootScope.$apply(function () {
          callback(data);
        });
      });
    }

    function emit (eventName, data, callback) {
      socket.emit(eventName, data, function (data) {
        $rootScope.$apply(function () {
          callback(data);
        });
      });
    }
  })
  .service('servicio',function($http, url) {
    return {
      interruptor: interruptor,
      nuevo: nuevoMarker
    };
    function interruptor (toggle) {
        if(toggle){
          ruta = url + "/start";
        }else{
          ruta = url + "/stop";
        }
        return $http.get(ruta);
    }

    function nuevoMarker(){
      return $http.post("/marker");
    }
  })
  .controller('controlador', function(servicio,socket,$mdSidenav) {
    var ctrl = this;
    ctrl.ruta =

    ctrl.toggleNav = function () {
      $mdSidenav('left').toggle();
    }

    ctrl.boundsChanged = function (map) {
      bounds = JSON.stringify(map.getBounds().toJSON());
      // console.log(bounds);
      socket.emit(
        'change:bounds',
        bounds
      );
    }

    ctrl.map = {
       center: {latitude: "19.4346219", longitude: "-99.1796127"},
      //scrollwheel: false,
      zoom: 14,
      options: {scrollwheel: false},
      events: {
          bounds_changed: ctrl.boundsChanged
      }
    };
    ctrl.markers = {};

    ctrl.pos = 1;
    ctrl.onChange = function(toggle) {
      servicio.interruptor(toggle)
        .then(function(message) {
            ctrl.message = message.data.estado;
        })
        .catch(function(err) {
            // Tratar el error
        });
    };
    ctrl.nuevo = function(){
      servicio.nuevo()
      .then(function(resp){
        console.log(resp);
      })
      .catch(function(err) {
        // Tratar el error
      });
    };
    ctrl.inicio = function(data){
      // console.log(JSON.parse(data));
      jsonData = JSON.parse(data);
      ctrl.markers[jsonData.key] = jsonData.coords;
    };
    socket.on('change:pos', ctrl.inicio);
  });
