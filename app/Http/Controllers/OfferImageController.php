<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfferImageController extends Controller
{
    // Listar todas las ofertas
    public function list()
    {
        // Aquí obtendrías todas las ofertas, por ejemplo, desde la base de datos
        return response()->json(['message' => 'Listado de ofertas']);
    }

    // Mostrar una oferta específica por ID
    public function show($id)
    {
        // Aquí obtendrías una oferta específica desde la base de datos usando el $id
        return response()->json(['message' => 'Detalles de la oferta con ID ' . $id]);
    }

    // Crear una nueva oferta
    public function save(Request $request)
    {
        // Aquí guardarías la nueva oferta con los datos enviados en la petición
        return response()->json(['message' => 'Oferta creada exitosamente']);
    }

    // Eliminar una oferta
    public function destroy($id)
    {
        // Aquí eliminarías la oferta con el ID especificado
        return response()->json(['message' => 'Oferta eliminada exitosamente']);
    }
}