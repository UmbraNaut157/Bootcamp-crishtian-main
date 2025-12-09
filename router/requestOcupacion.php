<?php
$peticionAjax=true;
require_once "../config/APP.php";
//petición a ocupacion
if(isset($_POST['guardarOcupacion'])){
    /*--------- Instancia al controlador ---------*/
    require_once "../controller/ocupacionController.php";
    $ocupacionController = new ocupacionController();

    /*--------- Agregar una ocupacion ---------*/
    if(isset($_POST['descripcion_reg'])){
        echo $ocupacionController->add_ocupacion_controller();
    }
    
    /*--------- Editar una ocupacion ---------*/
    if(isset($_POST['id_up'])){
        echo $ocupacionController->update_ocupacion_controller();
    }
    /*--------- Eliminar una ocupacion ---------*/
if(isset($_POST['id_del'])){
        echo $ocupacionController->delete_ocupacion_controller();
    }
    else {
        session_start(['name'=>APP_NAME]);
        session_unset();
        session_destroy();
        header("Location: ".APP_URL."login/");
        exit();
    }
}
