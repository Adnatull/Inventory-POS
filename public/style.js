function previewFiles() {
 //   var preview = document.querySelector('#preview');
    var preview = document.getElementById('preview');
    preview.innerHTML = "";
  //  var files   = document.querySelector('input[type=file]').files;
    var files = document.getElementById('browse').files;

    function readAndPreview(file) {

        // Make sure `file.name` matches our extensions criteria
        if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {
            var reader = new FileReader();

            reader.addEventListener("load", function () {
                var image = new Image();
                image.height = 100;
                image.title = file.name;
                image.src = this.result;
                preview.appendChild( image );
            }, false);
            reader.readAsDataURL(file);
        }
    }
    if (files) {
        [].forEach.call(files, readAndPreview);
    }
}

function hasCustomer() {
  var checkBox = GetElementInsideContainer("hasCustomer", "defaultCheck2");
  if(checkBox.checked) {
    var label = GetElementInsideContainer("hasCustomer", "label2");
     label.innerHTML = " ";

     IDGetCustomerFromDB();

     var elm2 = document.getElementById("newCustomer");
     removeChilds(elm2);
     // elm2.innerHTML = " ";
  }
  else {
    var label = GetElementInsideContainer("hasCustomer", "label2");
    label.innerHTML = "Does the Customer already exist?";
    var elm1 = document.getElementById("getCustomerFromDB");
    removeChilds(elm1);
//    elm1.innerHTML = " ";

    IDNewCustomer();
  }
}


function provideCustomer() {
  var checkBox = GetElementInsideContainer("provideCustomer", "defaultCheck1");
  if(checkBox.checked) {
    var label = GetElementInsideContainer("provideCustomer", "label");
    label.innerHTML = "Provide Customer Information";
    IDCustomerExist();


    IDNewCustomer();

  }
  else {
    var label = GetElementInsideContainer("provideCustomer", "label");
    label.innerHTML = "Want to provide Customer Information?";
    var elm = document.getElementById("customerExist");
    removeChilds(elm);
  //  elm.innerHTML = " "
    var elm1 = document.getElementById("getCustomerFromDB");
    removeChilds(elm1);
  //  elm1.innerHTML = " ";

  var elm2 = document.getElementById("newCustomer");
  removeChilds(elm2);

  }
}

function GetElementInsideContainer(containerID, childID) {
    var elm = document.getElementById(childID);
    var parent = elm ? elm.parentNode : {};
    return (parent.id && parent.id === containerID) ? elm : {};
}

function IDGetCustomerFromDB() {
  var elm1 = document.getElementById("getCustomerFromDB");
//   elm1.innerHTML = "cvcvcv";

  var child1 = document.createElement("input");
  child1.className= "form-control";
  child1.setAttribute('type', 'text');
  child1.setAttribute('id', 'txtCustomer');
  child1.setAttribute('placeholder', 'Customer Name');

  var child2 = document.createElement("a");
  child2.className= "btn btn-primary";
  child2.setAttribute('id', 'searchCustomers');
  child2.innerHTML = "Search";

  var child3 = document.createElement("select");
  child3.className= "form-control";
  child3.setAttribute('id', 'customersFromDB');
  child3.setAttribute('name', 'customerID');
  child3.innerHTML = " ";

  elm1.appendChild(child1);
  elm1.appendChild(child2);
  elm1.appendChild(child3);
}

function IDNewCustomer() {
  var elm2 = document.getElementById("newCustomer");
//  elm2.innerHTML = "xyxy";
  var child1 = document.createElement("input");
  child1.className = "form-control";
  child1.setAttribute('type', 'text');
  child1.setAttribute('name', 'customerName');
  child1.setAttribute('id', 'customerName');
  child1.setAttribute('placeholder', 'Customer Name');

  var child2 = document.createElement("input");
  child2.className = "form-control";
  child2.setAttribute('type', 'text');
  child2.setAttribute('name', 'customerAddress');
  child2.setAttribute('id', 'customerAddress');
  child2.setAttribute('placeholder', 'Customer Address');

  var child3 = document.createElement("input");
  child3.className = "form-control";
  child3.setAttribute('type', 'text');
  child3.setAttribute('name', 'customerPhone');
  child3.setAttribute('id', 'customerPhone');
  child3.setAttribute('placeholder', 'Customer Phone');

  elm2.appendChild(child1);
  elm2.appendChild(child2);
  elm2.appendChild(child3);
}

function IDCustomerExist() {
  var elm = document.getElementById("customerExist");

  var child1 = document.createElement("div");
  child1.setAttribute('id', "hasCustomer");
  child1.className = "form-check";

  var child2 = document.createElement("input");
  child2.setAttribute('id', "defaultCheck2");
  child2.className = "form-check-input";
  child2.setAttribute('type', 'checkbox');
  child2.setAttribute('onClick', 'hasCustomer()');

  var child3 = document.createElement("label");
  child3.setAttribute('id', "label2");
  child3.className = "form-check-label";
  child3.setAttribute('for', 'defaultCheck2');
  child3.innerHTML = "Does the Customer already exist?";

  child1.appendChild(child2);
  child1.appendChild(child3);

  elm.appendChild(child1);
}

function removeChilds(node) {
  var child = node.lastElementChild;
        while (child) {
            node.removeChild(child);
            child = node.lastElementChild;
        }
}
