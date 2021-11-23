
window.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("form-ajax");
    if (form) {
      form.addEventListener("change", function (e) {
        e.preventDefault();       
        requete_ajax_for_shortcode_2();
      });
        
  
    } // and if form  
});

function makeRequest(data) {
  let data_post = [];
  for (var i = 0; i < data.length; i++) {
    if (data[i].checked) {
      let data_name = data[i].name;
      data_post = data_post.concat(data_name);
      //console.log(data_name);
      let data_type = data[i].type;
      data_post = data_post.concat(data[i].value);
    }
  }
    return data_post;
}


function requete_ajax_for_shortcode() {
        let form = document.getElementById("form-ajax");
        //let url = form.getAttribute("action");
        let data = document.querySelectorAll('input[type="checkbox"]');
        let data_post = makeRequest(data);
        let copie = [];
        let data_post_string = data_post.toString();
        let data_post_string_array = data_post_string.split(",");
        let arr = [];
        for (var i = 0; i < data_post_string_array.length; i++) {
          if (data_post_string_array[i] != "" && data_post_string_array[i] != "on") {
            arr.push(data_post_string_array[i]);
          }
        }

      var getUrl = window.location;
      var baseUrl = getUrl.protocol + "//" + getUrl.host + "/";
      arr.forEach(element => {
        if (element != "on") {
          copie.push(element);
        }

        console.log(copie);
      });

  fetch(baseUrl + "wp-json/wp/v2/media_manager")
    .then(function (response) {
      response.json().then(function (json) {
        for (var i = 0; i < json.length; i++) {
          console.log(json[i].id);
          console.log(json[i].title);
          console.log(json[i].url);
          let dev = document.getElementById("notification");
          let html = [];
          html.push(
            '<div class="col-md-4">',
            '<div class="card">',
            '<img class="card-img-top" src="' +
            json[i].url +
            '" alt="Card image cap">',
            '<div class="card-body">',
            '<h5 class="card-title">' +
            json[i].title +
            '</h5>',
            '<p class="card-text">' +
            json[i].description +
            '</p>',
            '<a href="#" class="btn btn-primary">Go somewhere</a>',
            '</div>',
            '</div>',
            '</div>'
          );
          dev.innerHTML = html.join("");
        }
      })
    })
        .catch(function (error) {
      console.log(error);
    });
 
}


function requete_ajax_for_shortcode_2() {
   let data = document.querySelectorAll('input[type="checkbox"]');
        let data_post = makeRequest(data);
        let copie = [];
        let data_post_string = data_post.toString();
        let data_post_string_array = data_post_string.split(",");
        let arr = [];
        for (var i = 0; i < data_post_string_array.length; i++) {
          if (data_post_string_array[i] != "" && data_post_string_array[i] != "on") {
            arr.push(data_post_string_array[i]);
          }
        }
  var getUrl = window.location;
  var baseUrl = getUrl.protocol + "//" + getUrl.host + "/";
  url = baseUrl + "wp-admin/admin-ajax.php", 
  console.log(url);
  const xhr = new XMLHttpRequest();
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhr
  xhr.send("action=custom_form_ajax_call&data=" + arr);

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      console.log(xhr.responseText);
   
    }
  }
   
  
}


  

