# Pulpo ejercicio

El ejercicio consiste en diseñar y desarrollar una aplicación web que permita visualizar en un mapa la afinidad en base a la distancia entre un grupo de conductores y clientes.

### Prerequisites

- [Docker](https://www.docker.com/products/docker/) `>= 1.12`

### Installing

1 - Clonar el Repositorio
```
$git clone https://github.com/sibirahey/pulpo.git
```
2 - Iniciar los contenedores de Docker, en el folder laradock
```
cd laradock
docker-compose up -d nginx redis
```
3 - Entrar al contenedor workspace y ejecutar la cola de trabajador Laravel
```
docker-compose exec workspace bash
  # php artisan queue:work
```
4 - En otra terminal entrar al contenedor workspace y ejecutar Node
```
docker-compose exec workspace bash
  # cd node
  # node app.js
```
5 - Abrir el browser y visitar localhost: `http://localhost`.


## Built With

* [Docker](http://www.dropwizard.io/1.0.2/docs/)
* [Laravel](https://laravel.com/)
* [Nginx](https://www.nginx.com/)
* [Redis](https://redis.io/)
* [Angular](https://angularjs.org/)
* [Node](https://rometools.github.io/rome/)
* [Socket.io](http://socket.io/)


## Author

* [**Eduardo Fernández**](https://sibirahey.github.io/)
