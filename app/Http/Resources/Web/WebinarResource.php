<?php

namespace App\Http\Resources\Web;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class WebinarResource extends JsonResource
{
    public function toArray($request)
    {
        $carbonDateTime = Carbon::parse($this->start_date);
        $formattedDateTime = $carbonDateTime->format('Y-m-d h:m:s');
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start_date' => $formattedDateTime,
            'timezone' => $this->timezone,
            'image' => $this->image,
            'live_strom_webinar' => $this->live_strom_webinar,
        ];
    }
}
