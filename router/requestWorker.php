<?php
	$peticionAjax=true;
	require_once "../config/APP.php";
    //petición a tipo de usuario
    if (isset($_POST['guardarTrabajador']) || isset($_POST['id_up']) || isset($_POST['id_del'])) {
        /*--------- Instancia al controlador ---------*/
        require_once "../controller/workerController.php";
        $workerController = new workerController();

        /*--------- Agregar un trabajador ---------*/
        if(isset($_POST['nacionalidad_reg'])){
            echo $workerController->add_worker_controller();
        }

        /*--------- Actualizar un trabajador ---------*/
        if(isset($_POST['id_up'])){
            echo $workerController->update_worker_controller();
        }
    }else {
        session_start(['name'=>APP_NAME]);
        session_unset();
        session_destroy();
        header("Location: ".APP_URL."login/");
        exit(); 
    }