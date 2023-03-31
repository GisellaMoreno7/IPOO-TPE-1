<?php
include 'Viaje.php';

//Nueva instancia (Precarga de viaje y datos de pasajeros)
$viaje = ["codigo" => "J-MnKN29t4S", "destino" => "La Pampa", "maxPasajeros" => 5, "totalAbordo" => 3];
$datosPasajeros = array(
    array("nombre" => "Pepito", "apellido" => "Pérez", "dni" => 445632, "codigoViaje" => $viaje["codigo"]),
    array("nombre" => "Zulma", "apellido" => "Gimenez", "dni" => 343234, "codigoViaje" => $viaje["codigo"]),
    array("nombre" => "Martín", "apellido" => "Juliano", "dni" => 455344, "codigoViaje" => $viaje["codigo"])
);
$viaje = new Viaje($viaje["codigo"], $viaje["destino"], $viaje["maxPasajeros"], $viaje["totalAbordo"]);
$totalViajes = [];
array_push($totalViajes, $viaje);

/**
 * Imprime menú de opciones, retorna número de opción válida
 * @return int
 */
function menuOpciones()
{
    echo "\n1- Añadir información de nuevo viaje\n2- Modificar datos del viaje\n3- Información de un viaje\n";
    echo "4- Ver pasajeros de un viaje\n";
    echo "5- Modificar datos de pasajero\n6- Ver datos de pasajero\n7- Salir\nSeleccione una opción: ";
    $rta = trim(fgets(STDIN));
    while ($rta < 1 || $rta > 7) {
        echo "\nError, ingrese opción válida\nIntente nuevamente: ";
        $rta = trim(fgets(STDIN));
    }
    return $rta;
}
/**
 * Almacena datos de un viaje, retorna array con su información
 * @return array
 */
function guardarDatosViaje()
{
    echo "\n>> Indique los siguientes datos\nCódigo de viaje: ";
    $codeViaje = trim(fgets(STDIN));
    echo "Lugar de destino: ";
    $destino = ucfirst(strtolower(trim(fgets(STDIN))));
    echo "Cantidad máxima de pasajeros: ";
    $maxPasajeros = trim(fgets(STDIN));
    echo "Cantidad de pasajeros a bordo: ";
    $pasajerosDentro = trim(fgets(STDIN));
    $datosViaje = ["codigo" => $codeViaje, "destino" => $destino, "maxPasajeros" => $maxPasajeros, "totalAbordo" => $pasajerosDentro];
    return $datosViaje;
}

//PROGRAMA PRINCIPAL
echo "\n----------------------------";
echo "\n| Ha ingresado al programa |\n";
echo "----------------------------";
$opcion = menuOpciones();
while ($opcion != 7) {
    switch ($opcion) {
        case 1: {
                $viaje = guardarDatosViaje();
                $viaje = new Viaje($viaje["codigo"], $viaje["destino"], $viaje["maxPasajeros"], $viaje["totalAbordo"]);
                array_push($totalViajes, $viaje);
                $maxPasajeros = $viaje->getCantMaxima();
                $cantPasajeros = $viaje->getPasajeros();
                $datosPasajeros = $viaje->guardarInfoPasajeros($datosPasajeros);
                break;
            }
        case 2: {
                $datosPasajeros = $viaje->cambiarDatosViaje($totalViajes, $datosPasajeros);
                break;
            }
        case 3: {
                $indice = $viaje->buscarViaje($totalViajes);
                if ($indice == -1) {
                    echo "Ningún viaje encontrado.\n";
                } else {
                    echo "\n-----------------------------";
                    echo $viaje->mostrarDatosViaje($totalViajes, $indice);
                    echo "-----------------------------\n";
                }
                break;
            }
        case 4: {
                $indice = $viaje->buscarViaje($totalViajes);
                echo "\n-----------------------------";
                echo $viaje->verPasajerosViaje($datosPasajeros, $totalViajes, $indice);
                echo "-----------------------------\n";
                break;
            }
        case 5: {
                $datosPasajeros = $viaje->modificarDatosPasajero($datosPasajeros);
                break;
            }
        case 6: {
                echo $viaje->verDatosPasajero($datosPasajeros, $totalViajes);
                break;
            }
    }
    echo "\n>> Viajes registrados: " . count($totalViajes);
    $opcion = menuOpciones();
}
echo "\nHa salido del menú de opciones.";
