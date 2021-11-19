oDt = {};
oDt1 = {};
document.addEventListener("DOMContentLoaded", () => {
    // Función para validar los campos del formulario
    function validar() {

        let Inputselecondl = document.getElementById("selectConductor").value;
        let InputselecProl = document.getElementById("selectPropietario").value;

        if (Inputselecondl === '') {
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
                    $("#selectConductor_b").empty();
                    var option = "<option value=''>Seleccione</option>"
                    res.forEach(element => {
                        option += `<option value="${element[0]}">${element[1]} ${element[2]}</option>`;
                    });
                    $("#selectConductor").append(option);
                    $("#selectConductor_b").append(option);
                }

            })
            .catch(function (error) {
                buttonGuardar.style.display = "block";
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error en consultar los conductores'
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
                    $("#selectPropietario_b").empty();
                    var option = "<option value=''>Seleccione</option>"
                    res.forEach(element => {
                        option += `<option value="${element[0]}">${element[1]} ${element[2]}</option>`;
                    });
                    $("#selectPropietario").append(option);
                    $("#selectPropietario_b").append(option);
                }

            })
            .catch(function (error) {
                buttonGuardar.style.display = "block";
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error en consultar los conductores'
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
                "infoFiltered": "(filtro de _MAX_ total registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
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

    // Función para cargar el datatable historicos
    function cargarDatatableHistorico(value_1 = "", value_2 = "", value_3 = "", value_4 = "") {
        $("#tabla_2 tbody").html("");
        $(".camposLimpiar_1").val('');
        $(".camposSelect_1").val('');
        oDT1 = $("#tabla_2").DataTable({
            destroy: true,
            processing: true,
            scrollX: true,
            scrollCollapse: true,
            ORDER: [(1, "DESC"), (0, "DESC")],
            "language": {
                "lengthMenu": "Filas _MENU_ por página",
                "zeroRecords": "Sin datos",
                "info": "Pagina _PAGE_ de _PAGES_",
                "infoEmpty": "Sin Datos",
                "infoFiltered": "(filtro de _MAX_ total registros)",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
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
                {
                    data: "estado",
                    className: "text-center",
                    sortable: false,
                    visible: true,
                },
                {
                    data: "fecha",
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
                "../modelo/consultar_vehiculos_historico.php?valor1=" + value_1 + "&valor2=" + value_2 + "&valor3=" + value_3 + "&valor4=" + value_4,
            drawCallback: function (settings) {
                $(".title_tooltip").tooltip();
                $("div.dataTables_filter input").unbind();
            },
            fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

            },
        });
    }

    // Usar el buscador
    $(document).on("keyup", "[aria-controls='tabla_1']", function (e) {
        if (e.keyCode === 13) {

            $("input[type='search']").blur();
            oDT.search($("div.dataTables_filter input").val()).draw();
            return false;
        }

        if (this.value === "") {
            oDT.search("").draw();
        }
    });

    $(document).on("keyup", "[aria-controls='tabla_2']", function (e) {

        if (e.keyCode === 13) {
            $("input[aria-controls='search']").blur();
            oDT1.search($("div.dataTables_filter input").val()).draw();
            return false;
        }

        if (this.value === "") {
            oDT1.search("").draw();
        }
    });
    // Proceso para registra los propietarios y conductores
    document.getElementById("Guardardatos").addEventListener("submit", (e) => {
        e.preventDefault();

        let validador = validar();
        if (validador === true) {
            GuadarClick.style.display = "none";
            formData = new FormData(document.getElementById("Guardardatos"));
            formData.append("actualizarDatos", "true");
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
                        GuadarClick.style.display = "block";
                        $(".camposSelect").val('').change();
                        $(".cerrarModal").click();
                        oDT.ajax.reload();
                    } else {
                        GuadarClick.style.display = "block";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.msj
                        });
                    }
                })
                .catch(function (error) {
                    GuadarClick.style.display = "block";
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error en actualizar el registro'
                    });
                })
        }
    })

    // Limpiar los campos de la modal cuande este se cierra
    $(document).on('click', '.cerrarModal', () => {
        $(".camposSelect").val('').change();
    });



    // Opcion para buscar por derminados filtros en datatable historico
    document.getElementById("buscarFiltro").addEventListener("click", () => {
        let inputFechal = inputFecha.value;
        let inputplacal = inputPlaca.value;
        let selectConductorl = selectConductor_b.value;
        let selectPropietariol = selectPropietario_b.value;

        if (inputFechal === '' && inputplacal === '' && selectConductorl === '' && selectPropietariol === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Se utiliza el botón de Consultar lleno algún campo. '
            });
            return;
        }

        cargarDatatableHistorico(inputFechal, inputplacal, selectConductorl, selectPropietariol);

    })


    // Se realiza llamado a las funciones iniciales
    conductores();
    propietarios();
    cargarDatatable();
    cargarDatatableHistorico();

});

/// Buscar los datos conductor y propietarios actuales para mostrar en la modal
function buscarDatos(value = '') {
    idTab.value = value;
    fetch("../modelo/validador.php", {
        method: "POST",
        headers: { "Content-type": "application/x-www-form-urlencoded" },
        body: `buscarDatos=true&id=${value}`
    })
        .then(res => res.json())
        .then(res => {
            if (res != 0) {
                $("#selectConductor").val(res[1]).change();
                $("#selectPropietario").val(res[0]).change();
            }

        })
        .catch(function (error) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error consultar los registros'
            });
        })

}