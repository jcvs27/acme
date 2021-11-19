oDt = {};
document.addEventListener("DOMContentLoaded", () => {
    // Función para validar los campos del formulario
    function validar() {
        let InputPlacal = document.getElementById("InputPlaca").value;
        let InputColorl = document.getElementById("InputColor").value;
        let InputSMarcal = document.getElementById("InputMarca").value;
        let Inputtipol = document.getElementById("tipoVehiculo").value;
        let Inputselecondl = document.getElementById("selectConductor").value;
        let InputselecProl = document.getElementById("selectPropietario").value;


        if (InputPlacal === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe ingresar un valor en la Placa. '
            })
            return false;
        } else if (InputColorl === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe ingresar el color del Vehículo. '
            })
            return false;
        } else if (InputSMarcal === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe ingresar la Marca del vehículo. '
            })
            return false;
        }
        else if (Inputtipol === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe Seleccionar un tipo de Vehiculo. '
            })
            return false;
        } else if (Inputselecondl === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe seleccionar un Conductor. '
            })
            return false;
        } else if (InputselecProl === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe seleccionar un propietario. '
            })
            return false;
        }
        return true;

    }


    // Función para cargar los conductores
    function conductores() {
        fetch("../modelo/validador.php", {
            method: "POST",
            headers: { "Content-type": "application/x-www-form-urlencoded" },
            body: "conductores=true"
        })
            .then(res => res.json())
            .then(res => {
                if (res != 0) {
                    $("#selectConductor").empty();
                    var option = "<option value=''>Seleccione</option>"
                    res.forEach(element => {
                        option += `<option value="${element[0]}">${element[1]} ${element[2]}</option>`;
                    });
                    $("#selectConductor").append(option);
                }

            })
            .catch(function (error) {
                buttonGuardar.style.display = "block";
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error en procesar en consultar los conductores'
                });
            })
    };

    // Función para cargar los propietarios
    function propietarios() {
        fetch("../modelo/validador.php", {
            method: "POST",
            headers: { "Content-type": "application/x-www-form-urlencoded" },
            body: "propietarios=true"
        })
            .then(res => res.json())
            .then(res => {
                if (res != 0) {
                    $("#selectPropietario").empty();
                    var option = "<option value=''>Seleccione</option>"
                    res.forEach(element => {
                        option += `<option value="${element[0]}">${element[1]} ${element[2]}</option>`;
                    });
                    $("#selectPropietario").append(option);
                }

            })
            .catch(function (error) {
                buttonGuardar.style.display = "block";
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error en procesar en consultar los conductores'
                });
            })
    };

    // Función para cargar el datatable
    function cargarDatatable() {
        $("#tabla_1 tbody").html("");
        oDT = $("#tabla_1").DataTable({
            destroy: true,
            processing: true,
            scrollX: true,
            scrollCollapse: true,
            ORDER: [(0, "DESC")],
            "language": {
                "lengthMenu": "Filas _MENU_ por página",
                "zeroRecords": "Sin datos",
                "info": "Pagina _PAGE_ de _PAGES_",
                "infoEmpty": "Sin Datos",
                "infoFiltered": "(filtro de _MAX_ total registros)"
            },
            columns: [
                { data: "id", className: "text-center", sortable: true, visible: true },
                {
                    data: "placa",
                    className: "text-center",
                    sortable: true,
                    visible: true,
                },
                {
                    data: "marca",
                    className: "text-center",
                    sortable: true,
                    visible: true,
                },
                {
                    data: "color",
                    className: "text-center",
                    sortable: true,
                    visible: true,
                },
                {
                    data: "propietario",
                    className: "text-center",
                    sortable: false,
                    visible: true,
                },
                {
                    data: "conductor",
                    className: "text-center",
                    sortable: false,
                    visible: true,
                },
            ],
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"],
            ],
            ajax:
                "../modelo/consultar_vehiculos.php",
            drawCallback: function (settings) {
                $(".title_tooltip").tooltip();
                $("div.dataTables_filter input").unbind();
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
               
            },
        });
    }

    // Proceso para registra los propietarios y conductores
    /*document.getElementById("Guardardatos").addEventListener("submit", (e) => {
        e.preventDefault();

        let validador = validar();
        if (validador === true) {
            buttonGuardar.style.display = "none";
            formData = new FormData(document.getElementById("Guardardatos"));
            formData.append("registroVehiculo", "true");
            fetch("../modelo/validador.php",
                {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    if (res.status === '1') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Excelente',
                            text: res.msj
                        });
                        buttonGuardar.style.display = "block";
                        $(".camposLimpiar").val('');
                        $(".camposSelect").val('').change();
                    } else {
                        buttonGuardar.style.display = "block";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.msj
                        });
                    }
                })
                .catch(function (error) {
                    buttonGuardar.style.display = "block";
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error en procesar el registro'
                    });
                })
        }
    })*/
    // Se realiza llamado a las funciones iniciales
    conductores();
    propietarios();
    cargarDatatable();

});