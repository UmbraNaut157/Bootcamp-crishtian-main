<div class="container-fluid">
    <?php
        require_once "./controller/ocupacionController.php";
        $ins_ocupacion = new ocupacionController();
        $ocupaciones = $ins_ocupacion->show_ocupacion_controller("All", 0);
    ?>
    <nav class="mb-4">
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item">
                <a class="nav-link active" href="<?php echo APP_URL; ?>worker-new/">Registrar trabajador</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo APP_URL; ?>worker-list/">Lista de trabajadores</a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid card-body">
        <h1 class="h3 mb-4 text-gray-800">Registrar Trabajador</h1>
        <form class="FormularioAjax" action="<?php echo APP_URL; ?>router/requestWorker.php" method="POST" data-form="save" autocomplete="off">
            <input type="hidden" name="guardarTrabajador" value="1">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputTipo">Nacionalidad *</label>
                    <select id="inputTipo" class="form-control" name="nacionalidad_reg" required>
                        <option value="" selected disabled>Nacionalidad</option>
                        <option value="1">Venezolano</option>
                        <option value="2">Extranjero</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputCedula">Cedula *</label>
                    <input type="number" class="form-control" id="inputCedula" name="cedula_reg" maxlength="15" required >
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputName">Nombre *</label>
                    <input type="text" class="form-control" id="inputName" name="nombres_reg" maxlength="35" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputApellido">Apellido *</label>
                    <input type="text" class="form-control" id="inputApellido" name="apellidos_reg" maxlength="35" required>
                </div>
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
                    <label for="inputTelfn">Telefono </label>
                    <input type="tel" class="form-control" id="inputTelfn" name="telefono_reg" required >
                </div>
                <div class="form-group col-md-6">
                    <label for="inputEmail">Correo *</label>
                    <input type="email" class="form-control" id="inputEmail" name="correo_reg"  required>
                </div>    
            </div>
            <div class="form-row">
            <div class="form-group col-md-6">
                    <label for="inputFechaNac">Fecha nacimiento </label>
                    <input type="date" class="form-control" id="inputFechaNac" name="fecha_nacimiento_reg" required >
                </div>
                <div class="form-group col-md-6">
                    <label for="inputFechaIngre">Fecha Ingreso </label>
                    <input type="date" class="form-control" id="inputFechaIngre" name="fecha_ingreso_reg" required >
                </div>
            <div class="form-group">
                
            </div>
            <div class="form-row ">
                <div class="form-group col-md-6">
                    <label for="inputOcupacion">Ocupacion *</label>
                    <select id="inputOcupacion" class="form-control" name="ocupacion_reg" required>
                        <option value="" selected disabled>Seleccione una ocupación</option>
                        <?php
                            if($ocupaciones){
                                foreach($ocupaciones as $row){
                                    echo '<option value="'.$row['ocupacion_id'].'">'.$row['ocupacion_descripcion'].'</option>';
                                }
                            }else{
                                echo '<option value="" disabled>No hay ocupaciones registradas</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputStatus">Estatus *</label>
                    <select id="inputStatus" class="form-control" name="estatus_reg" required>
                        <option value="" selected disabled>Seleccione</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
            <div class="form-group col-md-12 text-center mt-3">
                <button type="reset" class="btn btn-secondary">LIMPIAR</button>
                <button type="submit" class="btn btn-primary">GUARDAR</button>
            </div>
            <div class="form-group col-md-12 text-center mt-1">
                <p class="h5" >Los campos marcados con * son obligatorios </p>
            </div>
        </form>
    </div>
</div>
