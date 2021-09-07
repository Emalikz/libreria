<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Borrow;

class Book extends Model
{
    use HasFactory, SoftDeletes;
    //Las propiedades que se pueden guardar en masa (Con el metodo fill de un Model)
    protected $fillable = [
        "id",
        "title",
        "author",
        "isbn_code",
        "number_pages"
    ];
    /* Retorna todas las veces que fue prestado el libro */
    public function borrows()
    {
        return $this->hasMany(Borrow::class, 'book_id', 'id');
    }

    /* Condición de si está prestado */
    function scopeWhereIsBorrowed($query)
    {
        return $query->where("is_borrowed", true);
    }
    function scopeWhereIsNotBorrowed($query)
    {
        return $query->where("is_borrowed", false);
    }
}
