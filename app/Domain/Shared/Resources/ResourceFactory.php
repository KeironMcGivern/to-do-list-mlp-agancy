<?php

declare(strict_types=1);

namespace App\Domain\Shared\Resources;

use App\Domain\ToDoList\Resources\ListItemResource;
use App\Domain\ToDoList\Resources\ToDoListResource;
use App\Models\ListItem;
use App\Models\ToDoList;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ResourceFactory
{
    protected $map = [
        ToDoList::class => ToDoListResource::class,
        ListItem::class => ListItemResource::class,
    ];

    protected $object = null;

    protected $resource = null;

    public function __construct($object, ?string $resource = null)
    {
        $this->object = $object;
        $this->resource = $resource;
    }

    protected function getResourceClass($instance): string
    {
        $resource = $this->resource ?: Arr::get($this->map, $className = $instance::class);

        throw_unless($resource, Exception::class, "A resource was not set for [{$className}]");

        return $resource;
    }

    protected function resolvePaginator()
    {
        $first = $this->object->getCollection()->first();

        return new PaginatedCollection(
            $this->object,
            $first ? $this->getResourceClass($first) : null
        );
    }

    protected function resolveCollection()
    {
        if ($this->object->count() === 0) {
            return optional();
        }

        $resource = $this->getResourceClass($this->object->first());

        return $resource::collection($this->object);
    }

    protected function resolveSingleResource()
    {
        $resource = $this->getResourceClass($this->object);

        return $resource::make($this->object);
    }

    public function resolve()
    {
        if (! $this->object || ! is_object($this->object)) {
            return optional();
        }

        if ($this->object instanceof LengthAwarePaginator) {
            return $this->resolvePaginator();
        }

        if ($this->object instanceof Collection) {
            return $this->resolveCollection();
        }

        return $this->resolveSingleResource();
    }

    public static function make($object, ?string $resource = null)
    {
        return (new self($object, $resource))->resolve();
    }
}
