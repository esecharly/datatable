<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datatable</title>
    <?php
    require_once "scripts.php";
    ?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card text-left">
                    <div class="card-header">
                        Tablas dinamicas con datatable y php
                    </div>
                    <div class="card-body">
                        <span class="btn btn-primary" data-toggle="modal" data-target="#agregarnuevosdatosmodal">
                            Agregar nuevo <span class="fas fa-plus-circle"></span>
                        </span>
                        <hr>
                        <div id="tablaDataTable"></div>
                    </div>
                    <div class="card-footer text-muted">
                        By esecharly
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" aria-labelledby="agregarnuevosdatosmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="agregarnuevosdatosmodalLabel">Agrega nuevos juegos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="frmnuevo">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control input-sm" name="nombre" id="nombre">
                        <label for="">Año</label>
                        <input type="text" class="form-control input-sm" name="anio" id="anio">
                        <label for="">Empresa</label>
                        <input type="text" class="form-control input-sm" name="empresa" id="empresa">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnAgregarnuevo">Agregar nuevo</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Actualizar Juego</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" id="frmnuevoU">
                        <input type="text" hidden id="idjuego" name="idjuego">
                        <label for="">Nombre</label>
                        <input type="text" class="form-control input-sm" name="nombreU" id="nombreU">
                        <label for="">Año</label>
                        <input type="text" class="form-control input-sm" name="anioU" id="anioU">
                        <label for="">Empresa</label>
                        <input type="text" class="form-control input-sm" name="empresaU" id="empresaU">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-warning" id="btnActualizar">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    $(document).ready(function() {
        $('#btnAgregarnuevo').click(function() {
            datos = $('#frmnuevo').serialize();

            $.ajax({
                type: "POST",
                data: datos,
                url: "procesos/agregar.php",
                success: function(r) {
                    if (r == 1) {
                        $('#frmnuevo')[0].reset();
                        $('#tablaDataTable').load('tabla.php');
                        alertify.success("Agregado con exito");
                    } else {
                        alertify.error("Fallo al agregar");
                    }
                }
            });
        });

        $('#btnActualizar').click(function() {
            datos = $('#frmnuevoU').serialize();

            $.ajax({
                type: "POST",
                data: datos,
                url: "procesos/actualizar.php",
                success: function(r) {
                    if (r == 1) {
                        $('#tablaDataTable').load('tabla.php');
                        alertify.success("Actualizado con exito");
                    } else {
                        alertify.error("Fallo al actualizar");
                    }
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#tablaDataTable').load('tabla.php');
    });
</script>

<script>
    function agregaFrmActualizar(idjuego) {
        $.ajax({
            type: "POST",
            data: "idjuego=" + idjuego,
            url: "procesos/obtenDatos.php",
            success: function(r) {
                datos = jQuery.parseJSON(r);
                $('#idjuego').val(datos['id_juego']);
                $('#nombreU').val(datos['nombre']);
                $('#anioU').val(datos['anio']);
                $('#empresaU').val(datos['empresa']);
            }
        });

    }

    function eliminarDatos(idjuego) {
        alertify.confirm('Eliminar juego', '¿Seguro que quieres eliminar el juego?', function() {
            $.ajax({
                type: "POST",
                data: "idjuego=" + idjuego,
                url: "procesos/eliminar.php",
                success: function(r) {
                   if (r == 1) {
                        $('#tablaDataTable').load('tabla.php');
                       alertify.success("Eliminado con exito");
                   }else{
                       alertify.error("No se pudo eliminar");
                   }
                }
            });
        }, function() {});
    }
</script>