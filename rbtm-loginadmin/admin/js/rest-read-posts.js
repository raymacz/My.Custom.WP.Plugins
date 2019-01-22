/* REST API: Display Posts */


var button = document.getElementById('rest-button');
var container = document.getElementById('rest-container');

if (button) {
  button.addEventListener('click', function() {
    var request = new XMLHttpRequest();
    var query = 'wp/v2/posts';
    request.open('GET', rest_read_posts.root + query);
    request.onload = function() {
      if (request.status >= 200 && request.status < 400) {
        var data= JSON.parse(request.responseText);
        displayContent(data);
        button.remove();
      } else {
        console.log('Status: ' + request.status);
      }
    };
    request.oneerror = function() {
        console.log('Connection Error!');
    };
    request.send();
  });
}

function displayContent(data) {
 
//  container.innerHTML = data[1]["author_name"];
//  container.innerHTML = JSON.stringify(data, null, 4);;
for (var key in data) {
    container.innerHTML += '<h4>'+data[key].title.rendered+'</h4>';
    container.innerHTML += data[key].content.rendered;
}
 console.log(data);

  
}
