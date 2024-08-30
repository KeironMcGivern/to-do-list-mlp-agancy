<?php

declare(strict_types=1);

namespace App\Models\Concerns\ListItem;

trait HasModelActions
{
    public function markedAsComplete(): void
    {
        $this->completed = true;

        $this->save();
    }
}
