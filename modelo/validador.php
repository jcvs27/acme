<?php

//date_default_timezone_get('America/Bogota');

if ($_POST == null) {
    exit;
}

function Info($msj)
{
    echo '{"status":"2", "msj":"' . $msj . '"}';
    exit;
}

function success($msj)
{
    echo '{"status":"1", "msj":"' . $msj . '"}';
    exit;
}

function valTexto($value)
{
    $value = trim($value);
    $value = strip_tags($value);
    $value = addslashes($value);
    $value = utf8_decode($value);
    return $value;
}

require_once "./conexion.php";
$conn = conectar();


if (isset($_POST['registro']) && $_POST['registro'] === 'true') {
    // Se reciben todas las variables del post
    $id = isset($_POST['InputIden']) && $_POST['InputIden'] !== '' ? $_POST['InputIden'] : Info("Falta llenar el campo Identificación");
    $pNombre = isset($_POST['InpuPNombre']) && $_POST['InpuPNombre'] !== '' ? valTexto($_POST['InpuPNombre']) : Info("Falta llenar el campo  Primer Nombre");
    $sNombre = isset($_POST['InpuSNombre'])  ? "'" . valTexto($_POST['InpuSNombre']) . "'" : "null";
    $apellido = isset($_POST['InputApellidos']) && $_POST['InputApellidos'] !== '' ? valTexto($_POST['InputApellidos']) : Info("Falta llenar el campo Apellidos");
    $direccion = isset($_POST['InputDireccion']) && $_POST['InputDireccion'] !== '' ? valTexto($_POST['InputDireccion']) : Info("Falta llenar el campo Dirección");
    $telefono = isset($_POST['InputTelefono']) && $_POST['InputTelefono'] !== '' ?  $_POST['InputTelefono'] : Info("Falta llenar el campo Teléfono");
    $ciudad = isset($_POST['InputCuidad']) && $_POST['InputCuidad'] !== '' ? valTexto($_POST['InputCuidad']) : Info("Falta llenar el campo Ciudad");
    $tipoReg = isset($_POST['InputTipo']) && $_POST['InputTipo'] !== '' ? $_POST['InputTipo'] : Info("falta llenar el campo Tipo Registro");

    // Se realiza el registro
    if ($tipoReg === '1') {
        $queryInser = "INSERT INTO propietarios (identificacion, primer_nombre, segundo_nombre, apellidos, direccion, telefono, ciudad )
                        VALUES ('$id', '$pNombre', $sNombre, '$apellido', '$direccion', '$telefono', '$ciudad')";
        $resInser = mysqli_query($conn, $queryInser);
    } else {
        $queryInser = "INSERT INTO conductores (identificacion, primer_nombre, segundo_nombre, apellidos, direccion, telefono, ciudad )
                        VALUES ('$id', '$pNombre', $sNombre, '$apellido', '$direccion', '$telefono', '$ciudad')";
        $resInser = mysqli_query($conn, $queryInser);
    }

    if ($resInser) {
        success("Registro Existoso");
    } else {
        Info("No se logro el registro");
    }
}

if(isset($_POST['registroVehiculo']) && $_POST['registroVehiculo'] === 'true'){
    // Se reciben las variables del registro del vehiculo
    $placa = isset($_POST['InputPlaca']) && $_POST['InputPlaca'] !== '' ? valTexto($_POST['InputPlaca']) : Info("Falta llenar el campo Placa");
    $color = isset($_POST['InputColor']) && $_POST['InputColor'] !== '' ? valTexto($_POST['InputColor']) : Info("Falta llenar el campo Color");
    $marca = isset($_POST['InputMarca']) && $_POST['InputMarca'] !== '' ? valTexto($_POST['InputMarca']) : Info("Falta llenar el campo ");
    $tipoVehiculo = isset($_POST['InputPlaca']) && $_POST['InputPlaca'] !== '' ? valTexto($_POST['InputPlaca']) : Info("Falta llenar el campo Identificación");
    $conductor = isset($_POST['InputPlaca']) && $_POST['InputPlaca'] !== '' ? valTexto($_POST['InputPlaca']) : Info("Falta llenar el campo Identificación");
    $propietario = isset($_POST['InputPlaca']) && $_POST['InputPlaca'] !== '' ? valTexto($_POST['InputPlaca']) : Info("Falta llenar el campo Identificación");
}


mysqli_close($conn);
