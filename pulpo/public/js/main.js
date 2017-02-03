
angular.module('pulpo', ['ngMaterial','uiGmapgoogle-maps'])
  .value("url","/motor")
  .value('socketURL','localhost')
  .config(function(uiGmapGoogleMapApiProvider) {
    uiGmapGoogleMapApiProvider.configure({
      transport: 'https',
      isGoogleMapsForWork: false,
      china: false,
      v: '3' ,
      libraries: '',
      language: 'en',
      preventLoad: false,
    });
  })
  .service('servicio',function($http, url) {
    return {
        interruptor: interruptor
    }
    function interruptor (toggle) {
        if(toggle){
          ruta = url + "/start";
        }else{
          ruta = url + "/stop";
        }
        return $http.get(ruta);
    }
  })
  .controller('controlador', function(servicio) {
    var ctrl = this;
    ctrl.ruta = [{longitude:-99.196364 ,latitude:19.434448},
    {longitude:-99.196413 ,latitude:19.434456},
    {longitude:-99.196596 ,latitude:19.434465},
    {longitude:-99.196773 ,latitude:19.434442},
    {longitude:-99.196995 ,latitude:19.434407},
    {longitude:-99.197205 ,latitude:19.434330},
    {longitude:-99.197351 ,latitude:19.434230},
    {longitude:-99.197495 ,latitude:19.434115},
    {longitude:-99.198209 ,latitude:19.434169},
    {longitude:-99.198956 ,latitude:19.434217},
    {longitude:-99.199729 ,latitude:19.434282},
    {longitude:-99.200449 ,latitude:19.434322},
    {longitude:-99.201433 ,latitude:19.434470},
    {longitude:-99.201208 ,latitude:19.435975},
    {longitude:-99.201196 ,latitude:19.436054},
    {longitude:-99.201186 ,latitude:19.436111},
    {longitude:-99.200842 ,latitude:19.438237},
    {longitude:-99.200830 ,latitude:19.438477},
    {longitude:-99.200772 ,latitude:19.439692},
    {longitude:-99.200726 ,latitude:19.440522},
    {longitude:-99.200708 ,latitude:19.440683},
    {longitude:-99.200874 ,latitude:19.440618},
    {longitude:-99.200864 ,latitude:19.440474},
    {longitude:-99.200901 ,latitude:19.439692},
      {longitude:-99.200955 ,latitude:19.438679}];


    ctrl.map = {
      center: {latitude: 19.4339562, longitude: -99.1969541},
      //scrollwheel: false,
      zoom: 14,
      options: {scrollwheel: false}
    };

    ctrl.marker = {
      id: 0,
      coords: ctrl.ruta[0]
    };

    ctrl.pos = 1;
    ctrl.onChange = function(toggle) {
      ctrl.marker.coords = ctrl.ruta[ctrl.pos++];

      // servicio.interruptor(toggle)
      //   .then(function(message) {
      //       ctrl.message = message.data.estado;
      //   })
      //   .catch(function(err) {
      //       // Tratar el error
      //   });
    };
  });
