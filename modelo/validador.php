<?php

date_default_timezone_set('America/Bogota');

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

// registro del propietario u conductor
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
        // Se valida que ya no existe ese propietario
        $queryValidar = "SELECT  COUNT(1) FROM propietarios WHERE identificacion = '$id'";
        $resValidar = mysqli_query($conn, $queryValidar);
        $dataValidar = $resValidar->fetch_row();
        if ($dataValidar[0] > 0) {
            Info("El propietario ya se encuentra registrado. ");
        }
        $queryInser = "INSERT INTO propietarios (identificacion, primer_nombre, segundo_nombre, apellidos, direccion, telefono, ciudad )
                        VALUES ('$id', '$pNombre', $sNombre, '$apellido', '$direccion', '$telefono', '$ciudad')";
        $resInser = mysqli_query($conn, $queryInser);
    } else {
        // Se valida que ya no existe ese conductor
        $queryValidar = "SELECT  COUNT(1) FROM conductores WHERE identificacion = '$id'";
        $resValidar = mysqli_query($conn, $queryValidar);
        $dataValidar = $resValidar->fetch_row();
        if ($dataValidar[0] > 0) {
            Info("El conductor ya se encuentra registrado. ");
        }
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

// registro del vehiculo
if (isset($_POST['registroVehiculo']) && $_POST['registroVehiculo'] === 'true') {


    // Se reciben las variables del registro del vehiculo
    $placa = isset($_POST['InputPlaca']) && $_POST['InputPlaca'] !== '' ? valTexto($_POST['InputPlaca']) : Info("Falta llenar el campo Placa");
    $color = isset($_POST['InputColor']) && $_POST['InputColor'] !== '' ? valTexto($_POST['InputColor']) : Info("Falta llenar el campo Color");
    $marca = isset($_POST['InputMarca']) && $_POST['InputMarca'] !== '' ? valTexto($_POST['InputMarca']) : Info("Falta llenar el campo Marca ");
    $tipoVehiculo = isset($_POST['tipoVehiculo']) && $_POST['tipoVehiculo'] !== '' ? valTexto($_POST['tipoVehiculo']) : Info("Falta seleccionar el tipo vehiculo");
    $conductor = isset($_POST['selectConductor']) && $_POST['selectConductor'] !== '' ? valTexto($_POST['selectConductor']) : Info("Falta seleccionar el Conductor");
    $propietario = isset($_POST['selectPropietario']) && $_POST['selectPropietario'] !== '' ? valTexto($_POST['selectPropietario']) : Info("Falta seleccinar el propietario");

    // Se valida que ya no existe esa placa en el registro
    $queryValidar = "SELECT  COUNT(1) FROM vehiculos WHERE placa = '$placa'";
    $resValidar = mysqli_query($conn, $queryValidar);
    $dataValidar = $resValidar->fetch_row();
    if ($dataValidar[0] > 0) {
        Info("La placa ya se encuentra registrada. ");
    }

    // Se realiza el insert
    $queryInseV = "INSERT INTO vehiculos (placa, color, marca, tipo_vehiculo, conductor, propietario)
                    VALUES ('$placa', '$color', '$marca', '$tipoVehiculo', $conductor, $propietario)";
    $resInserV = mysqli_query($conn, $queryInseV);
    $idVehiculo = mysqli_insert_id($conn);

    if ($resInserV) {
        // Se guarda el log  que vehiculos sean asignado a propietario y conductor
        $fecha = date("Y-m-d H:i:s");
        $queryHistorico = "INSERT INTO vehiculos_asignados (id_vehiculos, id_conductor, id_propietario, estado, fecharegistro)
                            VALUES ( $idVehiculo, $conductor, $propietario, '0', '$fecha')";
        $res = mysqli_query($conn, $queryHistorico);
        if ($res) {
            success("Registro Existoso");
        } else {
            Info("No se logro el registro");
        }
    } else {
        Info("No se logro el registro");
    }
}

// Se trae los conductores
if (isset($_POST['conductores']) && $_POST['conductores'] === 'true') {
    $queryCond = "SELECT id_conductor, primer_nombre, segundo_nombre FROM conductores";
    $resCond = mysqli_query($conn, $queryCond);
    $dataCond = $resCond->fetch_all();
    if ($resCond->num_rows > 0) {
        echo json_encode($dataCond);
    } else {
        echo json_encode('0');
    }
}

// Se trae los propietarios
if (isset($_POST['propietarios']) && $_POST['propietarios'] === 'true') {
    $queryCond = "SELECT id_propietario, primer_nombre, segundo_nombre FROM propietarios";
    $resCond = mysqli_query($conn, $queryCond);
    $dataCond = $resCond->fetch_all();
    if ($resCond->num_rows > 0) {
        echo json_encode($dataCond);
    } else {
        echo json_encode('0');
    }
}

//Se busca el dato por id la tabla de vehiculos para traer el propietario y conductor registrado
if (isset($_POST['buscarDatos']) && $_POST['buscarDatos'] === 'true' && $_POST['id'] != '') {
    $queryBusc = "SELECT propietario, conductor FROM vehiculos WHERE id = {$_POST['id']}";
    $resBusc = mysqli_query($conn, $queryBusc);
    $dataBusc = $resBusc->fetch_row();
    if ($resBusc->num_rows > 0) {
        echo json_encode($dataBusc);
    } else {
        echo json_encode('0');
    }
}


//Se realiza la actualizacion del conductor y propietario
if (isset($_POST['actualizarDatos']) && $_POST['actualizarDatos'] === 'true') {
    // Se reciben los datos del post
    $conductor = isset($_POST['selectConductor']) && $_POST['selectConductor'] !== '' ? valTexto($_POST['selectConductor']) : Info("Falta seleccionar el Conductor");
    $propietario = isset($_POST['selectPropietario']) && $_POST['selectPropietario'] !== '' ? valTexto($_POST['selectPropietario']) : Info("Falta seleccinar el propietario");
    $id = isset($_POST['idTab']) && $_POST['idTab'] !== '' ? $_POST['idTab'] : Info("Ocurrio un error");

    // Se realiza la actualización INICIAL
    $queryUP = "UPDATE vehiculos SET propietario = $propietario, conductor= $conductor WHERE id = $id";
    $resUp = mysqli_query($conn, $queryUP);
    if ($resUp) {
        // Se actualiza el estado del anterior registro en el historico
        $queryUph = "UPDATE vehiculos_asignados SET estado = '1' WHERE id_vehiculos = $id";
        $resUpH = mysqli_query($conn, $queryUph);
        if ($resUpH) {
            // Se realiza el registro en el historico
            $fecha = date("Y-m-d H:i:s");
            $queryHistorico = "INSERT INTO vehiculos_asignados (id_vehiculos, id_conductor, id_propietario, estado, fecharegistro)
                    VALUES ( $id, $conductor, $propietario, '0', '$fecha')";

            $res = mysqli_query($conn, $queryHistorico);
            if ($res) {
                success("Registro Actualizado. ");
            } else {
                Info("No se logro la actualización del histórico.");
            }
        }else{
            Info("No se logro el actualizar el registro del estado.");
        }
    }else{
        Info("No se logro el actualizar el registro del conductor y propietario.");
    }
}

mysqli_close($conn);
