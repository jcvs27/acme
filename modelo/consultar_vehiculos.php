<?php

error_reporting(0);
require "./conexion.php";
$conn = conectar();
$order_ini = "id DESC";
function consultar_lista_datos_tabla($conn)
{

    $fecha_1 = "";
    $fecha_2 = "";
    $sql = "SELECT id, placa, color,  marca, conductor, propietario  FROM vehiculos v
                INNER JOIN propietarios p ON v.propietario = p.id_propietario
                INNER JOIN conductores c ON v.conductor = c.id_conductor";


    //Resto
    $resto_sql = "";

    $from_where = " WHERE 1=1 ";
    /*if ($fecha !== "") {
        $fechas  = explode("-", $fecha);
        $fecha_1 = explode("-", str_replace("/", "-", $fechas[0]));
        $fecha_2 = explode("-", str_replace("/", "-", $fechas[1]));
    }

    if (is_array($fecha_1) && is_array($fecha_2)) {
        $from_where .= " AND vac.fecha_reg >= '" . trim($fecha_1[2]) . "-" . trim($fecha_1[1]) . "-" . trim($fecha_1[0]) . " 00:00:00' AND vac.fecha_reg <= '" . trim($fecha_2[2]) . "-" . trim($fecha_2[1]) . "-" . trim($fecha_2[0]) . " 23:59:59' ";
    } else{
        $fecha_hoy = date("Y-m-d");
        $fecha_ini = date("Y-m-d", strtotime($fecha_hoy . " -30 days"));
        $from_where .= " AND vac.fecha_reg >= '" . $fecha_ini . " 00:00:00' AND vac.fecha_reg <= '" . $fecha_hoy . " 23:59:59' ";
        
    }

    if($malla !== ""){
        $from_where .= " AND malla = '$malla'";
    }

    if($sector !== ""){
        $from_where .= " AND sector = '$sector'";
    }

    if($ctaCon !== ""){
        $from_where .= " AND ctacontrato = '$ctaCon'";
    }

    if($prod !== ""){
        $from_where .= " AND producto LIKE '%$prod%'";
    }

    if($munic !== ""){
        $from_where .= " AND municipio = '$munic'";
    } 

    if($idusu !== ""){
        $from_where .= " AND vac.id_usu = '$idusu' and estado_venta != '0'";
    }*/

    
    
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


/*if (isset($_GET['fecha']))
    $fecha = $_GET['fecha'];
else $fecha = '';
if (isset($_GET['malla']))
    $malla = $_GET['malla'];
else $malla = '';
if (isset($_GET['sector']))
    $sector = $_GET['sector'];
else $sector = '';
if (isset($_GET['munic']))
    $munic = $_GET['munic'];
else $munic = '';
if (isset($_GET['prod']))
    $prod = $_GET['prod'];
else $prod = '';
if (isset($_GET['ctaCon']))
    $ctaCon = $_GET['ctaCon'];
else $ctaCon = '';
if (isset($_GET['idusu']))
    $idusu = $_GET['idusu'];
else $idusu = '';*/


list($num_lista_api, $datos_lista_api, $sql_all, $from_where) = consultar_lista_datos_tabla($conn);
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

//echo $sQuery;
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
    $queryCond = "SELECT primer_nombre, segundo_nombre FROM conductores WHERE id_conductor = {$matriz_paginacion[$c]['conductor']}";
    $resCond = mysqli_query($conn, $queryCond);
    $dataCond = $resCond->fetch_row();

    // Consultar propietario
    $queryProp = "SELECT primer_nombre, segundo_nombre FROM propietarios WHERE id_propietario = {$matriz_paginacion[$c]['propietario']}";
    $resProp = mysqli_query($conn, $queryProp);
    $dataProp = $resProp->fetch_row();

    $id = '<button idTabla="'.$matriz_paginacion[$c]['id'].'" id="editarDatos" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"  title="Modificar" class="btn btn-outline-info"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
      </svg> '.$matriz_paginacion[$c]['id'].'</button>' ;
    $row['id'] = $id;
    $row['placa'] = $matriz_paginacion[$c]['placa'];
    $row['marca'] = $matriz_paginacion[$c]['marca'];
    $row['color'] = $matriz_paginacion[$c]['color'];
    $row['propietario'] = $dataProp[0].' '.$dataProp[1];
    $row['conductor'] = $dataCond[0].' '.$dataCond[1];
    
    
    $output['aaData'][] = $row;
}

echo json_encode($output);

mysqli_close($conn);
