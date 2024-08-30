<?php

declare(strict_types=1);

namespace App\Domain\Shared\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginatedCollection extends ResourceCollection
{
    private ?string $resourceClass = null;

    public function __construct(LengthAwarePaginator $resource, ?string $resourceClass = null)
    {
        parent::__construct($resource);

        $this->resource = $this->collectResource($resource);
        $this->resourceClass = $resourceClass;
    }

    public function toArray($request)
    {
        return [
            'links' => $this->resource->links(),
            'total' => $this->resource->total(),
            'count' => $this->resource->count(),
            'current_page' => $this->resource->currentPage(),
            'last_page' => $this->resource->lastPage(),
            'data' => $this->resourceClass
                ? $this->resourceClass::collection($this->collection)->resolve()
                : [],
        ];
    }
}
