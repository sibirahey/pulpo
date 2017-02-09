pulpo = angular.module('pulpo');

pulpo.service('socket', function ($rootScope,socketURL) {
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
});

pulpo.service('servicio',function($http, url) {
  return {
    interruptor: interruptor,
    nuevo: nuevoMarker
  };
  function interruptor (toggle) {
    if(toggle === undefined){
      ruta = url;
    }else if(toggle){
      ruta = url + "/start";
    }else{
      ruta = url + "/stop";
    }
    return $http.get(ruta);
  }

  function nuevoMarker(){
    return $http.post("/marker");
  }
});
