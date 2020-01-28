

var check = false;

function changeVal(el) {
  var qt = parseFloat(el.parent().children(".qt").html());
  var price = parseFloat(el.parent().children(".price").html());
  var eq = Math.round(price * qt * 100) / 100;

  el.parent().children(".full-price").html( eq + "€" );

  changeTotal();
}

function changeTotal() {

  var price = 0;

  $(".full-price").each(function(index){
    price += parseFloat($(".full-price").eq(index).html());
  });

  price = Math.round(price * 100) / 100;
  var tax = Math.round(price * 0.05 * 100) / 100
  var shipping = parseFloat($(".shipping span").html());
  var fullPrice = Math.round((price + tax + shipping) *100) / 100;

  if(price == 0) {
    fullPrice = 0;
  }

  $(".subtotal span").html(price);
  $(".tax span").html(tax);
  $(".total span").html(fullPrice);
}

$(document).ready(function(){

  $(".remove").click(function(){
    var el = $(this);
    el.parent().parent().addClass("removed");
    window.setTimeout(
      function(){
        el.parent().parent().slideUp('fast', function() {
          el.parent().parent().remove();
          if($(".product").length == 0) {
            if(check) {
              $("#cart").html("<h1>The shop does not function, yet!</h1><p>If you liked my shopping cart, please take a second and heart this Pen on <a href='https://codepen.io/ziga-miklic/pen/xhpob'>CodePen</a>. Thank you!</p>");
            } else {
              $("#cart").html("<h1>No products!</h1>");
            }
          }
          changeTotal();
        });
      }, 200);
  });

  $(".qt-plus").click(function(){
    $(this).parent().children(".qt").html(parseInt($(this).parent().children(".qt").html()) + 1);

    $(this).parent().children(".full-price").addClass("added");

    var el = $(this);
    window.setTimeout(function(){el.parent().children(".full-price").removeClass("added"); changeVal(el);}, 150);
  });

  $(".qt-minus").click(function(){

    child = $(this).parent().children(".qt");

    if(parseInt(child.html()) > 1) {
      child.html(parseInt(child.html()) - 1);
    }

    $(this).parent().children(".full-price").addClass("minused");

    var el = $(this);
    window.setTimeout(function(){el.parent().children(".full-price").removeClass("minused"); changeVal(el);}, 150);
  });

  window.setTimeout(function(){$(".is-open").removeClass("is-open")}, 1200);

  $(".btn1").click(function(){
    check = true;
    $(".remove").click();
  });
});

$(document).ready(function () {
     $("#searchButton").one('click', function (event) {
           event.preventDefault();
           //do something
        //   $(this).prop('disabled', true);



     });


});

function searchProducts(){

  document.getElementById('searchButton').disabled = true;



  var searchTxt = document.getElementById("input_search_products").value;
  var category = document.getElementById("input_category").value;
  var brand = document.getElementById("input_brand").value;
  console.log(searchTxt);
  console.log(category);
  console.log(brand);

  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  $.ajax({
           type:'POST',
           url:"/admin/purchases/search",
           data:{product:searchTxt, categoryId:category, brandId:brand},
           success:function(data){
              //alert(data.success);

              console.log(data.success);
              ProcessDropDown(data.success);
           },

        });

//    document.getElementById('searchButton').disabled = false;
    setTimeout('$("#searchButton").removeAttr("disabled")', 3000);


}

function removeChilds(node) {



  while(node.hasChildNodes()) {
    node.removeChild(node.lastChild);
  }


}

function ProcessDropDown(data) {

  var productsFromDb = document.getElementById("ProductsFromDB");
  removeChilds(productsFromDb);


  var thead = document.createElement("thead");
  var tr = document.createElement("tr");
  var th = document.createElement("th");
  th.setAttribute('scope', 'col');
  th.innerHTML = "#";
  tr.appendChild(th);
  var th = document.createElement("th");
  th.setAttribute('scope', 'col');
  th.innerHTML = "Code";
  tr.appendChild(th);
  var th = document.createElement("th");
  th.setAttribute('scope', 'col');
  th.innerHTML = "Product";
  tr.appendChild(th);
  var th = document.createElement("th");
  th.setAttribute('scope', 'col');
  th.innerHTML = "Brand";
  tr.appendChild(th);
  var th = document.createElement("th");
  th.setAttribute('scope', 'col');
  th.innerHTML = "Category";
  tr.appendChild(th);
  var th = document.createElement("th");
  th.setAttribute('scope', 'col');
  th.innerHTML = "Unit";
  tr.appendChild(th);
  var th = document.createElement("th");
  th.setAttribute('scope', 'col');
  th.innerHTML = "Action";
  tr.appendChild(th);
  thead.appendChild(tr);
  productsFromDb.appendChild(thead);

  var tbody = document.createElement('tbody');





  for(var i =0; i < data.length; i++) {
    var tr = document.createElement('tr');
    var th = document.createElement("th");
    th.setAttribute('scope', 'row');
    th.innerHTML = i+1;
    tr.appendChild(th);

    var td = document.createElement('td');
    td.innerHTML = data[i].code;
    tr.appendChild(td);
    var td = document.createElement('td');
    td.innerHTML = data[i].name;
    tr.appendChild(td);
    var td = document.createElement('td');
    td.innerHTML = data[i].brand;
    tr.appendChild(td);
    var td = document.createElement('td');
    td.innerHTML = data[i].category;
    tr.appendChild(td);
    var td = document.createElement('td');
    td.innerHTML = data[i].unit;
    tr.appendChild(td);
    var td = document.createElement('td');

    var a = document.createElement('a');
    a.setAttribute('type', 'button');
    a.setAttribute('class', 'btn btn-outline-dark');
    a.setAttribute('href', 'javascript:void(0);');
    a.setAttribute('onClick', "getThisProduct("+data[i].id+")");
    a.innerHTML = "Select";
    td.appendChild(a);


    tr.appendChild(td);


    tbody.appendChild(tr);


  }
  window.setTimeout(function(){
  //  listOfProducts.appendChild(article);
    productsFromDb.appendChild(tbody);
  }, 200);

}

function getThisProduct(id) {
  console.log(id);
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  console.log("Hello");

  $.ajax({
           type:'GET',
           url: '/admin/purchases/getSingleProductAjax/'+id,
          // data: {id: id},
           dataType: 'json',
           success:function(data){
              console.log(data.success);
              appendThisProduct(data.success);
           }

        });


}

function appendThisProduct(data) {
  var listOfProducts = document.getElementById('listOfProducts');

  var article = document.createElement('article');
  article.setAttribute('class', 'product');

  var header = document.createElement('header');

  var a = document.createElement('a');
  a.setAttribute('class', 'remove');

  var img = document.createElement('img');
  if(data.img) {
    img.setAttribute('src', data.img);
  } else {
    img.setAttribute('src', "/Images/Image-Unavailable.jpg");
  }
  var h3 = document.createElement('h3');
  h3.innerHTML = "Remove product";
  a.appendChild(img);
  a.appendChild(h3);

  header.appendChild(a);
  article.appendChild(header);

  var content = document.createElement('div');
  content.setAttribute('class', 'content');

  var h1 = document.createElement('h1');
  h1.innerHTML = data.name;
  content.appendChild(h1);
  var des = document.createElement('p');
  des.innerHTML = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, numquam quis perspiciatis ea ad omnis provident laborum dolore in atque.";
  //var description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, numquam quis perspiciatis ea ad omnis provident laborum dolore in atque.";
  content.appendChild(des);


  var selected = document.createElement('div');
  selected.setAttribute('title', 'You have selected this product to be shipped in the color yellow.');
  selected.setAttribute('style', 'top: 0');
  selected.setAttribute('class', 'color yellow');
  content.appendChild(selected);

  var unit = document.createElement('div');
  unit.setAttribute('style', 'top: 43px');
  unit.setAttribute('class', 'type small');
  unit.innerHTML = data.unit;
  content.appendChild(unit);
  article.appendChild(content);

  var footer = document.createElement('footer');
  footer.setAttribute('class', 'content');

  var qt_minus = document.createElement('span');
  qt_minus.setAttribute('class', 'qt-minus');
  qt_minus.innerHTML = "-";
  footer.appendChild(qt_minus);

  var qt = document.createElement('span');
  qt.setAttribute('class', 'qt');
  qt.innerHTML = "1";
  footer.appendChild(qt);

  var qt_plus = document.createElement('span');
  qt_plus.setAttribute('class', 'qt-plus');
  qt_plus.innerHTML = "+";
  footer.appendChild(qt_plus);

  var full_price = document.createElement('h2');
  full_price.setAttribute('class', 'full-price');
  full_price.innerHTML = "14€";
  footer.appendChild(full_price);

  var price = document.createElement('h2');
  price.setAttribute('class', 'price');
  price.innerHTML = "14€";
  footer.appendChild(price);

  article.appendChild(footer);


  window.setTimeout(function(){
  //  listOfProducts.appendChild(article);
    listOfProducts.prepend(article);
  }, 100);




}
