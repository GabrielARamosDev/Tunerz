<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'boost_pressure' => $this->boost_pressure,
            'expected_power' => $this->expected_power,
            'status' => $this->status,
            'requirements' => $this->requirements->pluck('description'),
            'warnings' => $this->warnings->pluck('message'),
        ];
    }
}
