<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "first_name",
        "second_name",
        "first_lastname",
        "second_lastname",
        "document_id",
        "identification_number",
        "birth_date",
        "address",
        "telephone_number",
    ];

    function documentType()
    {
        return $this->hasOne(DocumentType::class, 'id', 'document_id');
    }
}
