<?php 
    if($peticionAjax){
        require_once "../model/ocupacionModel.php";
    }else{
        require_once "./model/ocupacionModel.php";
    }
    class ocupacionController extends ocupacionModel{
        public function add_ocupacion_controller(){
            $Descripcion = mainModel::clean_string($_POST['descripcion_reg']);
            $estatus = mainModel::clean_string($_POST['estatus_reg']);
            /*== comprobar campos vacios ==*/
            if($Descripcion == "" || $estatus == ""){
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "No has llenado todos los campos que son obligatorios",
                    "Tipo" => "error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*== Verificando integridad de los datos ==*/
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,30}", $Descripcion)){
                $alert = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "La Descripcion de la ocupacion no coincide con el formato solicitado: [a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,30}",
                    "Tipo" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
            /*== Comprobando estatus ==*/
            if($estatus != "1" && $estatus != "0"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El ESTATUS seleccionado no es valido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $data_ocupacion_reg = [
                "Descripcion" => $Descripcion,
                "Estatus" => $estatus
            ];
            $add_ocupacion = ocupacionModel::add_ocupacion_model($data_ocupacion_reg);
            if($add_ocupacion->rowCount() == 1){
                $alert = [
                    "Alerta" => "limpiar",
                    "Titulo" => "Tipo de ocupacion registrado",
                    "Texto" => "El tipo de ocupacion se ha registrado con éxito en el sistema",
                    "Tipo" => "success"
                ];
            }else{
                $alert = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El tipo de ocupacion no se ha registrado en el sistema",
                    "Tipo" => "error"
                ];
            }
            echo json_encode($alert);
            exit();
        }
        public function list_ocupacion_controller(){
            $query = mainModel::ejecutar_consulta_simple("SELECT * FROM ocupacion");
            $datos = $query->fetchAll();
            $table = '<div class="table-responsive">
                <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">DESCRIPCIÓN</th>
                            <th class="text-center">ESTATUS</th>
                            <th class="text-center">ACTUALIZAR</th>
                            <th class="text-center">ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>';
            if($query->rowCount() > 0){
                $num = 0;
                foreach($datos as $rows){
                    $num++;
                    $table .= '<tr>
                        <td class="text-center">'.$num.'</td>
                        <td class="text-center">'.$rows['ocupacion_descripcion'].'</td>
                        <td class="text-center">';
                        if($rows['ocupacion_estatus'] == 1){
                            $table .= '<span class="badge badge-success">Activo</span>';
                        }else{
                            $table .= '<span class="badge badge-danger">Inactivo</span>';
                        }
                        $table .= '</td>
                        <td class="text-center">
                            <a href="'.APP_URL.'ocupacion-update/'.mainModel::encryption($rows['ocupacion_id']).'/" class="btn btn-primary">
                                <i class="fas fa-fw fa-wrench"></i>
                            </a>
                        </td>
                        <td class="text-center">
                        <form class="FormularioAjax" action="'.APP_URL.'router/requestOcupacion.php" method="POST" data-form="delete" autocomplete="off">
                            <input type="hidden" name="guardarOcupacion" value="1">
                            <input type="hidden" name="id_del" value="'.mainModel::encryption($rows['ocupacion_id']).'">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-fw fa-trash"></i>
                            </button>
                        </form>
                        </td>
                    </tr>';
                }
            }else{
                $table .= '<tr>
                    <td colspan="5" class="text-center">No hay registros en el sistema</td>
                </tr>';
            }
                
            $table .= '</tbody>
                </table>';
            $table .= '</div>';
            
            return $table;
        }
        public function update_ocupacion_controller(){
            $id = mainModel::decryption($_POST['id_up']);
            $id = mainModel::clean_string($id);
            $Descripcion = mainModel::clean_string($_POST['descripcion_up']);
            $estatus = mainModel::clean_string($_POST['estatus_up']);
            /*== comprobar campos vacios ==*/
            if($Descripcion == "" || $estatus == ""){
                $alerta = [
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"Todos los campos son obligatorios",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            /*== fin comprobar campos vacios ==*/
            /*== Verificando integridad de los datos ==*/
            if(mainModel::verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,30}", $Descripcion)){
                $alert = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El nombre del tipo de ocupacion no coincide con el formato solicitado: [a-zA-ZáéíóúÁÉÍÓÚñÑ ]{5,30}",
                    "Tipo" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
            /*== Comprobando estatus ==*/
            if($estatus != "1" && $estatus != "0"){
                $alerta=[
                    "Alerta"=>"simple",
                    "Titulo"=>"Ocurrió un error inesperado",
                    "Texto"=>"El ESTATUS seleccionado no es valido",
                    "Tipo"=>"error"
                ];
                echo json_encode($alerta);
                exit();
            }
            $data_ocupacion_up = [
                "ID" => $id,
                "Descripcion" => $Descripcion,
                "Estatus" => $estatus
            ];
            $update_ocupacion = ocupacionModel::update_ocupacion_model($data_ocupacion_up);
            if($update_ocupacion){
                $alerta = [
                    "Alerta" => "recargar",
                    "Titulo" => "Tipo de ocupacion actualizado",
                    "Texto" => "El tipo de ocupacion se ha actualizado con éxito en el sistema",
                    "Tipo" => "success"
                ];
            }else{
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El tipo de ocupacion no se ha actualizado en el sistema",
                    "Tipo" => "error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }
        public function delete_ocupacion_controller(){
            $id = mainModel::decryption($_POST['id_del']);
            $id = mainModel::clean_string($id);
            $delete_ocupacion = ocupacionModel::delete_ocupacion_model($id);
            if($delete_ocupacion){
                $alerta = [
                    "Alerta" => "recargar",
                    "Titulo" => "Tipo de ocupacion eliminado",
                    "Texto" => "El tipo de ocupacion se ha eliminado con éxito en el sistema",
                    "Tipo" => "success"
                ];
            }else{
                $alerta = [
                    "Alerta" => "simple",
                    "Titulo" => "Ocurrió un error inesperado",
                    "Texto" => "El tipo de ocupacion no se ha eliminado en el sistema",
                    "Tipo" => "error"
                ];
            }
            echo json_encode($alerta);
            exit();
        }
        public function show_ocupacion_controller($type, $id){
            $type = mainModel::clean_string($type);
            $id = mainModel::decryption($id);
            $id = mainModel::clean_string($id);
            if($type == "Only"){
                $query = ocupacionModel::data_ocupacion_model($type, $id);
                if($query->rowCount() == 1){
                    $data = $query->fetch();
                }else{
                    $data = false;
                }
            }elseif($type == "Count"){
                $query = ocupacionModel::data_ocupacion_model($type, $id);
                $data = $query->rowCount();
            }elseif($type == "All"){
                $query = ocupacionModel::data_ocupacion_model($type, $id);
                $data = $query->fetchAll();
            }else{
                $data = false;
            }
            return $data;
        }
    }
