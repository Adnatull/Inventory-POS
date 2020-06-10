var check = false;
function removeProduct(el) {
    window.setTimeout(
      function(){
          el.parentElement.parentElement.remove();
          if($(".product").length == 0) {
            if(!check) {
              $("#listOfProducts").html("<h1>No products!</h1>");
              check = true;
            }
          }
          changeTotal();

      }, 200);
  }

  function checkDecimal(money) {
    if(!money.match(/^\d+.?\d*$/)) {
      el.value = '0';
      alert('Please enter input correctly');
      el.focus();
    }

  }


function qtMinus(el, availableQuantity) {
  var qt = parseFloat(el.parentElement.querySelector(".quantity").value);
  qt = qt-1;
  if(qt<0) {
    qt = 0;
  }
  el.parentElement.querySelector(".quantity").value = qt;
//  console.log(qt);
  changeVal(el);
}

function qtPlus(el, availableQuantity) {
  var qt = parseFloat(el.parentElement.querySelector(".quantity").value);
  qt = qt+1;
  if(qt > availableQuantity) {
    qt = availableQuantity;
  }
  el.parentElement.querySelector(".quantity").value = qt;
//  console.log(qt);
  changeVal(el);
}

function changeVal(el, availableQuantity) {
  var qt = parseFloat(el.parentElement.querySelector(".quantity").value);
  if(qt<0) {
    qt = 0;
  }
  if(qt>availableQuantity) {
    qt = availableQuantity;
  }
  el.parentElement.querySelector(".quantity").value = qt;
  var price = parseFloat(el.parentElement.querySelector(".price").value);
  el.parentElement.querySelector(".price").value = price;
  var eq = Math.round(price * qt * 100) / 100;
//  console.log(eq);

  el.parentElement.querySelector(".full-price").innerHTML =  eq + "৳";
  changeTotal();
}

function changeTotal() {
  var price = 0;

  $(".full-price").each(function(index){
    price += parseFloat($(".full-price").eq(index).html());
  });

  price = Math.round(price * 100) / 100;
  //var tax = Math.round(price * 0.05 * 100) / 100
  var discount = document.getElementById("discount").value;
  discount = parseFloat(discount);
  console.log(discount);
  var fullPrice = Math.round((price - discount) *100) / 100;

  var paid = document.getElementById('paid').value;
  paid = parseFloat(paid);

  $('.dues span').html(fullPrice-paid);

  if(price == 0) {
    fullPrice = 0;
  }

  $(".subtotal span").html(price);
  // $(".tax span").html(tax);
  $(".total span").html(fullPrice);
}

function changeDiscount(el) {
  checkDecimal(el.value);
  el.value = parseFloat(el.value);
  changeTotal();
}

function changePaid(el) {
  checkDecimal(el.value);
  el.value = parseFloat(el.value);
  changeTotal();
}


function freshList() {
  if(check) {
    var listOfProducts = document.getElementById('listOfProducts');
    removeChilds(listOfProducts);
    check = false;
  }
}




function searchProducts(){

  document.getElementById('searchButton').disabled = true;

  var searchTxt = document.getElementById("input_search_products").value;


  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
           type:'POST',
           url:"/admin/sale/getRemainingProductByCodeAjax",
           data:{productCode:searchTxt},
           success:function(data){
          console.log(data);
              // ProcessDropDown(data.success);
              if(data.success) {
                appendThisProduct(data.success);
              } else {
                alert('Product not available');
              }
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

function existAlready(code) {
    if($("."+code).length >0 )
      return true;
    return false;
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

    if(existAlready(data[i].code))
      continue;
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
    a.setAttribute('onClick', "getThisProduct("+data[i].id+",this)");
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

function getThisProduct(id, elm) {
  console.log(id);
  elm.setAttribute('class', 'btn btn-secondary disabled');
  elm.setAttribute('aria-disabled', 'true');
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

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
  freshList();
  var listOfProducts = document.getElementById('listOfProducts');

  var article = document.createElement('article');
  article.setAttribute('class', 'product');

  var header = document.createElement('header');

  var a = document.createElement('a');
  a.setAttribute('class', 'remove');
  a.setAttribute('onclick', 'removeProduct(this)');

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
  h1.innerHTML = data.name+'  [';

  var code = document.createElement("small");
  code.setAttribute('class', 'text-muted');
  code.innerHTML = data.code;
  h1.appendChild(code);
  h1.innerHTML = h1.innerHTML + ']';



  content.appendChild(h1);
  var des = document.createElement('p');
  des.innerHTML = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, numquam quis perspiciatis ea ad omnis provident laborum dolore in atque.";
  //var description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Soluta, numquam quis perspiciatis ea ad omnis provident laborum dolore in atque.";
  content.appendChild(des);

  var inputCode = document.createElement('input');
  inputCode.setAttribute('type', 'hidden');
  inputCode.setAttribute('value', data.code);
  inputCode.setAttribute('name', 'code[]');
  inputCode.setAttribute('class', data.code);
  content.appendChild(inputCode);

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
  qt_minus.setAttribute('onclick', 'qtMinus(this, '+data.quantity+')');
  qt_minus.innerHTML = "-";
  footer.appendChild(qt_minus);

  var qt = document.createElement('input');
  qt.setAttribute('class', 'qt-plus quantity');
  qt.setAttribute('type', 'text');
  qt.setAttribute('name', 'quantity[]');
  qt.setAttribute('value', '1');
  qt.setAttribute('onchange', 'changeVal(this, '+data.quantity+')');
  footer.appendChild(qt);

  var qt_plus = document.createElement('span');
  qt_plus.setAttribute('class', 'qt-plus');
  qt_plus.setAttribute('onclick', 'qtPlus(this, '+data.quantity+')');
  qt_plus.innerHTML = "+";

  footer.appendChild(qt_plus);

  var full_price = document.createElement('h2');
  full_price.setAttribute('class', 'full-price');
  full_price.innerHTML = data.price;
  footer.appendChild(full_price);

  var full_price_h2 = document.createElement('h2');
  full_price_h2.setAttribute('class', 'full-price-h2');
  full_price_h2.innerHTML = "Price";
  footer.appendChild(full_price_h2);


  var price = document.createElement('input');
  price.setAttribute('class', 'price priceSingle');
  price.setAttribute('type', 'text');
  price.setAttribute('value', data.price);
  price.setAttribute('placeholder', 'unit price');
  price.setAttribute('onchange', 'changeVal(this)');
  price.setAttribute('name', 'price[]');
  price.innerHTML = "0";
  footer.appendChild(price);

  article.appendChild(footer);

  window.setTimeout(function(){
    listOfProducts.prepend(article);
    changeTotal();
  }, 100);

}
