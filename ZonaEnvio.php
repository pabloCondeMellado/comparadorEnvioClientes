<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

class ZonaEnvio {

public function determinarZonaEnvio($origenCP, $destinoCP){
    // Definir las provincias y sus códigos postales
    $provincias = [
        'Álava' => range(1000, 1999),
        'Albacete' => range(2000, 2999),
        'Alicante' => range(3000, 3999),
        'Almería' => range(4000, 4999),
        'Asturias' => range(33000, 33999),
        'Ávila' => range(5000, 5999),
        'Badajoz' => range(6000, 6999),
        'Barcelona' => range(8000, 8999),
        'Burgos' => range(9000, 9999),
        'Cáceres' => range(10000, 10999),
        'Cádiz' => range(11000, 11999),
        'Cantabria' => range(39000, 39999),
        'Castellón' => range(12000, 12999),
        'Ciudad Real' => range(13000, 13999),
        'Córdoba' => range(14000, 14999),
        'Cuenca' => range(16000, 16999),
        'Girona' => range(17000, 17999),
        'Granada' => range(18000, 18999),
        'Guadalajara' => range(19000, 19999),
        'Huelva' => range(21000, 21999),
        'Huesca' => range(22000, 22999),
        'Jaén' => range(23000, 23999),
        'La Rioja' => range(26000, 26999),
        'León' => range(24000, 24999),
        'Lleida' => range(25000, 25999),
        'Lugo' => range(27000, 27999),
        'Madrid' => range(28000, 28999),
        'Málaga' => range(29000, 29999),
        'Murcia' => range(30000, 30999),
        'Navarra' => range(31000, 31999),
        'Ourense' => range(32000, 32999),
        'Palencia' => range(34000, 34999),
        'Pontevedra' => range(36000, 36999),
        'Salamanca' => range(37000, 37999),
        'Segovia' => range(40000, 40999),
        'Sevilla' => range(41000, 41999),
        'Soria' => range(42000, 42999),
        'Tarragona' => range(43000, 43999),
        'Teruel' => range(44000, 44999),
        'Toledo' => range(45000, 45999),
        'Valencia' => range(46000, 46999),
        'Valladolid' => range(47000, 47999),
        'Vizcaya' => range(48000, 48999),
        'Zamora' => range(49000, 49999),
        'Zaragoza' => range(50000, 50999),
        'Ceuta' => range(51000, 51099),
        'Melilla' => range(52000, 52099)
    ];

    // Definir las Islas Baleares y sus códigos postales
    $baleares = range(7000, 7999); // Islas Baleares

    // Definir las Islas Canarias y sus códigos postales
    $canarias = [
        'Tenerife' => range(38000, 38999),
        'Gran Canaria' => range(35000, 35999),
        'Lanzarote' => range(35500, 35999),
        'Fuerteventura' => range(35600, 35999),
        'La Palma' => range(38700, 38799),
        'La Gomera' => range(38800, 38899),
        'El Hierro' => range(38900, 38999),
        'La Graciosa' => range(35540, 35549)
    ];
    

    // Verificar si el origen y destino están en la misma provincia
    foreach ($provincias as $provincia => $rango) {
        if (in_array($origenCP, $rango) && in_array($destinoCP, $rango)) {
            return 'Zona1'; // Mismo provincia
        }
    }

    // Verificar si el origen y destino están en la misma isla de Canarias
    foreach ($canarias as $isla => $rango) {
        if (in_array($origenCP, $rango) && in_array($destinoCP, $rango)) {
            return 'Canarias'; // Mismo isla
        }
    }

    // Verificar si el origen o destino están en Baleares, Ceuta o Melilla
    if ($this->esBalearesCeutaMelilla($origenCP, $destinoCP, $baleares)) {
        return 'Zona4'; // Baleares, Ceuta, Melilla
    }

    // Verificar si el origen y destino son provincias limítrofes
    if ($this->esProvinciaLimitrofe($origenCP, $destinoCP,$provincias)) {
        return 'Zona2'; // Provincias limítrofes
    }

    // Verificar si el origen y destino están en la península o Andorra
    if ($this->esIntraPeninsular($origenCP, $destinoCP, $baleares)) {
        return 'Zona3'; // Envíos Intra Peninsulares o Andorra
    }

    // Verificar si el envío es de larga distancia en la península o Andorra
    if ($this->esLargaDistanciaIntraPeninsular($origenCP, $destinoCP)) {
        return 'Zona3_plus'; // Larga distancia intra peninsular
    }

    // Verificar si el origen y destino son Canarias y Península (o Andorra)
    if ($this->esCanariasPenínsula($origenCP, $destinoCP)) {
        return 'Zona5'; // Envíos a Canarias con origen en Península o Andorra y viceversa
    }

    // Verificar si el origen y destino están dentro de Canarias (Interislas)
    if ($this->esCanariasInterislas($origenCP, $destinoCP)) {
        return 'Zona6'; // Envíos Interislas en Canarias
    }

    // Verificar si el origen está en la Península y el destino en Portugal Peninsular
    if ($this->esPortugalPeninsular($origenCP, $destinoCP)) {
        return 'Zona7'; // Envíos a Portugal Peninsular con origen en Península
    }

    // Verificar si el origen está en Baleares y el destino en Portugal Peninsular
    if ($this->esPortugalPeninsularDesdeBaleares($origenCP, $destinoCP)) {
        return 'Zona8'; // Envíos a Portugal Peninsular con origen en Baleares
    }

    return 'Zona desconocida'; // Si no se encuentra ninguna coincidencia
}

 // Lógica para verificar provincias limítrofes
 private function esProvinciaLimitrofe($origenCP, $destinoCP, $provincias){
     // Definir las provincias limítrofes
     $limites = [
         'Álava' => ['Vizcaya', 'Burgos', 'La Rioja'],
         'Albacete' => ['Cuenca', 'Ciudad Real', 'Jaén', 'Murcia', 'Valencia'],
         'Alicante' => ['Valencia', 'Castellón', 'Murcia'],
         'Almería' => ['Murcia', 'Granada'],
         'Asturias' => ['Cantabria', 'León', 'Zamora'],
         'Ávila' => ['Madrid', 'Segovia', 'Salamanca', 'Toledo'],
         'Badajoz' => ['Cáceres', 'Córdoba', 'Sevilla', 'Huelva'],
         'Barcelona' => ['Girona', 'Tarragona', 'Lleida', 'Zaragoza'],
         'Burgos' => ['Álava', 'La Rioja', 'Soria', 'Palencia', 'Cantabria'],
         'Cáceres' => ['Badajoz', 'Córdoba', 'Toledo', 'Madrid'],
         'Cádiz' => ['Sevilla', 'Málaga', 'Huelva', 'Córdoba'],
         'Cantabria' => ['Asturias', 'Burgos', 'Álava', 'La Rioja'],
         'Castellón' => ['Valencia', 'Teruel', 'Barcelona'],
         'Ciudad Real' => ['Toledo', 'Madrid', 'Guadalajara', 'Cuenca'],
         'Córdoba' => ['Badajoz', 'Sevilla', 'Cádiz', 'Jaén', 'Ciudad Real'],
         'Cuenca' => ['Madrid', 'Albacete', 'Valencia', 'Ciudad Real'],
         'Girona' => ['Barcelona', 'Lleida', 'Tarragona', 'Zaragoza'],
         'Granada' => ['Jaén', 'Córdoba', 'Almería', 'Málaga'],
         'Guadalajara' => ['Madrid', 'Segovia', 'Zaragoza', 'Cuenca'],
         'Huelva' => ['Cádiz', 'Sevilla', 'Badajoz', 'Málaga'],
         'Huesca' => ['Zaragoza', 'Lleida', 'La Rioja'],
         'Jaén' => ['Córdoba', 'Granada', 'Albacete'],
         'La Rioja' => ['Álava', 'Burgos', 'Soria', 'Zaragoza'],
         'León' => ['Asturias', 'Cantabria', 'Palencia', 'Zamora', 'Salamanca'],
         'Lleida' => ['Barcelona', 'Zaragoza', 'Tarragona', 'Huesca'],
         'Lugo' => ['Orense', 'A Coruña'],
         'Madrid' => ['Ávila', 'Segovia', 'Guadalajara', 'Toledo'],
         'Málaga' => ['Cádiz', 'Granada', 'Sevilla'],
         'Murcia' => ['Valencia', 'Alicante', 'Albacete', 'Andalucía'],
         'Navarra' => ['La Rioja', 'Huesca', 'Zaragoza'],
         'Ourense' => ['Lugo', 'Pontevedra', 'Zamora'],
         'Palencia' => ['Burgos', 'León', 'Valladolid', 'Segovia'],
         'Pontevedra' => ['A Coruña', 'Ourense'],
         'Salamanca' => ['Ávila', 'Zamora', 'Cáceres', 'León'],
         'Segovia' => ['Ávila', 'Madrid', 'Guadalajara', 'Valladolid'],
         'Sevilla' => ['Cádiz', 'Córdoba', 'Badajoz', 'Huelva'],
         'Soria' => ['Burgos', 'La Rioja', 'Zaragoza'],
         'Tarragona' => ['Barcelona', 'Lleida', 'Valencia'],
         'Teruel' => ['Castellón', 'Valencia', 'Zaragoza'],
         'Toledo' => ['Madrid', 'Ávila', 'Guadalajara', 'Ciudad Real'],
         'Valencia' => ['Castellón', 'Alicante', 'Cuenca', 'Teruel'],
         'Valladolid' => ['Palencia', 'León', 'Salamanca'],
         'Vizcaya' => ['Álava', 'Cantabria', 'Burgos'],
         'Zamora' => ['León', 'Salamanca', 'Ourense'],
         'Zaragoza' => ['Huesca', 'Lleida', 'Teruel', 'La Rioja', 'Navarra']
     ];

     // Verificar si el origen y destino están en provincias limítrofes
     foreach ($limites as $provincia => $limitesVecinos) {
         if (in_array($origenCP, $provincias[$provincia]) && $this->esProvinciaVecina($destinoCP, $limitesVecinos, $provincias)) {
             return true;
         }
     }

     return false;
 }

    // Verificar si una provincia de destino está en las provincias vecinas
    private function esProvinciaVecina($destinoCP, $limitesVecinos, $provincias){
        foreach ($limitesVecinos as $vecino) {
            if (in_array($destinoCP, $provincias[$vecino])) {
                return true;
            }
        }

        return false;
    }

// Lógica para verificar si el envío es Intra Peninsular
private function esIntraPeninsular($origenCP, $destinoCP, $baleares){
    // Definir si el origen y destino están en la península
    return !$this->esCanariasInterislas($origenCP, $destinoCP) && !$this->esBalearesCeutaMelilla($origenCP, $destinoCP, $baleares)&& !$this->esCanariasPenínsula($origenCP, $destinoCP) &&!$this->esLargaDistanciaIntraPeninsular($origenCP,$destinoCP);
}

// Verificar si el envío es de larga distancia Intra Peninsular
private function esLargaDistanciaIntraPeninsular($origenCP, $destinoCP){
    // Ejemplo, se puede basar en rangos de CP más alejados
    return abs($origenCP - $destinoCP) > 10000;
}

// Verificar si el origen o destino son Baleares, Ceuta o Melilla
private function esBalearesCeutaMelilla($origenCP, $destinoCP, $baleares){
    return in_array($origenCP, $baleares) || in_array($destinoCP, $baleares) || $origenCP >= 51000 && $origenCP <= 51999 || $destinoCP >= 51000 && $destinoCP <= 51999;
}

// Verificar si el envío es a Canarias desde la Península
private function esCanariasPenínsula($origenCP, $destinoCP){
    // Definir que uno está en Canarias y el otro en la Península
    return ($origenCP >= 35000 && $origenCP <= 38999 && $destinoCP >= 28000 && $destinoCP <= 28999) || ($origenCP >= 28000 && $origenCP <= 28999 && $destinoCP >= 35000 && $destinoCP <= 38999);
}

// Verificar si el envío es Interislas en Canarias
private function esCanariasInterislas($origenCP, $destinoCP){
    return ($origenCP >= 35000 && $origenCP <= 38999) && ($destinoCP >= 35000 && $destinoCP <= 38999);
}

// Función para determinar si el código postal es de Portugal o España
private function paisDesdeCP($codigoPostal) {
    $portugal = [
        'Lisboa' => [1000, 1999],
        'Porto' => [4000, 4999],
        'Braga' => [4700, 4799],
        'Aveiro' => [3800, 3899],
        'Coimbra' => [3000, 3099],
        'Faro (Algarve)' => [8000, 8999],
        'Setúbal' => [2900, 2999],
        'Leiria' => [2400, 2499],
        'Viseu' => [3500, 3599],
        'Madeira' => [9000, 9999],
        'Açores (Azores)' => [9500, 9599],
    ];
    
    $provincias = [
        'Álava' => [1000, 1999],
        'Albacete' => [2000, 2999],
        'Alicante' => [3000, 3999],
        'Almería' => [4000, 4999],
        'Asturias' => [33000, 33999],
        'Ávila' => [5000, 5999],
        'Badajoz' => [6000, 6999],
        'Barcelona' => [8000, 8999],
        'Burgos' => [9000, 9999],
        'Cáceres' => [10000, 10999],
        'Cádiz' => [11000, 11999],
        'Cantabria' => [39000, 39999],
        'Castellón' => [12000, 12999],
        'Ciudad Real' => [13000, 13999],
        'Córdoba' => [14000, 14999],
        'Cuenca' => [16000, 16999],
        'Girona' => [17000, 17999],
        'Granada' => [18000, 18999],
        'Guadalajara' => [19000, 19999],
        'Huelva' => [21000, 21999],
        'Huesca' => [22000, 22999],
        'Jaén' => [23000, 23999],
        'La Rioja' => [26000, 26999],
        'León' => [24000, 24999],
        'Lleida' => [25000, 25999],
        'Lugo' => [27000, 27999],
        'Madrid' => [28000, 28999],
        'Málaga' => [29000, 29999],
        'Murcia' => [30000, 30999],
        'Navarra' => [31000, 31999],
        'Ourense' => [32000, 32999],
        'Palencia' => [34000, 34999],
        'Pontevedra' => [36000, 36999],
        'Salamanca' => [37000, 37999],
        'Segovia' => [40000, 40999],
        'Sevilla' => [41000, 41999],
        'Soria' => [42000, 42999],
        'Tarragona' => [43000, 43999],
        'Teruel' => [44000, 44999],
        'Toledo' => [45000, 45999],
        'Valencia' => [46000, 46999],
        'Valladolid' => [47000, 47999],
        'Vizcaya' => [48000, 48999],
        'Zamora' => [49000, 49999],
        'Zaragoza' => [50000, 50999],
        'Ceuta' => [51000, 51099],
        'Melilla' => [52000, 52099],
    ];

    // Verificar si el código postal está en el rango de Portugal
    foreach ($portugal as $rango) {
        if ($codigoPostal >= $rango[0] && $codigoPostal <= $rango[1]) {
            return 'Portugal';
        }
    }

    // Verificar si el código postal está en el rango de España
    foreach ($provincias as $rango) {
        if ($codigoPostal >= $rango[0] && $codigoPostal <= $rango[1]) {
            return 'España';
        }
    }

    return 'Desconocido'; // Si no pertenece a ninguno de los dos
}

// Verificación si el origen está en Portugal Peninsular y el destino en otro país
private function esPortugalPeninsular($origenCP, $destinoCP) {
    // Obtener los países de origen y destino
    $origenPais = $this->paisDesdeCP($origenCP);
    $destinoPais = $this->paisDesdeCP($destinoCP);

    // Verificar si el origen está en Portugal Peninsular y el destino está en España
    if ($origenPais === 'Portugal' && $destinoPais === 'España') {
        return 'Zona7'; // Envíos a Portugal Peninsular desde España
    }

    return 'Fuera de la zona'; // Si no es Portugal Peninsular y España
}


// Verificar si el envío es a Portugal desde Baleares
private function esPortugalPeninsularDesdeBaleares($origenCP, $destinoCP){
    return ($origenCP >= 7000 && $origenCP <= 7999) && ($destinoCP >= 1000 && $destinoCP <= 9999);
}

// Obtener el rango de CP de una provincia (para simplificar)
private function getRangoDeCP($provincia){
    // ... Lógica de los rangos por provincias
}

}
