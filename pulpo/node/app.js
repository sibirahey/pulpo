var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var redis = require('redis');
var sub = redis.createClient({host:"redis"});
var client = redis.createClient({host:"redis"});

// app.get('/', function(req, res){
//   res.send('<h1>Hello world</h1>');
// });

sub.on("message", function (channel, message) {
    console.log("sub channel " + channel + ": " + message);
    io.emit('change:pos', message);
});
sub.subscribe("pulso");

io.on('connection', function(socket){
  console.log('a user connected');
  socket.on('change:bounds', function(bounds){
    // console.log('bounds',bounds);
    client.set("bounds", bounds);
  });
});

http.listen(5000, function(){
  console.log('listening on *:5000');
});
