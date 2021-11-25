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
      let data_name = data[i].id;
      let data_value = data[i].name;
      data_post = data_post.concat(data_value + '=' + data_name );
     
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
  console.log(data_post);
  let data_post_string = data_post.toString();
  let data_post_string_array = data_post_string.split(",");
  let arr = [];
  for (var i = 0; i < data_post_string_array.length; i++) {
    if (data_post_string_array[i] != "" ) {
      arr.push(data_post_string_array[i]);

    }
    console.log(arr);
    arr.forEach(element => {
      console.log(element);
   



  
  
  
   

  let getUrl = window.location;
  let baseUrl = getUrl.protocol + "//" + getUrl.host + "/";


   fetch(baseUrl + "wp-json/wp/v2/produit?"+element +"&&?"+ element )
      .then(function (response) {
        response.json().then(function (json) {
          let dev = document.getElementById("notification");
          let html = [];
          for (var i = 0; i < json.length; i++) {
            console.log(json[i]);
            console.log(json[i].title.rendered);
            console.log(json[i].content.rendered);
            console.log(json[i].guid.rendered);
            console.log(json[i].id);
            console.log(json[i].date);
            console.log(json[i].link);
            console.log(json[i].slug);
            console.log(json[i].modified);
            console.log(json[i].modified_gmt);
            console.log(json[i].status);
            console.log(json[i].better_featured_image.source_url);
            
              



        
           
           
            html.push(
              '<div class="col-md-4">',
              '<div class="card">',
              '<img src="'+ json[i].better_featured_image.source_url+ '">',
              '<div class="card-body">',
              '<h5 class="card-title">' +
              json[i].title.rendered +
              '</h5>',
           
              '<a href="'+json[i].link+'" class="btn btn-primary">Go somewhere</a>',
              '</div>',
              '</div>',
              '</div>'
            );
          }
           dev.innerHTML = html.join("");
        });
      });


   });
  
  }

 
 
/*
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
      let dev = document.getElementById("notification");
      console.log(xhr.responseText);
      //let data = JSON.parse(xhr.responseText);
      // console.log(data);
      /*data.forEach(element => {
        console.log(element);
        copie.push(element);
      });*/



    }




 
window.addEventListener("DOMContentLoaded", function () {
  const searchBar = document.getElementById("searchBar");
  const produitList = document.getElementById('produitList');
  const formAjax = document.getElementById('form-ajax')
  const getUrl = window.location;
  const baseUrl = getUrl.protocol + "//" + getUrl.host + "/";
  var data = [];
  
if(formAjax){
  formAjax.addEventListener('change', function (e) {
    e.preventDefault();
    //console.log(e.target);
    let data_check = e.target.name
    let id = e.target.id;
    console.log(data_check, id, 'hello');
    loadApiWithParams(data_check, id);
  });
}

  /********************************************/
  /* FUNCTION TO GET THE DATA FROM THE SERVER */
  /******************************************* */


  const loadApiWithParams = async (data_check, id) => {
    
    let url = baseUrl + "wp-json/wp/v2/media_manager?" + data_check + "=" + id;
    
  
    try {
      const response = await fetch(url);
      const data = await response.json();
      console.log(data);
      displayData(data);
    }
    catch (error) {
      console.log(error);
    }
  }

  /*********************************************** */
  /* FUNCTION QUERY ALL                */
 /************************************************** */
    const loadApi = async () => {
    let url = baseUrl + "wp-json/wp/v2/media_manager";
    
    try {
      const response = await fetch(url);
      const data = await response.json();
      displayData(data);
      if (searchBar) {
        searchBar.addEventListener("keyup", function (e) {
          const searchString = e.target.value.toLowerCase();
          const filteredProduits = data.filter((produit) => {
            return (produit.title.rendered.toLowerCase().includes(searchString));
          });
          displayData(filteredProduits);
        });
      }  
      
    }
    catch (error) {
      console.log(error);
    }
  }
  loadApi();
 

  /**************************************************** */
  /*  FUNCTUIN RENDER DATA */
  /******************************************************* */

  const displayData = async (data) => {
    const htmlString = data.map((data) => {
      
      return `
    
    <div class="card">
   
    <div class="card-body">
    <h5 class="card-title">${data.title.rendered}</h5>
   
    <p class="card-text">${data.slug}</p>
    <a href="${data.guid.rendered}" class="btn btn-primary">voir la produit</a>
    </div>
    </div>
     

  
    `;
       
    }).join("");
    produitList.innerHTML = htmlString;
  }




        


      

}); 





    

