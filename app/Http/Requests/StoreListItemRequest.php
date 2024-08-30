<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListItemRequest extends FormRequest
{
    public function rules()
    {
        return [
            'content' => ['required', 'max:1000'],
        ];
    }
}
