<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.css" />
    <link rel="stylesheet" href="css/style.css">
    <title>acme</title>

</head>

<body>
    <div class="container">
        <ul class="nav nav-pills"> 
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php">Inicio</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Crear</a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" id="crearPropietario" href="crearpropietario_cod.php">Crear Persona</a></li>
                    <li><a class="dropdown-item" href="crearvehiculo.php">Crear Vehiculo</a></li>
                </ul>
            </li>
        </ul>
        <br>
        <strong>Registro Vehículos </strong>
        <p>Información de vehiculos asignados</p>
        <table class="table table-striped table-bordered" style="width:100%" id="tabla_1">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Color</th>
                    <th scope="col">Propietario</th>
                    <th scope="col">Conductor</th>
                </tr>
            </thead>
        </table>
        <br>
        <hr>
        <strong>Registro Vehículos histórico </strong>
        <p>Información de vehiculos </p>
        <div class="row">
            <div class="form-group col-md-4">
                <label class="form-label">Fecha</label>
                <input class="form-control camposLimpiar_1" type="date" name="inputFecha" id="inputFecha">
            </div>
            <div class="form-group col-md-4">
                <label class="form-label">Placa</label>
                <input class="form-control camposLimpiar_1" type="text" name="inputPlaca" id="inputPlaca">
            </div>
            <div class="form-group col-md-4">
                <label for="" class="form-label">Conductor</label>
                <select class="form-select camposSelect_1" aria-label="Default select example" name="selectConductor_b" id="selectConductor_b"></select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="" class="form-label">Propietario</label>
                <select class="form-select camposSelect_1" aria-label="Default select example" name="selectPropietario_b" id="selectPropietario_b"></select>
            </div>
            <div class="form-group col-md-1 mt-4">
                <input class="btn btn-primary form-control" type="button" name="buscar" id="buscarFiltro" value="Consultar">
            </div>
        </div>
        <br>
        <table class="table table-striped table-bordered" style="width:100%" id="tabla_2">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Placa</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Color</th>
                    <th scope="col">Propietario</th>
                    <th scope="col">Conductor</th>
                    <th scope="col">estado</th>
                    <th scope="col">fecha registro</th>
                </tr>
            </thead>
        </table>
        <br><br>


        <!-- Modal para asignar otro propietario o conductor-->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modificar Datos</h5>
                        <button type="button" class="btn-close cerrarModal" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="Guardardatos" action="../modelo/validador.php" method="POST" autocomplete="off">
                        <div class="modal-body">

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="" class="form-label">Conductor</label>
                                    <select class="form-select camposSelect" aria-label="Default select example" name="selectConductor" id="selectConductor" required></select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="" class="form-label">Propietario</label>
                                    <select class="form-select camposSelect" aria-label="Default select example" name="selectPropietario" id="selectPropietario" required></select>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="idTab" id="idTab">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary cerrarModal" data-bs-dismiss="modal">Cerrar</button>
                            <button id="GuadarClick" type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

    <footer class="bg-light text-center text-lg-start">
        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2021 Copyright
        </div>
        <!-- Copyright -->

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="app-assets/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.11.3/datatables.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <script src="../controlador/listar_vehiculos.js?id=<?php echo rand(); ?>"></script>
</body>

</html>