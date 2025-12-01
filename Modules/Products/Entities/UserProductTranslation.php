<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserProductTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'description' , 'company_name','admin_reply','user_service_name'];

    protected $table = 'user_product_translations';

    public $timestamps = false;


}
