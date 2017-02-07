
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
    return { on: on };
    function on (eventName, callback) {
      socket.on(eventName, function (data) {
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

    function nuevoMarker(data){
      return $http.post("/marker",data);
    }
  })
  .controller('controlador', function(servicio,socket,$mdSidenav) {
    var ctrl = this;
    ctrl.ruta =

    ctrl.toggleNav = function () {
      $mdSidenav('left').toggle();
    }

    ctrl.map = {
       center: {latitude: 19.4346219, longitude: -99.1796127},
      //scrollwheel: false,
      zoom: 14,
      options: {scrollwheel: false},
      bounds:{
        southwest:{
          latitude: 19.409043,
          longitude: -99.139787
        },
        northeast:{
          latitude: 19.454856,
          longitude: -99.214803
        }
      }
    };


    ctrl.marker = {
      id: 0,
      coords: {latitude: 19.4346219, longitude: -99.1796127}
    };

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
      servicio.nuevo(ctrl.map.bounds)
      .then(function(resp){
        console.log(resp);
      })
      .catch(function(err) {
        // Tratar el error
      });
    };
    ctrl.inicio = function(data){
      console.log(data);
      ctrl.marker.coords = ctrl.ruta[ctrl.pos++];
    };
    socket.on('change:pos', ctrl.inicio);
  });
