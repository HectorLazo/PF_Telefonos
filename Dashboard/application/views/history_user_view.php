<?php include('application/views/header.php'); ?>
       
    <div id="page-wrapper">

            <div class="container-fluid">

    <div class="container">

        <h3>Historial <?php print($POS_NOMBRE) ?> </h3>

<div class="jumbotron">

    <label>Codigo Vendedor     :<?php print($POS_VDDR_ID) ?>   </label>
    <br>
    <label>Numero Telefono     : <?php print($POS_CELULAR) ?>   </label>
    <br>
    <label>Email               : <?php print($POS_EMAIL) ?>   </label>
    <br>
    <label>Oficina               : <?php print($POS_NAME_OFFICE) ?>   </label>

</div>

        <br />
        <button class="btn btn-success" onclick="add_device(<?php print($POS_VDDR_ID) ?>)"><i class="glyphicon glyphicon-plus"></i> Agregar Telefono</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>IMEI</th>
                    <th>Modelo</th>
                    <th>Numero</th>
                    <th>Contraseña Email</th>
                    <th>Fecha Entrega</th>
                    <th>Fecha Devolucion</th>
                    <th>Motivo Devolucion</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
               <th>IMEI</th>
                <th>Modelo</th>
                <th>Numero</th>
                <th>Contraseña Email</th>
                <th>Fecha Entrega</th>
                <th>Fecha Devolucion</th>
                <th>Motivo Devolucion</th>
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
        function randomString(length, chars) {
            var email=document.getElementById("p_email2").value;
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
    var email=document.getElementById("p_email2").value;
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



<script type="text/javascript">

var save_method; //for save method string
var table;
id=<?php print($POS_VDDR_ID) ?> ;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url":"<?php echo site_url('person/ajax_list_users/')?>/"+id,
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
        format: "dd/mm/yyyy",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
         defaultDate: new Date(),
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


function add_device(id)
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax


    $.ajax({
        url : "<?php echo site_url('person/ajax_edit_users/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            if(data==null){
            $('[name="div_numero"]').show();
            $('[name="div_cod_dendedor"]').show();
            $('[name="div_nom_vendedor"]').show();
            $('[name="div_email"]').show();
            $('[name="div_oficina"]').show();
            $('[name="div_modelo"]').show();
            $('[name="div_motivo"]').hide();
            $('[name="div_password"]').hide();
            $('[name="btnGenerate"]').hide();
            $('[name="p_id2"]').prop("readonly", false);
            $('[name="p_cod_vendedor"]').val('<?php print($POS_VDDR_ID) ?>');
            $('[name="p_cod_vendedor"]').prop("readonly", true);
            $('[name="p_nom_vendedor"]').val('<?php print($POS_NOMBRE) ?>');
            $('[name="p_nom_vendedor"]').prop("readonly", true);
            $('[name="p_email"]').val('<?php print($POS_EMAIL) ?>');
            $('[name="p_email"]').prop("readonly", true);
            $('[name="p_oficina"]').val('<?php print($POS_OFFICE_ID) ?>');
            $('[name="p_nom_oficina"]').val('<?php print($POS_NAME_OFFICE) ?>');
            $('[name="btnSave"]').show();
            $('#estado').html('...');

            //$('[name="p_descripcion"]').val(data.POS_DESCRIPTION);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Agregar Telefono'); // Set title to Bootstrap modal title


            }
            else{
                alert("Usuario ya se encuentra con un Telefono Activo")
            }
            
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
        url = "<?php echo site_url('person/ajax_add_users')?>";
    }

    if (save_method=='pass'){
        url = "<?php echo site_url('person/ajax_pass_user_history')?>";
    }
    if(save_method=='del') {
        url = "<?php echo site_url('person/ajax_delete_user_history')?>";
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
                $('[name="p_id2"]').prop("readonly", false);

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

function delete_device(id)
{
    save_method = 'del';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('person/ajax_edit_index/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="p_id2"]').val(data.POS_IMEI);
            $('[name="p_id2"]').prop("readonly", true);
            $('[name="div_numero"]').hide();
            $('[name="div_cod_dendedor"]').hide();
            $('[name="div_nom_vendedor"]').hide();
            $('[name="div_email"]').hide();
            $('[name="div_oficina"]').hide();
            $('[name="div_modelo"]').hide();
            $('[name="div_motivo"]').show();
            $('[name="div_password"]').hide();
            $('[name="btnGenerate"]').hide();
            $('#estado').html('...');
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Desativar Telefono'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function password_device(id)
{
    save_method = 'pass';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('person/ajax_edit_index/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="p_id2"]').val(data.POS_IMEI);
            $('[name="p_id2"]').prop("readonly", true);
            $('[name="div_numero"]').hide();
            $('[name="div_cod_dendedor"]').hide();
            $('[name="div_nom_vendedor"]').hide();
            $('[name="div_email"]').hide();
            $('[name="div_oficina"]').hide();
            $('[name="div_modelo"]').hide();
            $('[name="div_motivo"]').hide();
            $('[name="div_password"]').show();
            $('[name="btnGenerate"]').show();
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Crear Contraseña'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function history_user(id){
    
   // window.locationf ("<?php echo site_url('person/admin_device_history')?>/"+id);
   window.location=("<?php echo site_url('person/admin_device_user_history')?>/"+id);
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

                        <div class="form-group" name="div_modelo">
                            <label class="control-label col-md-3">Modelo Telefono</label>
                            <div class="col-md-9">
                                <input name="p_modelo" id="p_modelo" placeholder="Modelo Telefono" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group" name="div_numero">
                            <label class="control-label col-md-3">Numero Telefono</label>
                            <div class="col-md-9">
                                <input name="p_numero" id="p_numero" placeholder="Numero Telefono" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group" name="div_cod_dendedor">
                            <label class="control-label col-md-3">Codigo Vendedor</label>
                            <div class="col-md-9">
                                <input name="p_cod_vendedor" id="p_cod_vendedor" placeholder="Codigo Vendedor" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group" name="div_nom_vendedor">
                            <label class="control-label col-md-3">Nombre Vendedor</label>
                            <div class="col-md-9">
                                <input name="p_nom_vendedor" id="p_nom_vendedor" placeholder="Nombre Vendedor" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group" name="div_email">
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-9">
                                <input name="p_email" id="p_email" placeholder="Email" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group" name="div_oficina">
                            <label class="control-label col-md-3" name="nom_oficina">Oficina</label>
                            <div class="col-md-9">
                                <input name="p_nom_oficina" placeholder="" class="form-control" readonly>
                                <input name="p_oficina" placeholder="" class="form-control" type="hidden" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <input name="p_cod_vendedor2" placeholder="" class="form-control" type="hidden" value="<?php print($POS_VDDR_ID) ?>" readonly>

                        <div class="form-group" name="div_motivo">
                            <label class="control-label col-md-3">Motivo</label>
                            <div class="col-md-9">
                                <textarea name="p_motivo" placeholder="Motivo" rows="5" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group" name="div_password">
                            <label class="control-label col-md-3">Password</label>
                            <div class="col-md-9">
                                <input name="p_pass" id="pwd" placeholder="Password" class="form-control" type="text" readonly>
                                <span class="help-block"></span>
                            </div>
                            <input name="p_cod_vend2" placeholder="" class="form-control" type="hidden" readonly value="<?php print($POS_VDDR_ID) ?>">
                            <input name="p_email2" id="p_email2" placeholder="" class="form-control" type="hidden" readonly value="<?php print($POS_EMAIL) ?>">
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
                <button name='btnGenerate' type="button" id="btnGenerate" onclick="validarEmail()" class="btn btn-primary">Generate Password</button>
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


</body>
</html>