<?php
class Viaje
{
    //Atributos
    private $codigoViaje;
    private $destino;
    private $maxPasajeros;
    private $cantPasajeros;

    //Método constructor
    public function __construct($codViaje, $lugarDestino, $maximaPasajeros, $pasajeros)
    {
        $this->codigoViaje = $codViaje;
        $this->destino = $lugarDestino;
        $this->maxPasajeros = $maximaPasajeros;
        $this->cantPasajeros = $pasajeros;
    }

    //Getters
    public function getCodigoViaje()
    {
        return $this->codigoViaje;
    }
    public function getDestino()
    {
        return $this->destino;
    }
    public function getCantMaxima()
    {
        return $this->maxPasajeros;
    }
    public function getPasajeros()
    {
        return $this->cantPasajeros;
    }

    //Setters
    public function setCodigoViaje($codigo)
    {
        $this->codigoViaje = $codigo;
    }
    public function setDestino($destino)
    {
        $this->destino = $destino;
    }
    public function setCantMaxima($nro)
    {
        $this->maxPasajeros = $nro;
    }
    public function setPasajeros($datos)
    {
        $this->cantPasajeros = $datos;
    }

    //Métodos para pasajeros
    function guardarInfoPasajeros($totalPasajeros)
    {
        while ($this->cantPasajeros > $this->maxPasajeros) {
            echo "\nError, no se puede superar el máximo permitido de pasajeros.\nIntente nuevamente: ";
            $this->setPasajeros(trim(fgets(STDIN)));
        }
        $puesto = 1;
        for ($i = 0; $i < $this->cantPasajeros; $i++) {
            $datosPasajero = [];
            echo "\n>> Indique datos del pasajero $puesto\nNombre: ";
            $datosPasajero["nombre"] = ucfirst(strtolower(trim(fgets(STDIN))));
            echo "Apellido: ";
            $datosPasajero["apellido"] = ucfirst(strtolower(trim(fgets(STDIN))));
            echo "Número de DNI: ";
            $datosPasajero["dni"] = trim(fgets(STDIN));
            $datosPasajero["codigoViaje"] = $this->codigoViaje;
            $puesto++;
            array_push($totalPasajeros, $datosPasajero);
        }
        return $totalPasajeros;
    }
    public function encontrarPasajero($pasajeros)
    {
        $i = 0;
        $n = count($pasajeros);
        $index = -1;

        echo "\nIndique DNI del pasajero: ";
        $dni = trim(fgets(STDIN));
        while ($i < $n) {
            if ($dni == $pasajeros[$i]["dni"]) {
                $index = $i;
                $i = $n;
            }
            $i++;
        }
        return $index;
    }
    public function modificarDatosPasajero($pasajeros)
    {
        $index = $this->encontrarPasajero($pasajeros);

        if ($index == -1) {
            echo "Ningún pasajero encontrado.\n";
        } else {
            echo "\n1- Modificar nombre\n2- Modificar apellido\n3- Modificar DNI\nSeleccione opción: ";
            $rta = trim(fgets(STDIN));
            while ($rta < 1 || $rta > 3) {
                echo "Error.\nIntente nuevamente: ";
                $rta = trim(fgets(STDIN));
            }
            switch ($rta) {
                case 1: {
                        echo "\nIndique nuevo nombre: ";
                        $pasajeros[$index]["nombre"] = trim(fgets(STDIN));
                        break;
                    }
                case 2: {
                        echo "\nIndique nuevo apellido: ";
                        $pasajeros[$index]["apellido"] = trim(fgets(STDIN));
                        break;
                    }
                case 3: {
                        echo "Número de DNI: ";
                        $pasajeros[$index]["dni"] = trim(fgets(STDIN));
                        break;
                    }
                    break;
            }
        }
        return $pasajeros;
    }
    public function verDatosPasajero($pasajero, $viajes)
    {
        $index = $this->encontrarPasajero($pasajero);
        if ($index == -1) {
            echo "Ningún pasajero encontrado.\n";
        } else {
            foreach ($viajes as $objeto) {
                if ($objeto->codigoViaje == $pasajero[$index]["codigoViaje"]) {
                    break;
                }
            }
            echo "\n----------------------------\nNombre del pasajero: " . $pasajero[$index]["nombre"] . " " . $pasajero[$index]["apellido"] .
                "\nNúmero de DNI: " . $pasajero[$index]["dni"] . "\nAbordando viaje: " . $pasajero[$index]["codigoViaje"] .
                "\nDestino a: " . $objeto->destino . "\n----------------------------\n";
        }
    }
    public function verPasajerosViaje($pasajeros, $viaje, $index)
    {
        $j = 1;
        $n = count($pasajeros);
        for ($i = 0; $i < $n; $i++) {
            if ($pasajeros[$i]["codigoViaje"] == $viaje[$index]->codigoViaje) {
                echo "\n>> Pasajero " . $j . ": " . $pasajeros[$i]["nombre"] . " " . $pasajeros[$i]["apellido"] .
                    "\nNúmero de DNI: " . $pasajeros[$i]["dni"] . "\nAbordando viaje: " . $pasajeros[$i]["codigoViaje"] .
                    "\nDestino a: " . $viaje[$index]->getDestino() . "\n";
                $j++;
            }
        }
    }

    //Métodos para viajes
    public function buscarViaje($viajes)
    {
        $index = -1;
        echo "\nIngrese código del viaje: ";
        $codigo = trim(fgets(STDIN));

        for ($i = 0; $i < count($viajes); $i++) {
            if ($viajes[$i]->codigoViaje === $codigo) {
                $index = $i;
                break;
            }
        }
        return $index;
    }

    public function opcionCambiarDatosViaje()
    {
        echo "\n1- Modificar código\n2- Modificar destino\n3- Cambiar cantidad máxima de pasajeros\n4- Cambiar cantidad de pasajeros a bordo";
        echo "\nElija una opción: ";
        $rta = trim(fgets(STDIN));
        while ($rta < 0 || $rta > 4) {
            echo "Seleccione opción válida: ";
            $rta = trim(fgets(STDIN));
        }
        return $rta;
    }
    public function cambiarDatosViaje($viajes, $pasajeros)
    {
        $index = $this->buscarViaje($viajes);
        if ($index == -1) {
            echo "Ningún viaje coincide.\n";
        } else {
            $cambiar = $this->opcionCambiarDatosViaje();
            switch ($cambiar) {
                case 1: {
                        $id = $viajes[$index]->codigoViaje;
                        echo "\nNuevo código de viaje: ";
                        $viajes[$index]->setCodigoViaje(trim(fgets(STDIN)));
                        foreach ($pasajeros as $indice => $pasajero) {
                            if ($pasajero["codigoViaje"] === $id) {
                                $pasajeros[$indice]["codigoViaje"] = $viajes[$index]->getCodigoViaje();
                            }
                        }
                        break;
                    }
                case 2: {
                        echo "\nNuevo lugar de destino: ";
                        $viajes[$index]->setDestino(trim(fgets(STDIN)));
                        break;
                    }
                case 3: {
                        echo "\nCantidad máxima actualizada: ";
                        $viajes[$index]->setCantMaxima(trim(fgets(STDIN)));
                        break;
                    }
                case 4: {
                        echo "\nCantidad pasajeros a bordo actualizada: ";
                        $viajes[$index]->setPasajeros(trim(fgets(STDIN)));
                        break;
                    }
            }
        }
        return $pasajeros;
    }
    public function mostrarDatosViaje($pasajeros, $index)
    {
        return "\n<< Código del viaje: " . $pasajeros[$index]->codigoViaje . " >>\nDestino: " . $pasajeros[$index]->destino .
            "\nCantidad máxima de pasajeros: " . $pasajeros[$index]->maxPasajeros .
            "\nTotal de pasajeros a bordo: " . $pasajeros[$index]->cantPasajeros . "\n";
    }
}
