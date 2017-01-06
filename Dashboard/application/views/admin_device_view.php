<?php include('application/views/header.php'); ?>
       
    <div id="page-wrapper">

    <div class="container">

        <h3>Administración de Telefonos</h3>
        <br />
        <button class="btn btn-success" onclick="add_device()"><i class="glyphicon glyphicon-plus"></i> Agregar Telefono</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
        <button id="status_btn" class="btn btn-primary" onclick="reload_table_btn()"><i class="glyphicon glyphicon-ok-circle"></i> Activos</button>
        <button id="status_btn_2" class="btn btn-warning hidden" onclick="reload_table_btn()"><i class="glyphicon glyphicon-ok-circle"></i> Inactivos</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>IMEI</th>
                    <th>Modelo</th>
                    <th style="width:125px;">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>IMEI</th>
                <th>Modelo</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>

   </div>

<script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
<script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
<script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>


<script type="text/javascript">

var save_method; //for save method string
var table;
var id = 1;

$(document).ready(function() {

    //datatables
    table = $('#table').DataTable({ 

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url":"<?php echo site_url('person/ajax_list_index/')?>/"+id,
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
    $('#modal_form').modal('show'); // show bootstrap modal
    $('[name="div_motivo"]').hide(); // show bootstrap modal
    $('[name="div_modelo"]').show();
    $('[name="div_descp"]').show();
    $('.modal-title').text('Agregar nuevo Telefono'); // Set Title to Bootstrap modal title
}

function edit_device(id)
{
    save_method = 'update';
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

            $('[name="p_modelo"]').val(data.POS_DEVICE);
            $('[name="p_id2"]').val(data.POS_IMEI);
            $('[name="p_id2"]').prop("readonly", true);
            $('[name="p_descripcion"]').val(data.POS_DESCRIPTION);
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit Pos'); // Set title to Bootstrap modal title

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

function reload_table_btn()
{
    if(id == 1)
    {
        id = 0;
        $(status_btn_2).removeClass("hidden");
        $(status_btn).addClass("hidden");
    }
    else if(id == 0)
    {
        id = 1;
        $(status_btn).removeClass("hidden");
        $(status_btn_2).addClass("hidden");
    }
    table.ajax.url("<?php echo site_url('person/ajax_list_index/')?>/"+id).load();
    //reload_table();
}

function save()
{
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('person/ajax_add_index')?>";
    } if(save_method=='update') {
        url = "<?php echo site_url('person/ajax_update_index')?>";
    }
    if(save_method=='del'){
        url = "<?php echo site_url('person/ajax_delete_index')?>";

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

/*function delete_device(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data to database
        $.ajax({
            url : "<?php echo site_url('person/ajax_delete_index')?>/"+id,
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
}*/

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
            $('[name="div_motivo"]').show();
            $('[name="div_modelo"]').hide();
            $('[name="div_descp"]').hide();
            
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Desactivar Telefono'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

</script>

<!-- Bootstrap modal Insert -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Device Form</h3>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                                           
                    <div class="form-body">
                        <div class="form-group">
                            <label class="control-label col-md-3">IMEI</label>
                            <div class="col-md-9">
                                <input  name="p_id2" id="p_id2"  placeholder="IMEI" class="form-control" type="text" >
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group" name="div_modelo">
                            <label class="control-label col-md-3">Modelo</label>
                            <div class="col-md-9">
                                <input name="p_modelo" id="p_modelo" placeholder="Modelo" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                       <div class="form-body" name="div_descp">
                        <div class="form-group">
                            <label class="control-label col-md-3">Descripcion</label>
                            <div class="col-md-9">
                                <textarea name="p_descripcion" placeholder="Descripcion" rows="5" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        </div>

                        <div class="form-body" name="div_motivo">
                        <div class="form-group">
                            <label class="control-label col-md-3">Motivo Desactivacion</label>
                            <div class="col-md-9">
                                <textarea name="p_motivo" placeholder="Motivo Desactivacion" rows="5" class="form-control"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        </div>
                    <!--
                        <div class="form-group">
                            <label class="control-label col-md-3">Date of Entry </label>
                            <div class="col-md-9">
                                <input name="dob" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div> 
                    </div>-->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal Insert -->


</body>
</html>