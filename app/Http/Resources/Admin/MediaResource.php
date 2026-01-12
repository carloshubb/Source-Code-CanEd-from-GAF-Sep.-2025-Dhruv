<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'full_path' => asset($this->path),
            'type' => $this->type,
            'extension' => $this->extension,
        ];
    }
}
