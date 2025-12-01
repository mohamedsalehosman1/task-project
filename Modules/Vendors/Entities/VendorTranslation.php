<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VendorTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description','nationality'];

    protected $table = 'vendor_translations';

    public $timestamps = false;


}
