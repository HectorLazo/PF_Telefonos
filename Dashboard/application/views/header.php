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
    <style>
    strong { 
        font-weight: bold;
        color:red
    }
    </style>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
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
        url : "<?php echo site_url('person/ajax_edit_index/')?>/" + valor,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            if(data==null){
                $('[name="p_modelo"]').val('');
                $('#estado').html('<strong>IMEI no reconocido '+valor+'</strong>');
                $('[name="btnSave"]').hide();

            }else{
                var var_modelo=data.POS_DEVICE;

                $.ajax({
                    url : "<?php echo site_url('person/ajax_valida_act_imei/')?>/" + valor,
                    type: "GET",
                    dataType: "JSON",
                    success: function(data)
                    {

                        if(data==null){
                            $('[name="p_modelo"]').val(var_modelo);
                            $('[name="p_modelo"]').prop("readonly", true);
                            $('[name="btnSave"]').show();
                            $('#estado').html('...');

                        }else{
                            $('[name="btnSave"]').hide();
                            $('[name="p_modelo"]').val('');
                            $('#estado').html('<strong>IMEI Asociado a Otro Usuario</strong>');


                        }


                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error get data from ajax');
                    }
                });

}

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
   $('#estado').html('Cargando datos...'+valor1);

   /* Hacemos la consulta ajax */
   $.ajax({
    url : "<?php echo site_url('person/ajax_find_tab_pos/')?>/" + valor1,
    type: "GET",
    dataType: "JSON",
    success: function(data)
    {
        if(data==null){
            alert(data);
            $('#estado').html('<strong>Vendedor no reconocido '+valor1+'</strong>');
            $('[name="btnSave"]').hide();

        }
        else{
            var var_nom_vendedor=data.POS_NOMBRE;
            var var_cod_oficina=data.OFF_ID;
            var var_nom_oficina=data.OFF_NAME;
            var var_email=data.POS_EMAIL;

            $.ajax({
                url : "<?php echo site_url('person/ajax_valida_act_vend/')?>/" + valor1,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                    if(data==null){
                        $('[name="p_nom_vendedor"]').val(var_nom_vendedor);
                        $('[name="p_nom_vendedor"]').prop("readonly", true);
                        $('[name="p_email"]').val(var_email);
                        $('[name="p_email"]').prop("readonly", true);
                        $('[name="p_oficina"]').val(var_cod_oficina);
                        $('[name="p_oficina"]').prop("readonly", true);
                        $('[name="p_nom_oficina"]').val(var_nom_oficina);
                        $('[name="btnSave"]').show();
                        $('#estado').html('...');

                    }else{
                        $('[name="p_nom_vendedor"]').val('');
                        $('[name="p_email"]').val('');
                        $('[name="p_nom_oficina"]').val('');
                        $('#estado').html('<strong>Vendedor Asociado a Otro Telefono</strong>');
                        $('[name="btnSave"]').hide();

                    }


                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });

}


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
   $('#estado').html('El nombre debe tener una longitud mayor a 2 caracteres...');
   return false;
}
});
});
</script>
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
            <a class="navbar-brand" href="#"><img src="<?php echo base_url('assets/imagenes/pf.png')?>" width="80"></a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> 

                    <?php
                    if($this->session->userdata()==NULL)
                    {
                        echo "nombre de usuario";
                    }
                    else
                    {
                        echo $this->session->userdata('USUNOMBRE');
                    }
                    ?>
                    <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li class="divider"></li>
                        <li>
                            <a href="cerrar"><i class="glyphicon glyphicon-off "></i>
                               Cerrar sesión
                           </a>
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
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="glyphicon glyphicon-cog"></i> Administración Teléfono <i class="glyphicon glyphicon-triangle-bottom"></i></a>
                    <ul id="demo" class="collapse">
                        <li>
                            <a href="<?php echo site_url('person/index')?>"><i class="glyphicon glyphicon-phone"></i> Teléfonos </a>
                        </li>
                        <li>
                            <a href="<?php echo site_url('person/users')?>"><i class="glyphicon glyphicon-user"></i> Usuarios Télefono </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="glyphicon glyphicon-wrench"></i> Administración Usuarios <i class="glyphicon glyphicon-triangle-bottom"></i></a>
                    <ul id="demo1" class="collapse">
                       <li>
                        <a href="<?php echo site_url('usuario/index2')?>"><i class="glyphicon glyphicon-user"></i> Usuarios </a>
                    </li>
                </li>

            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>