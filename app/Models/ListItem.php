<?php

declare(strict_types=1);

namespace App\Models;

use Dyrynda\Database\Support\BindsOnUuid;
use Dyrynda\Database\Support\GeneratesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListItem extends Model
{
    use Concerns\ListItem\HasModelActions;
    use HasFactory;
    use SoftDeletes;
    use GeneratesUuid;
    use BindsOnUuid;

    protected $casts = [
        'completed' => 'boolean',
    ];

    protected $fillable = [
        'content',
        'completed',
        'list_id',
    ];

    public function uuidColumn(): string
    {
        return 'guid';
    }

    public function list(): HasOne
    {
        return $this->hasOne(ToDoList::class, 'id', 'list_id');
    }
}
