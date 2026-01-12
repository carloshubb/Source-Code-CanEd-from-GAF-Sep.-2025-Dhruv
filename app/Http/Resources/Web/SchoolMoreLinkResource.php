<?php

namespace App\Http\Resources\Web;

use App\Http\Resources\Admin\DegreeResource;
use App\Http\Resources\Admin\ProgramResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolMoreLinkResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'link' => $this->link,
            'created_at' => date('m/d/Y H:i:s', strtotime($this->created_at)),
            'school_more_link_resource' => SchoolMoreLinkDetailResource::collection($this->schoolMoreLinkDetail),
        ];
    }
}
