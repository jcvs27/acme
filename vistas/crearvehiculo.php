<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>acme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

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
        <div class="card">
            <div class="card-header h4" id="Titulo">
                Crear Vehículo
            </div>
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                    <form id="Guardardatos" method="POST" action="../modelo/validador.php" autocomplete="off">
                        <div class=" row">
                            <div class="form-group col-md-4">
                                <label for="" class="form-label">Placa</label>
                                <input maxlength="7" class="form-control camposLimpiar" type="text" name="InputPlaca" id="InputPlaca" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="" class="form-label">Color</label>
                                <input maxlength="20" class="form-control camposLimpiar" type="text" name="InputColor" id="InputColor" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="" class="form-label">Marca</label>
                                <input maxlength="20" class="form-control camposLimpiar" type="text" name="InputMarca" id="InputMarca" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="" class="form-label">Tipo Vehiculo</label>
                               <select class="form-select camposSelect" aria-label="Default select example" name="tipoVehiculo" id="tipoVehiculo" required>
                                   <option value="">Seleccionar</option>
                                   <option value="1">Público</option>
                                   <option value="2">Privado</option>
                               </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="" class="form-label">Conductor</label>
                                <select class="form-select camposSelect" aria-label="Default select example" name="selectConductor" id="selectConductor" required></select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="" class="form-label">Propietario</label>
                                <select class="form-select camposSelect" aria-label="Default select example" name="selectPropietario" id="selectPropietario" required></select>
                            </div>

                        </div><br>
                        <footer class="mt-2">
                            <button id="buttonGuardar" class="btn btn-success mb-3" type="submit">Guardar</button>
                        </footer>
                    </form>
                </blockquote>
            </div>
        </div>
        <footer class="bg-light text-center text-lg-start mt-2">
            <!-- Copyright -->
            <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                © 2021 Copyright
            </div>
            <!-- Copyright -->
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="app-assets/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../controlador/crear_vehiculo.js?id=<?php echo rand(); ?>"></script>
</body>

</html>