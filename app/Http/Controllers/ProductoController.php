<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Http\Requests\CreateProductoRequest;
use App\Http\Requests\UpdateProductoRequest;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // listar y buscar dentro de una tabla: Producto
    public function index(Request $request)
    {

        //select * from producto inne join users on ......     (ORM, Laravel...ELOQUENT)
        //$productos = Producto::with(['user:id,email,name'])->paginate(10);

        //select * from producto where nombre like '%par%' or ......
        $productos = Producto::with(['user:id,email,name'])
                                ->whereCodigo($request->txtBuscar)
                                ->orWhere('nombre', 'like', "%{$request->txtBuscar}%")->get();
//                                ->paginate(9);

//        return \response()->json($productos, 200);
        return $productos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //insertar nuevos regisros
    public function store(CreateProductoRequest $request)
    {
        //insert into productos values (...........$request)
        $input = $request->all();
        $input['user_id'] = 1; //auth()->user()->id;
        $producto = Producto::create($input);

        return \response()->json(['res' => true, 'message'=>'insertado correctamente'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //recoger un solo registro de la bdd
    public function show($id)
    {
        //select * from producto where id = $id
        $producto = Producto::with(['user:id,email,name'])->findOrFail($id);
        return \response()->json($producto, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //para modificar registros
    public function update(UpdateProductoRequest $request, $id)
    {
        //update productos set nombre = $request......... where id = $id
        $input = $request->all();
        $producto = Producto::find($id);
        $producto->update($input);

        return \response()->json(['res' => true, 'message'=>'modificado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //elimirar registros
    public function destroy($id)
    {
        try{
            //delete from producto where id = $id
            Producto::destroy($id);
            return \response()->json(['res' => true, 'message'=>'eliminado correctamente'], 200);
        }
        catch(\Exception $e){
            return \response()->json(['res' => false, 'message'=>$e->getMessage()], 200);
        }
    }

    //incrementar likes de productos
    public function setLike($id){
        $producto = Producto::find($id);
        $producto->like = $producto->like + 1;
        $producto->save();

        return \response()->json(['res' => true, 'message'=>'mas un like'], 200);
    }

    public function setDislike($id){
        $producto = Producto::find($id);
        $producto->dislike = $producto->dislike + 1;
        $producto->save();

        return \response()->json(['res' => true, 'message'=>'mas like menos'], 200);
    }

    public function setImagen(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $producto->url_imagen = $this->cargarImagen($request->imagen, $id);
        $producto->save();

        return \response()->json(['res' => true, 'message'=>'imagen cargada corretamente'], 200);
    }

    private function cargarImagen($file, $id)
    {
        // nombeArchivo = 7897877987_55.png
        $nombreArchivo = time() . "_{$id}." . $file->getClientOriginalExtension();
        $file->move(\public_path('imagenes'), $nombreArchivo);
        return $nombreArchivo;
    }
}
