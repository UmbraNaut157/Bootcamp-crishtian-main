<?php 
    if($peticionAjax){
        require_once "../model/workerModel.php";
    }else{
        require_once "./model/workerModel.php";
    }

class workerController extends workerModel {
    public function  add_worker_controller(){ 
        $nacionalidad = mainModel::clean_string($_POST['nacionalidad_reg']);
        $cedula = mainModel::clean_string($_POST['cedula_reg']);
        $nombres = mainModel::clean_string($_POST['nombres_reg']);
        $apellidos = mainModel::clean_string($_POST['apellidos_reg']);
        $correo = mainModel::clean_string($_POST['correo_reg']);
        $telefono = mainModel::clean_string($_POST['telefono_reg']);
        $fecha_nacimiento = mainModel::clean_string($_POST['fecha_nacimiento_reg']);
        $fecha_ingreso = mainModel::clean_string($_POST['fecha_ingreso_reg']);
        $ocupacion_id = mainModel::clean_string($_POST['ocupacion_reg']);
        $estatus = mainModel::clean_string($_POST['estatus_reg']);
        
        /*== comprobar campos vacios ==*/
        if($nacionalidad=="" || $cedula==""  || $nombres=="" || $apellidos=="" || $correo=="" || $telefono=="" || $fecha_nacimiento=="" || $fecha_ingreso=="" || $ocupacion_id=="" || $estatus=="" ){
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No has llenado todos los campos que son obligatorios",
                "Tipo" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*== Verificando integridad de los datos ==*/

        // Cambiar validación de nacionalidad para aceptar valores "1" o "2"
        if($nacionalidad != "1" && $nacionalidad != "2"){
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Campo nacionalidad debe ser '1' (Venezolano) o '2' (Extranjero)",
                "Tipo" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verificar_datos("[a-zA-ZñÑ0-9]{5,35}", $cedula)){
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Campo cedula no coincide con el formato solicitado: [a-zA-ZñÑ0-9]{5,35}",
                "Tipo" => "error"
            ];
            echo json_encode($alert);
            exit();
        }
        // Ajustar regex para nombres y apellidos para permitir espacios y caracteres acentuados, longitud 3 a 35
        if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $nombres)){ 
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Campo nombres no coincide con el formato solicitado: [a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}",
                "Tipo" => "error"
            ];
            echo json_encode($alert);
            exit();
        }
        if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $apellidos)){ 
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Campo apellido no coincide con el formato solicitado: [a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}",
                "Tipo" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*== Comprobando correo ==*/
        if($correo!=""){
            if(filter_var($correo,FILTER_VALIDATE_EMAIL)){
                $check_correo=mainModel::ejecutar_consulta_simple("SELECT trabajador_correo FROM trabajador WHERE trabajador_correo='$correo'");
                if($check_correo->rowCount()>0){
                    $alert=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El correo ingresado ya se encuentra registrado en el sistema",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();
                }
            }else{
                $alert=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Ha ingresado un correo no válido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        if(mainModel::verificar_datos("[0-9+]{11,15}",$telefono)){
            $alert=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"El Campo Telefono no coincide con el formato solicitado:[0-9+]{11,15}",
                "Tipo"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }
        /*--------- Funcion verificar fechas ---------*/
		if(mainModel:: verificar_fecha($fecha_nacimiento)){
			$alert=[
            "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"El Campo fecha nacimiento no coincide con el formato solicitado: YYYY-MM-DD",
                "Tipo"=>"error"
            ];
            echo json_encode($alert);
            exit();
		}
        if(mainModel:: verificar_fecha($fecha_ingreso)){
			$alert=[
            "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"El Campo fecha ingreso no coincide con el formato solicitado: YYYY-MM-DD",
                "Tipo"=>"error"
            ];
            echo json_encode($alert);
            exit();
		}

            // Convertir estatus a entero para comparación
            $estatus = (int)$estatus;
            if($estatus!=0 && $estatus!=1){
            $alert=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"El estatus del trabajador no es válido",
                "Tipo"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*== Comprobando ocupacion ==*/
        if($ocupacion_id==""){
            $alert=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"Debe seleccionar una ocupación para el trabajador",
                "Tipo"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        $data = [
            "Nacionalidad" => $nacionalidad,
            "Cedula"=>$cedula,
            "Nombres" => $nombres,
            "Apellidos" => $apellidos,
            "Correo" => $correo,
            "Telefono" => $telefono,
            "Fecha_nacimiento" => $fecha_nacimiento,
            "Fecha_ingreso"=> $fecha_ingreso,
            "Ocupacion" => $ocupacion_id,
            "Estatus" => $estatus
        ];

        $add_worker = workerModel::add_worker_model($data);

        if($add_worker->rowCount() == 1){
            $alert = [
                "Alerta" => "limpiar",
                "Titulo" => "Trabajador registrado",
                "Texto" => "El trabajador se ha registrado con éxito",
                "Tipo" => "success"
            ];
        }else{
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No se ha podido registrar el trabajador",
                "Tipo" => "error"
            ];
        }
        
        echo json_encode($alert);
        exit();
    }

    public function list_worker_controller(){
        $query = workerModel::data_worker_model("All", 0);
        $workers = $query->fetchAll(PDO::FETCH_ASSOC);

        $table = '<table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nacionalidad</th>
                            <th>Cédula</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Fecha Nacimiento</th>
                            <th>Fecha Ingreso</th>
                            <th>Ocupación</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach($workers as $worker){
            $nacionalidad = ($worker['trabajador_nacionalidad'] == 1) ? 'Venezolano' : 'Extranjero';
            $estatus = ($worker['trabajador_estatus'] == 1) ? 'Activo' : 'Inactivo';

            $table .= '<tr>
                        <td>'.$worker['trabajador_id'].'</td>
                        <td>'.$nacionalidad.'</td>
                        <td>'.$worker['trabajador_cedula'].'</td>
                        <td>'.$worker['trabajador_nombres'].'</td>
                        <td>'.$worker['trabajador_apellidos'].'</td>
                        <td>'.$worker['trabajador_telefono'].'</td>
                        <td>'.$worker['trabajador_correo'].'</td>
                        <td>'.$worker['trabajador_fecha_nacimiento'].'</td>
                        <td>'.$worker['trabajador_fecha_ingreso'].'</td>
                        <td>'.$worker['ocupacion_descripcion'].'</td>
                        <td>'.$estatus.'</td>
                        <td>
                            <a href="'.APP_URL.'worker-update/'.$worker['trabajador_id'].'/" class="btn btn-warning btn-sm">Editar</a>
                            <form class="FormularioAjax d-inline" action="'.APP_URL.'router/requestWorker.php" method="POST" data-form="delete">
                                <input type="hidden" name="id_del" value="'.$worker['trabajador_id'].'">
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>
                    </tr>';
        }

        $table .= '</tbody></table>';

        return $table;
    }

    public function update_worker_controller(){
        $id = mainModel::clean_string($_POST['id_up']);
        $nacionalidad = mainModel::clean_string($_POST['nacionalidad_up']);
        $cedula = mainModel::clean_string($_POST['cedula_up']);
        $nombres = mainModel::clean_string($_POST['nombres_up']);
        $apellidos = mainModel::clean_string($_POST['apellidos_up']);
        $correo = mainModel::clean_string($_POST['correo_up']);
        $telefono = mainModel::clean_string($_POST['telefono_up']);
        $fecha_nacimiento = mainModel::clean_string($_POST['fecha_nacimiento_up']);
        $fecha_ingreso = mainModel::clean_string($_POST['fecha_ingreso_up']);
        $ocupacion_id = mainModel::clean_string($_POST['ocupacion_up']);
        $estatus = mainModel::clean_string($_POST['estatus_up']);

        /*== comprobar campos vacios ==*/
        if($nacionalidad=="" || $cedula==""  || $nombres=="" || $apellidos=="" || $correo=="" || $telefono=="" || $fecha_nacimiento=="" || $fecha_ingreso=="" || $ocupacion_id=="" || $estatus=="" ){
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "No has llenado todos los campos que son obligatorios",
                "Tipo" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*== Verificando integridad de los datos ==*/
        if($nacionalidad != "1" && $nacionalidad != "2"){
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Campo nacionalidad debe ser '1' (Venezolano) o '2' (Extranjero)",
                "Tipo" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verificar_datos("[a-zA-ZñÑ0-9]{5,35}", $cedula)){
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Campo cedula no coincide con el formato solicitado: [a-zA-ZñÑ0-9]{5,35}",
                "Tipo" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $nombres)){
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Campo nombres no coincide con el formato solicitado: [a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}",
                "Tipo" => "error"
            ];
            echo json_encode($alert);
            exit();
        }
        if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}", $apellidos)){
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Ocurrió un error inesperado",
                "Texto" => "El Campo apellido no coincide con el formato solicitado: [a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,35}",
                "Tipo" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*== Comprobando correo ==*/
        if($correo!=""){
            if(filter_var($correo,FILTER_VALIDATE_EMAIL)){
                $check_correo=mainModel::ejecutar_consulta_simple("SELECT trabajador_correo FROM trabajador WHERE trabajador_correo='$correo' AND trabajador_id!='$id'");
                if($check_correo->rowCount()>0){
                    $alert=[
                        "Alerta"=>"simple",
                        "Titulo"=>"Ocurrió un error inesperado",
                        "Texto"=>"El correo ingresado ya se encuentra registrado en el sistema",
                        "Tipo"=>"error"
                    ];
                    echo json_encode($alert);
                    exit();
                }
            }else{
                $alert=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Ha ingresado un correo no válido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        if(mainModel::verificar_datos("[0-9+]{11,15}",$telefono)){
            $alert=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"El Campo Telefono no coincide con el formato solicitado:[0-9+]{11,15}",
                "Tipo"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel:: verificar_fecha($fecha_nacimiento)){
            $alert=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"El Campo fecha nacimiento no coincide con el formato solicitado: YYYY-MM-DD",
                "Tipo"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }
        if(mainModel:: verificar_fecha($fecha_ingreso)){
            $alert=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"El Campo fecha ingreso no coincide con el formato solicitado: YYYY-MM-DD",
                "Tipo"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        $estatus = (int)$estatus;
        if($estatus!=0 && $estatus!=1){
            $alert=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"El estatus del trabajador no es válido",
                "Tipo"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($ocupacion_id==""){
            $alert=[
                "Alerta"=>"simple",
                "Titulo"=>"Ocurrió un error inesperado",
                "Texto"=>"Debe seleccionar una ocupación para el trabajador",
                "Tipo"=>"error"
            ];
            echo json_encode($alert);
            exit();
        }

        $data = [
            "ID" => $id,
            "Nacionalidad" => $nacionalidad,
            "Cedula"=>$cedula,
            "Nombres" => $nombres,
            "Apellidos" => $apellidos,
            "Email" => $correo,
            "Telefono" => $telefono,
            "Fecha_nacimiento" => $fecha_nacimiento,
            "Fecha_Ingreso" => $fecha_ingreso,
            "Ocupacion" => $ocupacion_id,
            "Estatus" => $estatus
        ];

        $update_worker = workerModel::update_worker_model($data);

        if($update_worker->rowCount() == 1){
            $alert = [
                "Alerta" => "recargar",
                "Titulo" => "Trabajador actualizado",
                "Texto" => "El trabajador se ha actualizado con éxito",
                "Tipo" => "success"
            ];
        }else{
            $alert = [
                "Alerta" => "simple",
                "Titulo" => "Sin cambios",
                "Texto" => "No se realizaron cambios en los datos del trabajador",
                "Tipo" => "error"
            ];
        }

        echo json_encode($alert);
        exit();
    }

    public function show_worker_controller($type, $id){
        $type = mainModel::clean_string($type);
        $id = mainModel::clean_string($id);
        if($type == "Only"){
            $query = workerModel::data_worker_model($type, $id);
            if($query->rowCount() == 1){
                $data = $query->fetch();
            }else{
                $data = false;
            }
        }elseif($type == "Count"){
            $query = workerModel::data_worker_model($type, $id);
            $data = $query->rowCount();
        }elseif($type == "All"){
            $query = workerModel::data_worker_model($type, $id);
            $data = $query->fetchAll();
        }else{
            $data = false;
        }
        return $data;
    }
}
