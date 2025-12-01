<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'description','company_name','admin_reply'];

    protected $table = 'product_translations';

    public $timestamps = false;


}
