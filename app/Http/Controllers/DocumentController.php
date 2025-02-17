<?php

namespace App\Http\Controllers;

use App\Models\DocumentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    // Listar documentos con búsqueda opcional
    public function list(Request $request)
    {
        $search = $request->get('search');

        // Aplicar filtro si hay búsqueda
        if ($search) {
            $getRecord = DocumentModel::where('nombre', 'like', '%' . $search . '%')
                ->orWhere('categoria_grado', 'like', '%' . $search . '%')
                ->orWhere('categoria_asignatura', 'like', '%' . $search . '%')
                ->get();
        } else {
            // Obtener todos los registros
            $getRecord = DocumentModel::all();
        }

        return view('admin.documents.list', compact('getRecord'));
    }

    // Mostrar formulario para añadir un nuevo documento
    public function add(){
    $data['header_title'] = "Añadir documento";
    return view('admin.documents.add', $data);
}


    // Insertar un nuevo documento
    public function insert(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'categoria_grado' => 'required|string|max:50',
            'categoria_asignatura' => 'required|string|max:100',
            'archivo' => 'required|file|mimes:pdf,doc,docx,txt|max:2048',
        ]);
    
        try {
            // Subir archivo y obtener la ruta
            if ($request->hasFile('archivo')) {
                $file = $request->file('archivo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documentos', $filename, 'public');
                
                // Debug para verificar la ruta
                Log::info('Archivo guardado:', ['ruta' => $path]);
            }
    
            // Guardar en la base de datos
            $save = new DocumentModel;
            $save->nombre = $request->nombre;
            $save->descripcion = $request->descripcion;
            $save->categoria_grado = $request->categoria_grado;
            $save->categoria_asignatura = $request->categoria_asignatura;
            $save->archivo = $path;
            $save->save();
    
            return redirect('admin/documents/list')->with('success', 'Documento creado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar documento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al crear el documento: ' . $e->getMessage());
        }
    }

    // Mostrar formulario de edición
    public function edit($id)
    {
        $data['getRecord'] = DocumentModel::find($id);

        if (!empty($data['getRecord'])) {
            $data['header_title'] = "Editar documento";
            return view('admin.documents.edit', $data);
        } else {
            abort(404); // Error 404 si no se encuentra el documento
        }
    }

    // Actualizar un documento
    public function update(Request $request, $id){
        $document = DocumentModel::findOrFail($id);

        // Validar los campos
        $request->validate([
            'nombre' => 'required|string|max:255',  // Asegúrate de que 'nombre' sea obligatorio
            'descripcion' => 'nullable|string',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx|max:2048',  // Validar archivo
        ]);

        // Verificar que 'nombre' no sea nulo
        $document->nombre = $request->input('nombre');  // Asegúrate de que 'nombre' se esté pasando correctamente
        $document->descripcion = $request->input('descripcion');

        // Verificar si se marcó el checkbox para eliminar el archivo actual
        if ($request->has('eliminar_archivo') && $request->input('eliminar_archivo') == 1) {
            // Eliminar archivo actual si existe
            if ($document->archivo && Storage::exists($document->archivo)) {
                Storage::delete($document->archivo);
            }
            $document->archivo = null; // Eliminar referencia al archivo
        }

        // Manejar la subida de un nuevo archivo
        if ($request->hasFile('archivo')) {
            // Eliminar el archivo actual antes de guardar el nuevo
            if ($document->archivo && Storage::exists($document->archivo)) {
                Storage::delete($document->archivo);
            }

            // Guardar el nuevo archivo
            $rutaArchivo = $request->file('archivo')->store('documentos', 'public');  // Asegúrate de usar 'public' para almacenamiento público
            $document->archivo = $rutaArchivo;
        }

        // Guardar los cambios
        $document->save();

        return redirect('admin/documents/list')->with('success', 'Documento actualizado correctamente.');
    }


    // Eliminar un documento
    public function delete($id)
    {
        $record = DocumentModel::find($id);
        if ($record) {
            Storage::disk('public')->delete($record->archivo);
            $record->delete();
            return redirect()->back()->with('success', 'Documento eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'El documento no existe.');
        }
    }
    
    public function downloadDocument($id)
    {
        try {
            $document = DocumentModel::findOrFail($id);
    
            Log::info('Intentando descargar archivo:', [
                'ruta_almacenada' => $document->archivo
            ]);
    
            // Verificar si el archivo existe
            if (!Storage::disk('public')->exists($document->archivo)) {
                return redirect()->back()->with('error', 'El archivo no existe en el servidor');
            }
    
            // Obtener la ruta física del archivo
            $filePath = storage_path('app/public/' . $document->archivo);
    
            // Obtener el nombre original del archivo
            $fileName = basename($document->archivo);
    
            // Retornar el archivo para descarga
            return response()->download($filePath, $fileName);
    
        } catch (\Exception $e) {
            Log::error('Error en la descarga: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo descargar el archivo: ' . $e->getMessage());
        }
    }
}
