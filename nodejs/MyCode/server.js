var http = require('http'),
    fs = require('fs');


/*	
app.get('/', function(req, res) {
res.sendFile(__dirname + '/index.html');});
app.use(express.static(__dirname + '/public'));
*/
	
	
function send404Response(response) {
	response.writeHead(404, {"Content-Type": "text/plain"});
    response.end('Error 404: Page not Found\n!');
}

function onRequest(request, response) {
	console.log(request.url);
	if (request.method == 'GET' && request.url== '/') {
		response.writeHead(200, {"Content-Type": "text/html"});
		fs.createReadStream("./index.html").pipe(response);

  //  next();
	} else if (request.method == 'GET' && request.url== '/products.json')  {
		response.writeHead(200, {
							"Content-Type": "application/json",
							'Access-Control-Allow-Origin' : '*',
							'Access-Control-Allow-Methods': 'GET,PUT,POST,DELETE'							
						   });
		fs.createReadStream("./jsonsample/products.json").pipe(response);		
	} else if (request.method == 'GET' && request.url== '/about.html')  {
		response.writeHead(200, {"Content-Type": "text/html"});
		fs.createReadStream("./about.html").pipe(response);	
	} else if (request.method == 'GET' && request.url== '/contact.html')  {
		response.writeHead(200, {"Content-Type": "text/html"});
		fs.createReadStream("./contact.html").pipe(response);		
	} else {
		send404Response(response);
	}	
	

}

http.createServer(onRequest).listen(1337, "127.0.0.1");
//http.createServer(onRequest).listen(8080, "127.0.0.1");

console.log('Server running at http://127.0.0.1:1337/');


