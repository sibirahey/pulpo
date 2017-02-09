
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
  });
