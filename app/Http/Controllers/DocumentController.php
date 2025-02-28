<?php

namespace App\Http\Controllers;

use App\Models\DocumentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    // Listar documentos con búsqueda opcional
    public function list(Request $request)
    {
        $search = $request->get('search');
        $userType = Auth::user()->user_type;
    
        // Aplicar filtro si hay búsqueda
        if ($search) {
            $getRecord = DocumentModel::where('nombre', 'like', '%' . $search . '%')
                ->orWhere('categoria_grado', 'like', '%' . $search . '%')
                ->orWhere('categoria_asignatura', 'like', '%' . $search . '%')
                ->get();
        } else {
            $getRecord = DocumentModel::all();
        }
    
        $view = request()->segment(1) == 'admin' ? 'admin.documents.list' : 'teacher.documents.list';
        return view($view, compact('getRecord'));
    }

    // Mostrar formulario para añadir un nuevo documento
    public function add()
    {
        $data['header_title'] = "Añadir documento";
        return view('admin.documents.add', $data); // Usar la misma vista para ambos roles
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
            if ($request->hasFile('archivo')) {
                $file = $request->file('archivo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('documentos', $filename, 'public');
                Log::info('Archivo guardado:', ['ruta' => $path]);
            }

            $save = new DocumentModel;
            $save->nombre = $request->nombre;
            $save->descripcion = $request->descripcion;
            $save->categoria_grado = $request->categoria_grado;
            $save->categoria_asignatura = $request->categoria_asignatura;
            $save->archivo = $path;
            $save->save();

            $redirectRoute = Auth::user()->user_type == 1 ? 'admin.documents.list' : 'teacher.documents.list';
            return redirect()->route($redirectRoute)->with('success', 'Documento creado correctamente.');
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
            return view('admin.documents.edit', $data); // Usar la misma vista para ambos roles
        } else {
            abort(404);
        }
    }

    // Actualizar un documento
    public function update(Request $request, $id)
    {
        $document = DocumentModel::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'archivo' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $document->nombre = $request->input('nombre');
        $document->descripcion = $request->input('descripcion');

        if ($request->has('eliminar_archivo') && $request->input('eliminar_archivo') == 1) {
            if ($document->archivo && Storage::exists($document->archivo)) {
                Storage::delete($document->archivo);
            }
            $document->archivo = null;
        }

        if ($request->hasFile('archivo')) {
            if ($document->archivo && Storage::exists($document->archivo)) {
                Storage::delete($document->archivo);
            }
            $rutaArchivo = $request->file('archivo')->store('documentos', 'public');
            $document->archivo = $rutaArchivo;
        }

        $document->save();

        $redirectRoute = Auth::user()->user_type == 1 ? 'admin.documents.list' : 'teacher.documents.list';
        return redirect()->route($redirectRoute)->with('success', 'Documento actualizado correctamente.');
    }

    // Eliminar un documento
    public function delete($id)
    {
        $record = DocumentModel::find($id);
        if ($record) {
            Storage::disk('public')->delete($record->archivo);
            $record->delete();
            $redirectRoute = Auth::user()->user_type == 1 ? 'admin.documents.list' : 'teacher.documents.list';
            return redirect()->route($redirectRoute)->with('success', 'Documento eliminado correctamente.');
        } else {
            return redirect()->back()->with('error', 'El documento no existe.');
        }
    }

    public function downloadDocument($id)
    {
        try {
            $user = Auth::user();
            Log::info('Usuario intentando descargar:', [
                'user_id' => $user ? $user->id : null,
                'user_type' => $user ? $user->user_type : 'No autenticado'
            ]);

            $document = DocumentModel::findOrFail($id);
            Log::info('Intentando descargar archivo:', [
                'document_id' => $document->id,
                'ruta_almacenada' => $document->archivo
            ]);

            if (!Storage::disk('public')->exists($document->archivo)) {
                Log::warning('Archivo no encontrado en storage:', ['ruta' => $document->archivo]);
                return redirect()->back()->with('error', 'El archivo no existe en el servidor');
            }

            $filePath = storage_path('app/public/' . $document->archivo);
            Log::info('Ruta física del archivo:', ['filePath' => $filePath]);

            if (!file_exists($filePath)) {
                Log::warning('Archivo no existe en el sistema:', ['filePath' => $filePath]);
                return redirect()->back()->with('error', 'El archivo no se encuentra en el servidor');
            }

            $fileName = basename($document->archivo);
            return response()->download($filePath, $fileName);
        } catch (\Exception $e) {
            Log::error('Error en la descarga: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'No se pudo descargar el archivo: ' . $e->getMessage());
        }
    }

    public function documentShow(Request $request)
    {
        if (!Auth::check()) {
            Log::warning('No hay usuario autenticado al intentar acceder a documentShow');
            return redirect()->route('login')->with('error', 'Por favor, inicia sesión.');
        }

        $student = Auth::user();
        Log::info('Usuario autenticado:', ['id' => $student->id, 'user_type' => $student->user_type]);

        if ($student->user_type != 3) {
            Log::warning('Usuario no es estudiante:', ['user_type' => $student->user_type]);
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        $classes = $student->classes;
        Log::info('Grupos del estudiante:', [
            'class_ids' => $classes->pluck('id')->toArray(),
            'class_names' => $classes->pluck('nombre')->toArray(),
            'grados' => $classes->pluck('grado')->toArray()
        ]);

        $documents = collect();

        if ($classes->isEmpty()) {
            Log::warning('Estudiante sin grupos asignados', ['student_id' => $student->id]);
            return view('student.documents.document_show', compact('documents'))
                ->with('error', 'No tienes grupos asignados. Contacta al administrador.');
        }

        $grados = $classes->pluck('grado')->toArray();
        Log::info('Grados para filtrar:', ['grados' => $grados]);

        $search = $request->get('search');
        if ($search) {
            $documents = DocumentModel::whereIn('categoria_grado', $grados)
                ->where(function ($query) use ($search) {
                    $query->where('nombre', 'like', '%' . $search . '%')
                          ->orWhere('categoria_asignatura', 'like', '%' . $search . '%');
                })
                ->get();
        } else {
            $documents = DocumentModel::whereIn('categoria_grado', $grados)
                ->orWhere(function ($query) use ($grados) {
                    foreach ($grados as $grado) {
                        $query->orWhere('categoria_grado', 'like', '%' . $grado . '%');
                    }
                })
                ->get();
        }

        Log::info('Documentos filtrados:', ['count' => $documents->count(), 'documents' => $documents->toArray()]);

        if ($documents->isEmpty()) {
            return view('student.documents.document_show', compact('documents'))
                ->with('warning', 'No hay documentos disponibles para tus grados.');
        }

        return view('student.documents.document_show', compact('documents'));
    }
}