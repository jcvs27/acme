<?php

error_reporting(0);
require "./conexion.php";
$conn = conectar();
$order_ini = "placa DESC, va.id DESC";
function consultar_lista_datos_tabla($conn, $fecha, $valor2, $valor3, $valor4)
{

    $fecha_1 = "";
    $fecha_2 = "";
    $sql = "SELECT va.id, placa, color,  marca, va.id_conductor, va.id_propietario, estado, fecharegistro FROM vehiculos v
                INNER JOIN propietarios p ON v.propietario = p.id_propietario
                INNER JOIN conductores c ON v.conductor = c.id_conductor
                INNER JOIN vehiculos_asignados va ON v.id = va.id_vehiculos ";


    //Resto
    $resto_sql = "";

    $from_where = " WHERE 1=1 ";

    if ($fecha !== "") {
        $from_where .= " AND fecharegistro >= '" .$fecha . " 00:00:00' AND fecharegistro <= '" . $fecha . " 23:59:59' ";
    } else{
        $fecha_hoy = date("Y-m-d");
        $fecha_ini = date("Y-m-d", strtotime($fecha_hoy . " -30 days"));
        $from_where .= " AND fecharegistro >= '" . $fecha_ini . " 00:00:00' AND fecharegistro <= '" . $fecha_hoy . " 23:59:59' ";
        
    }

    if($valor2 !== ""){
        $from_where .= " AND placa = '$valor2'";
    }

    if($valor3 !== ""){
        $from_where .= " AND conductor = '$valor3'";
    }

    if($valor4 !== ""){
        $from_where .= " AND propietario = '$valor4'";
    }


    
    
    $sql_all        = $sql . $resto_sql;
    //echo $sql_all;
    //$ejec		= mysqli_query($conn, $sql_all);
    //$num_act_inm= mysqli_num_rows($ejec);
    $matriz                = "";

    //if ($num_act_inm>0)
    $num_act_inm = 0;
    return array($num_act_inm, $matriz, $sql_all, $from_where);
    //else return array(0,0,0,0,0);
}


if (isset($_GET['valor1']))
    $fecha = $_GET['valor1'];
else $fecha = '';
if (isset($_GET['valor2']))
    $valor2 = $_GET['valor2'];
else $valor2 = '';
if (isset($_GET['valor3']))
    $valor3 = $_GET['valor3'];
else $valor3 = '';
if (isset($_GET['valor4']))
    $valor4 = $_GET['valor4'];
else $valor4 = '';



list($num_lista_api, $datos_lista_api, $sql_all, $from_where) = consultar_lista_datos_tabla($conn, $fecha, $valor2, $valor3, $valor4);
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */

/* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
     */
$aColumns = array('id','placa','marca', 'color');


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP server-side, there is
     * no need to edit below this line
     */

/* 
     * Local functions
     */
function fatal_error($sErrorMessage = '')
{
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
    die($sErrorMessage);
}

/* 
     * Paging
     */
$sLimit = "";


if (isset($_GET['start']) && $_GET['length'] != '-1') {
    $sLimit = "LIMIT " . intval($_GET['start']) . ", " .
        intval($_GET['length']);
}

/*
     * Ordering
     */
$sOrder = "";
/*  if ( isset( $_GET['order'][0]['column'] ) )
    {

            $sOrder = "  ";

                    if ( isset($aColumns[$_GET['order'][0]['column']]))
                    {
                            $sOrder .= "(".$aColumns[$_GET['order'][0]['column']].") ".
                                    ($_GET['order'][0]['dir']==='asc' ? 'asc' : 'desc') .", ";
                    }

            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" )
            {
                    $sOrder = "";
            }
    }*/

$cadena_de_texto = $sOrder;
$cadena_buscada   = $order_ini;
$posicion_coincidencia = strrpos($cadena_de_texto, $cadena_buscada);

//echo $posicion_coincidencia = strrpos("123", "123");

if ($posicion_coincidencia > 0)
    $sOrder = $order_ini;


$sOrder = "ORDER BY " . $order_ini;



/* 
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
$sWhere = "";

if (isset($_GET['search']) && $_GET['search'] != "") {
    $sWhere = "AND (";
    for ($i = 0; $i < count($aColumns); $i++) {

        $sWhere .= "" . $aColumns[$i] . " LIKE '%" . $_GET['search']['value'] . "%' OR ";
    }
    $sWhere = substr_replace($sWhere, "", -3);
    $sWhere .= ')';
}


/* Individual column filtering */
for ($i = 0; $i < count($aColumns); $i++) {
    if (isset($_GET['B' . $i]) && $_GET['bSearchable_' . $i] == "true" && $_GET['sSearch_' . $i] != '') {
        if ($sWhere == "") {
            $sWhere = "WHERE ";
        } else {
            $sWhere .= " AND ";
        }
        $sWhere .= "" . $aColumns[$i] . " LIKE '%" . $_GET['sSearch_' . $i] . "%' ";
    }
}


/*
     * SQL queries
     * Get data to display
     */

//Convierte los carácteres en utf8
mysqli_set_charset($conn, "utf8");
//-- select
$sQuery = "
    $sql_all 
    $from_where
    $sWhere
    $sOrder
    $sLimit
    ";

$ejec_sql = mysqli_query($conn, $sQuery);
$num_act_inm = mysqli_num_rows($ejec_sql);
if ($num_act_inm > 0) $num_sql = $num_act_inm;
else $num_sql = 0;

echo $sQuery;
if ($num_act_inm > 0) {
    $sQuerySinLimit = "
            $sql_all 
            $from_where
            $sWhere
            $sOrder
            ";

    $ejec_sqlSinLimit = mysqli_query($conn, $sQuerySinLimit);
    $num_act_inmSinLimit = mysqli_num_rows($ejec_sqlSinLimit);
} else {
    $num_act_inmSinLimit = 0;
}

if ($num_act_inmSinLimit > 0) $num_sqlSinLimit = $num_act_inmSinLimit;
else $num_sqlSinLimit = 0;



function consultar_lista_paginacion($conn, $sql_paginacion)
{
    $sql = $sql_paginacion;
    $ejec = mysqli_query($conn, $sql);
    $num_act_inm = mysqli_num_rows($ejec);
    while ($registro = mysqli_fetch_array($ejec)) {
        $matriz[] = $registro;
    }
    if ($num_act_inm > 0)
        return array($num_act_inm, $matriz);
    else return array(0, 0);
}
if ($num_sql > 0)
    list($num_paginacion, $matriz_paginacion) = consultar_lista_paginacion($conn, $sQuery);
else
    $num_paginacion = 0;


/* Data set length after filtering */
$iFilteredTotal = $num_act_inmSinLimit;

/* Total data set length */

$iTotal = $num_act_inm;


/*
     * Output
     */
$output = array(

    "iTotalRecords" => $iTotal,
    "iTotalDisplayRecords" => $iFilteredTotal,
    "aaData" => array()
);

for ($c = 0; $c < $num_paginacion; $c++) {

    $row = array();

    // Consultar el conductor
    $queryCond = "SELECT primer_nombre, segundo_nombre FROM conductores WHERE id_conductor = {$matriz_paginacion[$c]['id_conductor']}";
    $resCond = mysqli_query($conn, $queryCond);
    $dataCond = $resCond->fetch_row();

    // Consultar propietario
    $queryProp = "SELECT primer_nombre, segundo_nombre FROM propietarios WHERE id_propietario = {$matriz_paginacion[$c]['id_propietario']}";
    $resProp = mysqli_query($conn, $queryProp);
    $dataProp = $resProp->fetch_row();

    switch ($matriz_paginacion[$c]['estado']) {
        case '0':
           $estado = "<span class='badge bg-success'>Activo</span>";
            break;
        
        default:
        $estado = "<span class='badge bg-info'>Inactivo</span>";
            break;
    }


    $id = $matriz_paginacion[$c]['id'];
    $row['id'] = $id;
    $row['placa'] = $matriz_paginacion[$c]['placa'];
    $row['marca'] = $matriz_paginacion[$c]['marca'];
    $row['color'] = $matriz_paginacion[$c]['color'];
    $row['propietario'] = $dataProp[0].' '.$dataProp[1];
    $row['conductor'] = $dataCond[0].' '.$dataCond[1];
    $row['estado'] =$estado;
    $row['fecha'] = $matriz_paginacion[$c]['fecharegistro'];
    
    
    $output['aaData'][] = $row;
}

echo json_encode($output);

mysqli_close($conn);
