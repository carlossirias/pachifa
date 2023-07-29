<?php
require'../config/config.php';

if(isset($_POST['id']))
{
    $id = $_POST['id'];
    if($id > 0 )
    {
        if(isset($_SESSION['carrito']['productos'][$id]))
        {
            unset($_SESSION['carrito']['productos'][$id]);
            $datos['ok'] = true;
        }
        else
        {
            $datos['ok'] = false;
        }
    }
    else
    {
        $datos['ok'] = false;
    }
    
}else{
    $datos['ok'] = false;
}

echo json_encode($datos);
?>