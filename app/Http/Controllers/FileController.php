<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use DB;
use Intervention\Image\ImageManagerStatic as Image;

class FileController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt');
    }


    /**
     * Get todos los archivos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Types()
    {
        $result = DB::table('File')
                     ->select(DB::raw('count(*) as count, extension'))
                     ->groupBy('extension')
                     ->get();
        return response()->json($result);
    }

    /**
     * Get todos los archivos.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Index(Request $request)
    {
        if($request->has('extension'))
        {
            $result = File::where('extension',$request->extension)->get();
        }
        else
        {
            $result = File::all();
        }
        
        return response()->json($result);
    }

    /**
     * Get un solo archivo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Get(int $id)
    {
        return response()->json(File::find($id));
    }


    /**
     * GET Archivo real stream
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function File(int $id)
    {
        $file = File::find($id);
        $file_path = storage_path('app/archivos/'.$file->file);
        return response()->download($file_path);
    }


    /**
     * GET Preview real stream
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Preview(int $id)
    {
        $file = File::find($id);
        $file_path = storage_path('app/previews/'.$file->file);
        return response()->download($file_path);
    }

    /**
     * delete borrar archivo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Delete(int $id)
    {
        try
        {
            $file = File::find($id);
            $name = $file->name;
            $file->delete();
            return response()->json(['filename' => $name]);
        }
        catch(\Exception $ex)
        {
            return response()->json(['error' => 'Error al eliminar', 'message' => 'Ocurrio un error inesperado: '.$ex.getMessage()],500);
        }
    }

    /**
     * Post subir archivo.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function Store(Request $request)
    {
        try
        {
            $request->validate([
                'file' => 'required|max:20048',
            ]);
            
            $fileName = uniqid().'.'.$request->file->extension();  
             
            $request->file->storeAs('archivos', $fileName);
            
            $archivo = new File;
            $archivo->file = htmlspecialchars($fileName);
            $archivo->extension = $request->file->extension();
            $archivo->mime= $request->file->getMimeType();
            $archivo->name = htmlspecialchars($request->file->getClientOriginalName());
            $archivo->user_id = auth()->user()->id;
            $archivo->save();
            
            if(strpos($archivo->mime,"image") !== false)
            {
                $img = Image::make(storage_path('app/archivos/'.$fileName));
                $img->resize(64, 64);
                $img->save(storage_path('app/previews/'.$fileName));
            }
            
            return response()->json(['message'=>'Subido!','file'=>$archivo]);
        }
        catch (\Exception $ex)
        {
            return response()->json(['error'=>'Error al subir el archivo','message'=> 'Ocurrio un error al subir el archivo','inner' => $ex->getMessage()],500);
        }
    }

    
}
