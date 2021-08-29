update = 0;
useSwal = 0;
primaryKey = "id";
reloadAfterSubmit = false;
formId = "";
currentEventBtn = "";
$(".FormSubmit").on("click", function() {
  currentEventBtn = $(this);
  formId = $(this).data("form");
  submitData(formId);
});

function resetForm(formId) {
$("#"+formId)[0].reset();
  $("#"+formId).find("input").val("");
  $('input[name="' + primaryKey + '"]').removeAttr('value');
  $("#"+formId+"Errors").html("");
  $("#"+formId).find("textarea").val("");

}

$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});



function submitForm(data) {
  if(useSwal){
    swal({
      title: 'Are you sure ?',
      showCancelButton: true,
      confirmButtonText: 'Submit',
      showLoaderOnConfirm: true,
      allowOutsideClick: false
    }).then(function() {
      ajax_request(data, formId);
    });
  }else{
      ajax_request(data, formId);
  }

}


function ajax_request(data){

    var xhttp;
    if (window.XMLHttpRequest) {
      xhttp = new XMLHttpRequest();
    } else {
      // code for IE6, IE5
      xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.addEventListener("load", function() {

      SubmitResultHandler(JSON.parse(this.responseText), formId);

    });
    xhttp.addEventListener("error", function() {
      setTimeout(function() {
        oops();
      }, 100);
    });
    if($('input[name="' + primaryKey + '"]').val()){
      data.append("_method", "PUT");
      xhttp.open("POST", baseUrl+"/"+$('input[name="' + primaryKey + '"]').val(), false);
      // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    }else{
      xhttp.open("POST", baseUrl, false);
    }
    xhttp.setRequestHeader("X-CSRF-TOKEN", $('meta[name="csrf-token"]').attr('content'));

    xhttp.send(data);
}


function SubmitResultHandler(data, formId) {
  if (data.hasOwnProperty('errors') && Object.keys(data.errors).length !== 0) {
    if(useSwal){

      swalData = createErrorsList(data.errors);
        var elem = document.createElement("div");
        elem.innerHTML = swalData;
      setTimeout(function() {
        swal({
          type: 'warning',
          title: "Please correct the following error(s)",
            content: elem
        });
      }, 100);
    }else{
      submitErrors(data.errors);
    }

  } else if (data.hasOwnProperty('success') && data.success == "19199212") {
if(useSwal){
       swal({

           text: data.message,
           type: "success"
       }).then(function(){
         window.location.reload();
       });

     }else{
       submitSuccess(data.message);
     }
  }else{
    oops();
  }
}

function submitErrors(errors){
  $("#"+formId+"Errors").html(createErrorsList(errors));
  $("#"+formId+"Errors").show("slow");
}
function submitSuccess(data){
  var datahtml = '<p class="text-success">'+data+'</p>';
  $("#"+formId+"Errors").html(datahtml);
  $(".modal").modal("hide");
  if (reloadAfterSubmit) {
    window.location.reload();
  }
}

function submitData(formId, type) {
  submitForm(new FormData(document.querySelector("#" + formId)));
}

function getData(id) {
  var xhttp;
  if (window.XMLHttpRequest) {
    xhttp = new XMLHttpRequest();
  } else {
    // code for IE6, IE5
    xhttp = new ActiveXObject("Microsoft.XMLHTTP");
  }
  xhttp.addEventListener("load", function() {
    url = baseUrl + id;
    GetResultHandler(JSON.parse(this.responseText));

  });
  xhttp.addEventListener("error", function() {
    oops();
  });
  if (id != null) {
    xhttp.open("GET", baseUrl +"/"+id, false);

  } else {
    xhttp.open("GET", url, false);

  }
  xhttp.send();
}

function oops() {
  if(useSwal){
    setTimeout(function() {
      swal("Oops !! Something went wrong", "Please try again", "error");
    }, 100);
  }else{
    customOops();
  }

}

function customOops(){

}

function GetResultHandler(data) {
  if (data.hasOwnProperty('errors')) {
    oops();
  } else if (data.hasOwnProperty('success') && data.success == "19199212") {
      try {
          swal.close();
      } catch (error) {
          console.error("Swal not found", error);
      }

      resetForm(formId);
    Object.keys(data.data).forEach(function(key) {
      $('.form-line').addClass('focused');
      $('input[name="' + key + '"]').val(data.data[key]);
      $('textarea[name="'+key+'"]').val(data.data[key]);
        $('select[name="' + key + '"]').val(data.data[key]).change();
    });

      $('#addModal').modal('show');
  }
}

function createErrorsList(errors){
  var retData = '<ul style="color:red; text-align:left;">';

  Object.keys(errors).forEach(function(key) {

    retData += '<li>' + errors[key] + '</li>';
  });
  retData += '</ul>';
  return retData;
}

function showForm() {
    resetForm(formId);

    $('#addModal').modal('show')

}
