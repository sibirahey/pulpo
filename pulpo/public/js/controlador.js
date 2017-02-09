pulpo = angular.module('pulpo');

pulpo.controller('controlador', function(servicio,socket,$mdSidenav) {
  var ctrl = this;

  ctrl.estadoMotor = function(message){
    if(message.data == "start"){
      ctrl.interruptor = true;
    }else if (message.data == "stop"){
      ctrl.interruptor = false;
    }
    ctrl.message = ctrl.interruptor?"ENCENDIDO":"APAGADO";
  }

  servicio.interruptor()
    .then(ctrl.estadoMotor)
    .catch(function(err) {
        // Tratar el error
    });

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

  ctrl.onChange = function(toggle) {
    servicio.interruptor(toggle)
      .then(ctrl.estadoMotor)
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
