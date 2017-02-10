pulpo = angular.module('pulpo');

pulpo.controller('controlador', function(servicio,socket,$mdSidenav,$mdDialog) {
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
  ctrl.rutas = {};
  ctrl.stroke= {
      color: '#6060FB',
      weight: 3
  };

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

  //TODO:eliminar ruta de array y markers
  ctrl.delete = function(data){
    // console.log(JSON.parse(data));
    jsonData = JSON.parse(data);
    ctrl.markers[jsonData.key] = jsonData.coords;
  };
  socket.on('delete', ctrl.delete);

  ctrl.clicMarker = function(id){
    var confirm = $mdDialog.confirm()
          .title('¿Necesita un servicio?')
          .textContent('Este marcador permanecerá estático y el más cercano trazara una ruta hacia este, al encontrarse ambos desaparecerán.')
          .ok('SI')
          .cancel('NO');

    $mdDialog.show(confirm).then(function() {
      servicio.solicitarServicio(id)
        .then(function(data) {
          ctrl.rutas[data.data.id] = data.data.ruta;
        })
        .catch(function(err) {
            // Tratar el error
        });
    }, function() {});
  }

});
