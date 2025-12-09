<div class="container-fluid">
    <nav class="mb-4">
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo APP_URL; ?>ocupacion/">Registrar ocupacion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo APP_URL; ?>ocupacion-list/">Lista de ocupacion</a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid card-body">
        <h1 class="h3 mb-4 text-gray-800">Modificar ocupacion</h1>
        <?php
            require_once "./controller/ocupacionController.php";
            $ins_ocupacion = new ocupacionController();
            $datos = $ins_ocupacion->show_ocupacion_controller("Only", $page[1]);
        ?>
        <form class="FormularioAjax" action="<?php echo APP_URL; ?>router/requestOcupacion.php" method="POST" data-form="update" autocomplete="off">
            <input type="hidden" name="guardarOcupacion" value="1">
            <input type="hidden" name="id_up" value="<?php echo $page[1]; ?>">
            <div class="form-row ">
                <div class="form-group col-md-6">
                    <label for="inputName">DESCRIPCIÓN *</label>
                    <input type="text" class="form-control" id="inputName" name="descripcion_up" value="<?php echo $datos['ocupacion_descripcion']; ?>" maxlength="35" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,30}" >
                </div>
                <div class="form-group col-md-6">
                    <label for="inputStatus">ESTATUS *</label>
                    <select id="inputStatus" class="form-control" name="estatus_up">
                        <?php if($datos['ocupacion_estatus'] == 1){ ?>
                            <option  value="1" selected>ACTIVO</option >
                            <option value="0" >INACTIVO</option>
                        <?php }else{ ?>
                            <option  value="1" >ACTIVO</option >
                            <option value="0" selected>INACTIVO</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-12 text-center mt-3">
                <a href="<?php echo APP_URL ?>ocupacion-list" class="btn btn-secondary">VOLVER</a>
                <button type="submit" class="btn btn-primary">MODIFICAR</button>
            </div>
            <div class="form-group col-md-12 text-center mt-1">
                <p class="h5" >Los campos marcados con * son obligatorios </p>
            </div>
        </form>
        
    </div>
