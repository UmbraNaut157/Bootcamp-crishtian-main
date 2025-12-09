<?php
    require_once "mainModel.php";
    /*--------- Modelo ocupacion ---------*/
    class ocupacionModel extends mainModel{

        protected function add_ocupacion_model($data){
            $sql = mainModel::conectar()->prepare("INSERT INTO ocupacion(ocupacion_descripcion,ocupacion_estatus) VALUES(:Descripcion,:Estatus)");
            $sql->bindParam(":Descripcion", $data['Descripcion']);
            $sql->bindParam(":Estatus", $data['Estatus']);
            $sql->execute();
            return $sql;
        }
        
        protected function update_ocupacion_model($data){
            $sql = mainModel::conectar()->prepare("UPDATE ocupacion SET ocupacion_descripcion=:Descripcion,ocupacion_estatus=:Estatus WHERE ocupacion_id=:ID");
            $sql->bindParam(":ID", $data['ID']);
            $sql->bindParam(":Descripcion", $data['Descripcion']);
            $sql->bindParam(":Estatus", $data['Estatus']);
            $sql->execute();
            return $sql;
        }

        protected function delete_ocupacion_model($id){
            $sql = mainModel::conectar()->prepare("DELETE FROM ocupacion WHERE ocupacion_id=:ID");
            $sql->bindParam(":ID", $id);
            $sql->execute();
            return $sql;
        }

        protected function data_ocupacion_model($type, $id){
            if($type == "Only"){
                $sql = mainModel::conectar()->prepare("SELECT * FROM ocupacion WHERE ocupacion_id=:ID");
                $sql->bindParam(":ID", $id);
            }elseif($type == "Count"){
                $sql = mainModel::conectar()->prepare("SELECT ocupacion_id FROM ocupacion WHERE ocupacion_id!=1");
            }elseif($type == "All"){
                $sql = mainModel::conectar()->prepare("SELECT * FROM ocupacion WHERE ocupacion_estatus=1 ORDER BY ocupacion_id DESC");
            }
            $sql->execute();
            return $sql;
        }
    }
