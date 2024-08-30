<?php

declare(strict_types=1);

namespace App\Models;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToDoList extends Model
{
    use HasFactory;
    use SoftDeletes;
    use GeneratesUuid;
    use BindsOnUuid;

    protected $fillable = [];

    public function uuidColumn(): string
    {
        return 'guid';
    }

    public function listItems(): HasMany
    {
        return $this->hasMany(ListItem::class, 'list_id', 'id');
    }
}
