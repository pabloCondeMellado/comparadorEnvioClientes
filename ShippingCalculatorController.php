<?php
include 'ZonaEnvio.php';
class ShippingCalculatorController
{
    public function calcularEnvio($request)
    {
        $tipoEnvio = $request['tipoEnvio'] ?? null;
        $origenPais = $request['origen']['pais'] ?? null;
        $origenCP = $request['origen']['cp'] ?? null;
        $destinoPais = $request['destino']['pais'] ?? null;
        $destinoCP = $request['destino']['cp'] ?? null;
        $peso = $request['peso'] ?? null;
        $dimensiones = $request['dimensiones'] ?? [];

        if (!$tipoEnvio || !$origenPais || !$origenCP || !$destinoPais || !$destinoCP || !$peso || empty($dimensiones)) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        // Calcular el costo de envío
        $shippingCalculator = new ZonaEnvio();
        $pesoVolumetrico = $shippingCalculator->calcularPesoVolumetrico($dimensiones);
        $zonaEnvio = $shippingCalculator->determinarZonaEnvio($origenCP, $destinoCP);

        // Ejemplo de lógica de cálculo de costos
        $costoBase = 10; // Costo base para el envío
        $costo = $costoBase + ($peso * 2) + ($pesoVolumetrico * 1.5) + $zonaEnvio;

        return [
            'costo' => $costo,
            'moneda' => 'EUR',
            'tipoEnvio' => $tipoEnvio,
        ];
    }
}