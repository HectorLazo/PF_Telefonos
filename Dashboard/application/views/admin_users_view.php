<?php include('application/views/header.php'); ?>

    <div id="page-wrapper">

        <div class="container">

            <h3>Administración de Usuarios</h3>
            <br />
            <button class="btn btn-success" onclick="add_usuario()"><i class="glyphicon glyphicon-plus"></i> Agregar Usuario</button>
            <!--<button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Recargar</button>
            <button id="status_btn" class="btn btn-primary" onclick="reload_table_btn()"><i class="glyphicon glyphicon-ok-circle"></i> Activos</button>
            <button id="status_btn_2" class="btn btn-warning hidden" onclick="reload_table_btn()"><i class="glyphicon glyphicon-ok-circle"></i> Inactivos</button>-->
            <br />
            <br />
            <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nombre de usuario</th>
                        <th>Rol</th>
                        <th>Fecha Ingreso</th>
                        <th>Creado por</th>
                        <th>Modificado por</th>
                        <th>Última modificación</th>
                        <th style="width:125px;">Action</th>
                    </tr>
                </thead>

                <tbody>

                </tbody>

                <tfoot>
                <tr>
                    <th>Nombre de usuario</th>
                    <th>Rol</th>
                    <th>Fecha Ingreso</th>
                    <th>Creado por</th>
                    <th>Modificado por</th>
                    <th>Última modificación</th>>
                    <th>Action</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    </body>

    <script src="<?php echo base_url('assets/jquery/jquery-2.1.4.min.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('assets/datatables/js/dataTables.bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>

    <script type="text/javascript">

    var table;
    var save_method;

    $(document).ready(function() {

        //datatables
        table = $('#table').DataTable({ 

            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url":"<?php echo site_url('usuario/listado2')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
            { 
                "targets": [ -1 ], //last column
                "orderable": true, //set not orderable
            },
            ],

        });

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

    function add_usuario()
    {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('[name="USUID"]').prop("readonly", false);
        $('[name="USUNOMBRE"]').prop("readonly", false);
        $('[name="USUPASSWORD"]').prop("readonly", false);
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Agregar nuevo Usuario'); // Set Title to Bootstrap modal title
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

        if(save_method == 'add') 
        {
            /*url = "<?php echo site_url('person/ajax_add_users')?>";*/
            url = "<?php echo site_url('usuario/agregar')?>";
        } 
        else 
        {
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
                    //$('[name="p_id2"]').prop("readonly", false);
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
    function delete_user(id)
    {
        if(confirm('Seguro que desea eliminar este usuario?'))
        {
            // ajax delete data to database
            $.ajax({
                url : "<?php echo site_url('usuario/ajax_delete_usuario')?>/"+id,
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
                    <h3 class="modal-title">Agregar usuario</h3>
                </div>
                <div class="modal-body form">
                    <div id="ventana">
                    <form action="#" id="form" class="form-horizontal">
                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Id de usuario</label>
                                <div class="col-md-9">
                                    <input name="USUID" id="id_usuario" placeholder="Id de usuario" class="form-control" type="text" >
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nombre de usuario</label>
                                <div class="col-md-9">
                                    <input name="USUNOMBRE" id="nombre_usuario" placeholder="Nombre de usuario" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <!--select rolnombre-->
                            <div class="form-group">
                                <div class="col-md-3">
                                    <label class="control-label">Rol de usuario</label>
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control" name="ROLNOMBRE" id="rol">
                                        <option value="1">Administrador</option>
                                        <option value="2">Usuario</option>
                                        <option value="3">Vendedor</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Password</label>
                                <div class="col-md-9">
                                    <input name="USUPASSWORD" id="password" placeholder="Ingrese password" class="form-control" type="password">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="estado">...</div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" name="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->



</html>