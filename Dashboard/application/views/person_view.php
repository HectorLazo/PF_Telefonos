<!DOCTYPE html>
<html>
    <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PF Alimentos</title>
    <link href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/datatables/css/dataTables.bootstrap.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/sb-admin.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
    function randomString(length, chars) {
        var email=document.getElementById("p_email").value;
        var a = email.substr(0, 1);
        var b = email.substr(email.indexOf("."), 2);
        var mask = '';
        if (chars.indexOf('a') > -1) mask += 'abcdefghijklmnopqrstuvwxyz';
        if (chars.indexOf('A') > -1) mask += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if (chars.indexOf('#') > -1) mask += '0123456789';
        if (chars.indexOf('!') > -1) mask += '!@#$%&*_+-=:;<>?,.';
        var result = '';
        for (var i = length; i > 0; --i) result += mask[Math.round(Math.random() * (mask.length - 1))];
            document.getElementById("pwd").value = a+b+"!@pf"+result;
        return result;
        //document.getElementById("pwd").innerHTML = result;
        
    }

    function validarEmail() {
        var email=document.getElementById("p_email").value;
        var a = email.substr(1, 1);
        expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if ( !expr.test(email) ){
            alert("Error: La dirección de correo " + email + " es incorrecta.");
            document.getElementById("pwd").value = "";
        }
        else{
            randomString(4, '#A!');
        }
    }


    </script>

    <script>

    $(function(){
     /* Ponemos evento blur a la escucha sobre id nombre en id cliente. */
     $('#ventana').on('blur','#imei',function(){
      /* Obtenemos el valor del campo */
      var valor = this.value;
      /* Si la longitud del valor es mayor a 2 caracteres.. */
      if(valor.length>=3){

       /* Cambiamos el estado.. */
       $('#estado').html('Cargando datos de servidor...'+valor);

       /* Hacemos la consulta ajax */
       $.ajax({
        url : "<?php echo site_url('person/ajax_edit_device/')?>/" + valor,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="p_modelo"]').val(data.POS_DEVICE);
            $('[name="p_modelo"]').prop("readonly", true);
            $('#estado').html('...');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });

       /* En caso de que se haya retornado bien.. */


       /* Si la consulta ha fallado.. */


   } else {
       /* Mostrar error */
       $('#estado').html('IMEI no reconocido...');
       return false;
   }
});
})
</script>

<script>
$(function(){
 /* Ponemos evento blur a la escucha sobre id nombre en id cliente. */
 $('#ventana').on('blur','#p_cod_vendedor',function(){
  /* Obtenemos el valor del campo */
  var valor1 = this.value;
  /* Si la longitud del valor es mayor a 2 caracteres.. */
  if(valor1.length>=3){

   /* Cambiamos el estado.. */
   $('#estado').html('Cargando datos de servidor...'+valor1);

   /* Hacemos la consulta ajax */
   $.ajax({
    url : "<?php echo site_url('person/ajax_find_tab_pos/')?>/" + valor1,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {

        $('[name="p_nom_vendedor"]').val(data.POS_NOMBRE);
        $('[name="p_nom_vendedor"]').prop("readonly", true);
        $('[name="p_email"]').val(data.POS_EMAIL);
        $('[name="p_email"]').prop("readonly", true);
        $('[name="p_oficina"]').val(data.POS_OFFICE_ID);
        $('[name="p_nom_oficina"]').val(data.OFF_NAME);
        $('#estado').html(data.POS_VDDR_ID);
    },
    error: function (jqXHR, textStatus, errorThrown)
    {
        alert('Error get data from ajax');
        $('#estado').html("Error al obtener Datos");
    }
});

   /* En caso de que se haya retornado bien.. */


   /* Si la consulta ha fallado.. */


} else {
   /* Mostrar error */
   $('#estado').html('El nombre tener una longitud mayor a 2 caracteres...');
   return false;
}
});
});
</script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head> 
<body>

  <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">PF Alimentos</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> Nombre Usuario <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                       
                       
                   
                        <li class="divider"></li>
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-off "></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="#"><i class="glyphicon glyphicon-menu-hamburger"></i> Dashboard</a>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="glyphicon glyphicon-cog"></i> Admin Pos <i class="glyphicon glyphicon-triangle-bottom"></i></a>
                        <ul id="demo" class="collapse">
                             <li>
                        <a href="<?php echo site_url('person/index')?>"><i class="glyphicon glyphicon-phone"></i>ADD New Pos </a>
                            </li>
                            <li>
                        <a href="<?php echo site_url('person/adm_device')?>"><i class="glyphicon glyphicon-lock"></i> Password Pos Email</a>
                            </li>
                           
                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="glyphicon glyphicon-menu-hamburger"></i> Admin Device <i class="glyphicon glyphicon-triangle-bottom"></i></a>
                        <ul id="demo1" class="collapse">
                            <li>
                        <a href="<?php echo site_url('person/admin_device_user')?>"><i class="glyphicon glyphicon-user"></i> User </a>
                            </li>
                            <li>
                        <a href="<?php echo site_url('person/admin_device')?>"><i class="glyphicon glyphicon-phone"></i> Device </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

    <div class="container">

        <h3>ADMINISTRATION</h3>
        <br />
        <button class="btn btn-success" onclick="add_device()"><i class="glyphicon glyphicon-plus"></i> Add New Pos</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>IMEI</th>
                    <th>CODIGO VENDEDOR</th>
                    <th>NOMBRE POS</th>
                    <th>OFICINA</th>
                    <th>EMAIL</th>
                    <th>POS DEVICE</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>IMEI</th>
                <th>CODIGO VENDEDOR</th>
                <th>NOMBRE POS</th>
                <TH>OFICINA</TH>
                <th>EMAIL</th>
                <th>POS DEVICE</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>

<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>


<script type="text/javascript">

var save_method; //for save method string
var table;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('person/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],

    });

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

    //set input/textarea/select event when change value, remove class error and remove text help block 
    $("input").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("textarea").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });
    $("select").change(function(){
        $(this).parent().parent().removeClass('has-error');
        $(this).next().empty();
    });

});



function add_device()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('[name="p_id2"]').prop("readonly", false);
    $('[name="p_cod_vendedor"]').prop("readonly", false);
    $('[name="p_nom_vendedor"]').prop("readonly", false);
    $('[name="p_email"]').prop("readonly", false);
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Add Question'); // Set Title to Bootstrap modal title
}

function edit_device(id)
{
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('person/ajax_edit_adm_pos_pass/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="p_cod_vendedor"]').val(data.POS_VDDR_ID);
            $('[name="p_cod_vendedor"]').prop("readonly", true);
            $('[name="p_nom_vendedor"]').val(data.POS_NOMBRE);
            $('[name="p_nom_vendedor"]').prop("readonly", true);
            $('[name="p_modelo"]').val(data.POS_DEVICE);
            $('[name="p_modelo"]').prop("readonly", true);
            $('[name="p_oficina"]').val(data.POS_OFFICE_ID);
            $('[name="p_email"]').val(data.POS_EMAIL);
            $('[name="p_email"]').prop("readonly", true);
            $('[name="p_pass"]').val(data.PASS_MAIL);
            $('[name="p_id2"]').val(data.POS_IMEI);
            $('[name="p_id2"]').prop("readonly", true);
            $('[name="p_text"]').val(data.PRE_TEXT);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Poss'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function reload_table()
{
    table.ajax.reload(null,false); //reload datatable ajax 
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('person/ajax_add_adm_pos_pass')?>";
    } else {
        url = "<?php echo site_url('person/ajax_update_adm_device')?>";
    }

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }
            else
            {
                for (var i = 0; i < data.inputerror.length; i++) 
                {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                }
            }
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
}

function delete_person(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('person/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });

    }
}

</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Person Form</h3>
            </div>
            <div class="modal-body form">
                <div id="ventana">
                <form action="#" id="form" class="form-horizontal">
                    
                    <div class="form-body">

                      
                        <div class="form-group">
                            <label class="control-label col-md-3">IMEI</label>
                            <div class="col-md-9">
                                <input name="p_id2" id="imei" placeholder="IMEI" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Codigo Vendedor</label>
                            <div class="col-md-9">
                                <input name="p_cod_vendedor" id="p_cod_vendedor" placeholder="Codigo Vendedor" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Nombre Vendedor</label>
                            <div class="col-md-9">
                                <input name="p_nom_vendedor" id="p_nom_vendedor" placeholder="Nombre Vendedor" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input name="p_email" id="p_email" placeholder="Email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Modelo Telefono</label>
                            <div class="col-md-9">
                                <input name="p_modelo" id="p_modelo" placeholder="Modelo Telefono" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3" name="nom_oficina">Oficina</label>
                            <div class="col-md-9">
                                <select name="p_oficina" id="selectID" class="form-control">
                                    <option value="">--Select Oficina--</option>
                                    <option value="10">  ARICA</option>
                                    <option value="15">  IQUIQUE </option>
                                    <option value="16">  ZOFRI</option>
                                    <option value="20">  ANTOFAGASTA</option>
                                    <option value="25">  COPIAPO</option>
                                    <option value="30">  SERENA</option>
                                    <option value="35">  CON-CON</option>
                                    <option value="37">  STGO_COSTA</option>
                                    <option value="39">  STGO ORIENTE</option>
                                    <option value="40">  STGO PONIENTE</option>
                                    <option value="41">  STGO NORTE</option>
                                    <option value="42">  STGO_C</option>
                                    <option value="43">  STGO_INS</option>
                                    <option value="44">  SUP_STGO</option>
                                    <option value="45">  STGO_V</option>
                                    <option value="46">  STGO_MAY</option>
                                    <option value="47">  STGO SUR</option>
                                    <option value="48">  RANCAGUA</option>
                                    <option value="49">  EXPORTAC</option>
                                    <option value="50">  TALCA</option>
                                    <option value="60">  CONCEPCION</option>
                                    <option value="62">  CHILLAN</option>
                                    <option value="65">  TEMUCO</option>
                                    <option value="80">  PUERTO MONTT</option>
                                    <option value="81">  COYHAIQUE</option>
                                    <option value="90">  PUNTA ARENAS</option>
                                    <option value="98">  VARIOS</option>
                            
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <input name="p_nom_oficina" placeholder="" class="form-control" type="hidden" readonly>


                        <div class="form-group">
                            <label class="control-label col-md-3">Password</label>
                            <div class="col-md-9">
                                <input name="p_pass" id="pwd" placeholder="" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <!--
                        <div class="form-group">
                            <label class="control-label col-md-3">Date of Birth</label>
                            <div class="col-md-9">
                                <input name="dob" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                    </div>-->
                </form>
            </div>
            <div id="estado">...</div>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnGenerate" onclick="validarEmail()" class="btn btn-primary">Generate Password</button>
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
</body>
</html>