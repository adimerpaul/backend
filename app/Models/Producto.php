<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    //tabla con la que va a trabajar el modelo producto
    protected $table = "productos";
    
    //si su clave primaria es distinta que id, entonces se define el campo primaryKey
    //protected $primaryKey = "codigo";

    //campos de la tabla productos, con la que se va a trabajar
    protected $fillable = [
        "codigo",
        "nombre",
        "descripcion",
        "precio",
        "url_imagen",
        "like",
        "dislike",
        "user_id"
    ];

    protected $hidden = ['created_at', 'updated_at'];

    //relacion con la tabla users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
