<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolQuickFactsFeatureResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? null,
            'school_quick_fact_id' => $this->school_quick_fact_id ?? null,
            'value' => $this->value ?? null,
            'type' => $this->type ?? null,
            'is_featured' => $this->is_featured ?? null,
            'sorting_order' => $this->sorting_order ?? null,
        ];
    }
}
