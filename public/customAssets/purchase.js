

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



function searchProducts() {
  var productsFromDb = document.getElementById("ProductsFromDB");
  removeChilds(productsFromDb);
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
}

function removeChilds(node) {
  node.innerHTML = " ";
}

function ProcessDropDown(data) {

  var productsFromDb = document.getElementById("ProductsFromDB");

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
    th.innerHTML = data[i].id;
    tr.appendChild(th);

    var td = document.createElement('td');
    td.innerHTML = data[i].code;
    tr.appendChild(td);
    var td = document.createElement('td');
    td.innerHTML = data[i].name;
    tr.appendChild(td);
    var td = document.createElement('td');
    td.innerHTML = data[i].brand.name;
    tr.appendChild(td);
    var td = document.createElement('td');
    td.innerHTML = data[i].category.title;
    tr.appendChild(td);
    var td = document.createElement('td');
    td.innerHTML = data[i].unit.type;
    tr.appendChild(td);
    var td = document.createElement('td');

    var a = document.createElement('a');
    a.setAttribute('type', 'button');
    a.setAttribute('class', 'btn btn-outline-dark');
    a.setAttribute('href', '#');
    a.setAttribute('onClick', 'appendThisProduct('+data[i].id+')');
    a.innerHTML = "Select";
    td.appendChild(a);


    tr.appendChild(td);


    tbody.appendChild(tr);
  }
  productsFromDb.appendChild(tbody);
}

function appendThisProduct(id) {
  console.log(id);
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
           type:'GET',
           url:"/admin/purchases/getSingleAjax/"+id,
           dataType: 'json',
           success:function(data){
              //alert(data.success);
              console.log(data.success);
           },

        });
}
