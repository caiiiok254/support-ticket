<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Category extends Model
{
    use Sortable;

    protected $fillable = ['name'];

    public $sortable = ['category'];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
