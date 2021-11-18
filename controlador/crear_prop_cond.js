
// variables globales
const tipoRegistro = '';

document.addEventListener("DOMContentLoaded", () => {
    // Función para validar los campos del formulario
    function validar() {
        let InputIdenl = document.getElementById("InputIden").value;
        let InputPNombrel = document.getElementById("InputPNombre").value;
        let InputApellidosl = document.getElementById("InputApellidos").value;
        let InputDireccionl = document.getElementById("InputDireccion").value;
        let InputTelefonol = document.getElementById("InputTelefono").value;
        let InputCuidadl = document.getElementById("InputCuidad").value;
        

        if (InputIdenl === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe ingresar un valor en la identificación'
            })
            return false;
        } else if (InputPNombrel === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe ingresar el primer nombre. '
            })
            return false;
        }
        else if (InputApellidosl === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe ingresar el Apellido. '
            })
            return false;
        } else if (InputDireccionl === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe ingresar una Dirección. '
            })
            return false;
        } else if (InputTelefonol === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe ingresar un teléfono. '
            })
            return false;
        } else if (InputCuidadl === '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe ingresar una Ciudad. '
            })
            return false;
        }else if($(".inputTipo").is(':checked') === false){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Debe seleccionar el tipo de registro. '
            })
            return false;
        }else if(InputTelefonol.length < 7){
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'El número telefónico debe ser mayor de 7 números. '
            })
            return false;
        }
        return true;

    }


    // Proceso para registra los propietarios y conductores
    document.getElementById("Guardardatos").addEventListener("submit", (e) => {
        e.preventDefault();

        let validador = validar();
        if (validador === true) {
            buttonGuardar.style.display = "none";
            formData = new FormData(document.getElementById("Guardardatos"));
            formData.append("registro", "true");
            fetch("../modelo/validador.php",
                {
                    method: "POST",
                    body: formData
                })
                .then(res => res.json())
                .then(res => {
                    console.log(res);
                    if (res.status == '1') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Excelente',
                            text: res.msj
                        });
                        buttonGuardar.style.display = "block";
                        $(".camposLimpiar").val('');
                        $(".inputTipo").prop("checked", false);
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
    })

    // validar solo numenros
    $("#InputIden, #InputTelefono").on("input", function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    })



});
