<?php
namespace {{namespace}};

use Illuminate\Database\Eloquent\Model;

class {{table_name_ORM}} extends Model
{
    protected $table = '{{table_name}}';
    protected $primaryKey = '{{pks_column_name}}';
    public $timestamps = false;
    protected $guarded = [];
}
