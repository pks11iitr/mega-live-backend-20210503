<?php

namespace App\Models;

use App\Models\Traits\DocumentUploadTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use DocumentUploadTrait;
    protected $table='documents';

    protected $fillable=['entity_type','entity_id', 'file_path','file_type'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

    public function entity(){
        $this->morphTo();
    }

    public function getFilePathAttribute($value){
        if($value)
            return Storage::url($value);
        return '';
    }

}
