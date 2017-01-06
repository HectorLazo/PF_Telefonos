<?php include('application/views/header.php'); ?>
       
    <div id="page-wrapper">

            <div class="container-fluid">

    <div class="container">

        <h3>Administración de Usuarios</h3>
        <br />
        <button class="btn btn-success" onclick="add_device()"><i class="glyphicon glyphicon-plus"></i> Agregar Telefono</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>IMEI</th>
                    <th>Modelo</th>
                    <th>Vendedor</th>
                    <th>Codigo Vendedor</th>
                    <th>Numero</th>
                    <th>Email</th>
                    <th>Oficina</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>IMEI</th>
                <th>Modelo</th>
                <th>Vendedor</th>
                <th>Codigo Vendedor</th>
                <th>Numero</th>
                <th>Email</th>
                <th>Oficina</th>
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
id=0;

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



function add_device()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('[name="p_id2"]').prop("readonly", false);
    $('[name="p_nom_vendedor"]').prop("readonly", false);
    $('[name="p_email"]').prop("readonly", false);
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Agregar nuevo Telefono'); // Set Title to Bootstrap modal title
    $('[name="btnSave"]').show();
    $('#estado').html('...');
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
    } else {
        url = "<?php echo site_url('person/ajax_update_index')?>";
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

function history_user(id){
    
   // window.locationf ("<?php echo site_url('person/admin_device_history')?>/"+id);
   window.location=("<?php echo site_url('person/user_history')?>/"+id);
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
                            <label class="control-label col-md-3">Modelo Telefono</label>
                            <div class="col-md-9">
                                <input name="p_modelo" id="p_modelo" placeholder="Modelo Telefono" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Numero Telefono</label>
                            <div class="col-md-9">
                                <input name="p_numero" id="p_numero" placeholder="Numero Telefono" class="form-control" type="text">
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

                        <div class="form-group" name="div_oficina">
                            <label class="control-label col-md-3" name="nom_oficina">Oficina</label>
                            <div class="col-md-9">
                                <input name="p_nom_oficina" placeholder="" class="form-control" readonly>
                                <input name="p_oficina" placeholder="" class="form-control" type="hidden" readonly>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <input name="p_nom_oficina" placeholder="" class="form-control" type="hidden" readonly>

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
                <button type="button" id="btnSave" name="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->


</body>
</html>