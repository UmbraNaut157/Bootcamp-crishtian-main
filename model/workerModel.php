<?php
    require_once "mainModel.php";
    /*--------- Modelo de usuario ---------*/
    class workerModel extends mainModel{
        // INSERT INTO Tabla(campo1,campo2,campo3) VALUES(:marcador1,:marcador2,:marcador3)
        protected function add_worker_model($data){
            $sql=mainModel::conectar()->prepare("INSERT INTO trabajador(trabajador_nacionalidad,trabajador_cedula,trabajador_nombres,trabajador_apellidos,trabajador_telefono,trabajador_correo,trabajador_fecha_nacimiento,trabajador_fecha_ingreso,ocupacion_id,trabajador_estatus) VALUES(:Nacionalidad,:Cedula,:Nombres,:Apellidos,:Telefono,:Correo,:Fecha_nacimiento,:Fecha_ingreso,:Ocupacion,:Estatus)");
            $sql->bindParam(":Nacionalidad", $data['Nacionalidad']);
            $sql->bindParam(":Cedula", $data['Cedula']);
            $sql->bindParam(":Nombres", $data['Nombres']);
            $sql->bindParam(":Apellidos", $data['Apellidos']);
            $sql->bindParam(":Telefono", $data['Telefono']);
            $sql->bindParam(":Correo", $data['Correo']);
            $sql->bindParam(":Fecha_nacimiento", $data['Fecha_nacimiento']);
            $sql->bindParam(":Fecha_ingreso", $data['Fecha_ingreso']);
            $sql->bindParam(":Ocupacion", $data['Ocupacion']);
            $sql->bindParam(":Estatus", $data['Estatus']);
            $sql->execute();
            return $sql;
        }
        //UPDATE usuario SET usuario_Nombres=:Nombres,usuario_username=:Username WHERE usuario_id=:ID"
        protected function update_worker_model($data){
            $sql=mainModel::conectar()->prepare("UPDATE trabajador SET trabajador_nacionalidad=:Nacionalidad,trabajador_cedula=:Cedula,trabajador_Nombres=:Nombres,trabajador_Apellidos=:Apellidos,trabajador_telefono=:Telefono,trabajador_correo=:Email,trabajador_fecha_nacimiento=:Fecha_nacimiento,trabajador_fecha_ingreso=:Fecha_Ingreso,ocupacion_id=:Ocupacion,trabajador_estatus=:Estatus WHERE trabajador_id=:ID");
            $sql->bindParam(":ID",$data['ID']);
            $sql->bindParam(":Nacionalidad",$data['Nacionalidad']);
            $sql->bindParam(":Cedula",$data['Cedula']);
            $sql->bindParam(":Nombres",$data['Nombres']);
            $sql->bindParam(":Apellidos",$data['Apellidos']);
            $sql->bindParam(":Email",$data['Email']);
            $sql->bindParam(":Telefono",$data['Telefono']);
            $sql->bindParam(":Fecha_nacimiento",$data['Fecha_nacimiento']);
            $sql->bindParam(":Fecha_Ingreso",$data['Fecha_Ingreso']);
            $sql->bindParam(":Ocupacion",$data['Ocupacion']);
            $sql->bindParam(":Estatus",$data['Estatus']);
            $sql->execute();
            return $sql;
        }
        protected function delete_worker_model($id){
            $sql = mainModel::conectar()->prepare("DELETE FROM trabajador WHERE trabajador_id=:ID");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }
        protected function data_worker_model($type, $id){
            if($type == "Only"){
                $sql = mainModel::conectar()->prepare("SELECT * FROM trabajador WHERE trabajador_id=:ID");
                $sql->bindParam(":ID", $id);
            }elseif($type == "Count"){
                $sql = mainModel::conectar()->prepare("SELECT trabajador_id FROM trabajador WHERE trabajador_id!=1");
            }elseif($type == "All"){
                $sql = mainModel::conectar()->prepare("SELECT t.*, o.ocupacion_descripcion FROM trabajador t INNER JOIN ocupacion o ON t.ocupacion_id = o.ocupacion_id WHERE t.trabajador_estatus=1 ORDER BY t.trabajador_id DESC");
            }
            $sql->execute();
            return $sql;
        }
    } 