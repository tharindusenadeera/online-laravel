@extends('includes.app')
@section('title', 'Dashboard')
@section('content')
  <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Menu
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
        <section class="content">
      <div class="row">
        <div class="col-lg-12 col-xs-12">
              <!-- Horizontal Form -->
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Create Menu Item</h3>
                  <a  href="/menu-item" class="btn btn-primary pull-right">Back to list</a>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" id="menuItemForm">
                <input type="hidden" name="id" form="menuItemForm">
                @csrf
                  <div class="box-body">
                  <div class="form-group">
                        <label for="menu_name" class="col-sm-2 control-label" >Menu name</label>
                        <div class="col-sm-10 control-label1">
                            <input type="text" class="form-control" autofocus form="menuItemForm" name="name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile" class="col-sm-2 control-label" >File input</label>
                        <div class="col-sm-10 control-label1">
                        <input type="file" id="imageUpload">
                        <input type="hidden" id="64baseimage" name="main_image">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="menu_categories" class="col-sm-2 control-label" >Menu Categories</label>
                        <div class="col-sm-10 control-label1">
                        <select class="form-control select2" id="menu_category"  name="menu_category">
                            @foreach($menuCategory as $key=> $category)
                                <option  value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="menu_categories" class="col-sm-2 control-label" >Menu options Categories</label>
                        <div class="col-sm-10 control-label1">
                        <select class="form-control select2" id="menu_categories">
                            @foreach($menuoptioncategories as $key=> $category)
                                <option data-index={{$key}} value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="menu_options" class="col-sm-2 control-label" >Menu options</label>
                        <div class="col-sm-10 control-label1">
                        <select  class="form-control select2" id="menu_options">
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label" >Selected</label>
                        <div class="col-sm-10 control-label1">
                            <button type="button" class="btn btn-primary"  onclick="addOption()">Add</button>
                            <table style="width:60%" id="item-table">
                            </table>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="menu_categories" class="col-sm-2 control-label" >Addons</label>
                        <div class="col-sm-10 control-label1">
                        <select class="form-control select2" id="addons">
                            @foreach($addons as $key=> $addon)
                                <option  value="{{$addon->id}}">{{$addon->name}}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label" >Selected</label>
                        <div class="col-sm-10 control-label1">
                            <button type="button" class="btn btn-primary"  onclick="addAddons()">Add</button>
                            <table style="width:60%" id="addons-table">
                            </table>
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="price" class="col-sm-2 control-label" >Price</label>
                        <div class="col-sm-10 control-label1">
                        <input type="text" class="form-control" id="price" name="price">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="qty" class="col-sm-2 control-label" >Qty</label>
                        <div class="col-sm-10 control-label1">
                        <input type="text" class="form-control" id="qty" name="qty">
                        </div>
                    </div>
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <!-- <button type="submit" class="btn btn-primary pull-right">Submit</button> -->
                    <button type="button" form="noForm" class="btn btn-primary FormSubmit pull-right" data-form="menuItemForm">Save</button>
                  </div>
                </form>
              </div><!-- /.box -->
        </div>
      </div>
      </div>

      <div class="modal imagecrop fade bd-example-modal-lg" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title">Image cropper</h5>
                </div>
                <div class="modal-body">
                <div class="img-cotainer">
                    <div class="row">
                    <div class="col-md-11">
                        <img src="" class='getimg' id='image'>
                    </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection


@section('aditionalJs')
<script type="text/javascript">

    var menuoption = <?php echo json_encode($menuoptioncategories); ?>;


    var array = [];
    var addons = [];
    // start use for request js
    baseUrl           = "{{url("menu-item")}}";
    url               = baseUrl;
    primaryKey        = "id"; // use to set update url
    reloadAfterSubmit = true;
    formId            = "menuItemForm";
    useSwal           = 1;
    // end use for request js


    /*
    |--------------------------------------------------------------------------
    |Doument ready function
    |--------------------------------------------------------------------------
    */
    $( document ).ready(function() {
        @if(isset($id))
            getData({{$id}});
        @endif


        $('.select2').select2();

        changeOption(0);
    });

    function GetResultHandler(data) { // overiding ajax request js function
        if (data.hasOwnProperty('errors')) {
            oops();
        } else if (data.hasOwnProperty('success') && data.success == "19199212") {
            if (data.data==null){window.location.replace("/menu-item");}
            resetForm("menuItemForm");
            Object.keys(data.data).forEach(function(key) {
            $('input[name="name"]').val(data.data["name"]);
            $('input[name="price"]').val(data.data["price"]);
            $('input[name="qty"]').val(data.data["qty"]);
            $('input[name="id"]').val(data.data["id"]);

            $('#menu_category').val(data.data["menu_category"]);
            $('#menu_category').trigger('change');

            });
            $( "#item-table" ).html('');
            $.each(data.data["menu_iitem_menu_option_category_menu_option"], function( key, value ) {
                if(value.menu_option_category_menu_option){
                    array.push(value.menu_option_category_menu_option.id);
                    $( "#item-table" ).append( $( '<tr><td><input type="hidden" class="hidden"  name="options[]" value='+value.menu_option_category_menu_option.id+'>'+value.menu_option_category_menu_option.menu_option_category.name+'</td><td>'+value.menu_option_category_menu_option.menu_option.name+'</td><td><button type="button" onclick="removeOption(this)" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></td></tr>' ) );
                }
            });

            $.each(data.data["active_menu_item_addons"], function( key, value ) {
                  addons.push(value.pivot.addon_id);
                  var element = '<tr>\
                                  <td style="padding: 5px;"><input type="hidden" class="hidden" name="addons[]" value="'+value.id+'">'+value.name+'</td><td><input type="number" id="amount" name="amount[]" value="'+value.pivot.amount+'"></td>\
                                  <td style="padding: 5px;"><button type="button" onclick="removeAddons(this)" class="close" aria-label="Close"><span aria-hidden="true">×</span></button></td>\
                                  </tr>';

                    $( "#addons-table" ).append(element);
            });

        }
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
            window.location.replace("{{route('menu-item.index')}}");
          });

        }else{
          submitSuccess(data.message);
        }
      }else{
        oops();
      }
    }


    $('#menu_categories').change(function(){
        var index = $(this).children('option:selected').data('index');
        changeOption(index);
    });


    /*
    |--------------------------------------------------------------------------
    |Change Options
    |--------------------------------------------------------------------------
    */
    function changeOption(index){

      var item = menuoption[index].category_menuoption;

      var childCategoriesDdl = $('#menu_options');
          childCategoriesDdl.empty();

      $.each(item, function(index, childCategory) {

          childCategoriesDdl.append(

              $('<option/>', {
                  value: childCategory.menu_option.id,
                  text: childCategory.menu_option.name
              })
          );
      });

  }

  /*
  |--------------------------------------------------------------------------
  |Add options
  |--------------------------------------------------------------------------
  */
  function addOption(){
      var index = $('#menu_categories').children('option:selected').data('index');
      var data  = menuoption[index].category_menuoption;

      var  val1  = $('#menu_categories').val();
      var  val2  = $('#menu_options').val();
      var text1  = $( "#menu_categories option:selected" ).text();
      var text2  = $( "#menu_options option:selected" ).text()

      function findIndexInData(data, property, value, property2, value2) {
          var result = -1;
          data.some(function (item, i) {
              if (item[property] == value && item[property2] == value2 ) {
                  result = i;
                  return true;
              }
          });
          return result;
      }

     var index = findIndexInData(data, 'menu_option_category_id', val1,'menu_option_id',val2); // shows index of

     if ($.inArray(data[index].id, array) != -1){
       return;
     }

     array.push(data[index].id);

     $( "#item-table" ).append( $( '<tr><td><input type="hidden" class="hidden"  name="options[]" value='+data[index].id+'>'+text1+'</td><td>'+text2+'</td><td><button type="button" onclick="removeOption(this)" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button></td></tr>' ) );

  };

  /*
  |--------------------------------------------------------------------------
  |Remove Options
  |--------------------------------------------------------------------------
  */
  function removeOption(ele){
      var element        =  $(ele).closest('tr');
      let remove_value   =  parseInt(element.find('.hidden').val());
      var index          =  array.indexOf(remove_value);

      if (index !== -1) {
        array.splice(index, 1);
      }

      $(element).remove();


  }

  /*
  |--------------------------------------------------------------------------
  |Add Addons
  |--------------------------------------------------------------------------
  */
  function addAddons(){
    var  val  = $('#addons').val();
    var text  = $( "#addons option:selected" ).text();

    if ($.inArray(parseInt(val), addons) != -1){
       return;
    }

    addons.push(parseInt(val));

    var element = '<tr>\
                     <td style="padding: 5px;"><input type="hidden" class="hidden" name="addons[]" value="'+val+'">'+text+'</td><td><input type="number" id="amount" name="amount[]"></td>\
                     <td style="padding: 5px;"><button type="button" onclick="removeAddons(this)" class="close" aria-label="Close"><span aria-hidden="true">×</span></button></td>\
                     </tr>';

      $( "#addons-table" ).append(element);

  }

  /*
  |--------------------------------------------------------------------------
  |Remove Addons
  |--------------------------------------------------------------------------
  */
  function removeAddons(ele){
      var element        =  $(ele).closest('tr');
      let remove_value   =  element.find('.hidden').val();
      var index          =  addons.indexOf(parseInt(remove_value));


      if (index != -1) {
        addons.splice(index, 1);
      }

      $(element).remove();

  }

    /*
    |--------------------------------------------------------------------------
    |Image cropper function
    |--------------------------------------------------------------------------
    */
    var  $model = $('.imagecrop');
    var  $image = document.getElementById('image');
    var  cropper;


    $(document).on('change', '#imageUpload', function(e) {

      var files = e.target.files;

      var done = function(url){
        $image.src = url;
        $model.modal('show');
      }

      var reader;
      var file;
      var url;

      if(files && files.length>0){
          console.log('true');
          file = files[0];
          if(URL){
            done(URL.createObjectURL(file));
          }else if(FileReader){
            reader =  new FileReade();
            reder.onload = function(e){
              done(reader.result);
            }
            reader.readAsDataURL(file);
          }
      }

    });

    $model.on('shown.bs.modal', function(){
      cropper = new Cropper($image,{
        aspectRatio: 1,
        viewMode:1,
      });
    }).on('hidden.bs.modal', function(){
        if($( "#64baseimage" ).val()==""){
            $( "#imageUpload" ).val(null);
        }
        cropper.destroy(),
        cropper = null;
    });


    $(document).on('click', '#crop', function() {
        canvas = cropper.getCroppedCanvas({
          width:160,
          height:160,
        });

        canvas.toBlob(function(blob){
          url = URL.createObjectURL(blob);
          reader = new FileReader();
          reader.readAsDataURL(blob);
          reader.onload = function(e){
              var base64data = reader.result;
              $('#64baseimage').val(base64data);
              $model.modal('hide');
          }

        });

    });
</script>
@endsection
