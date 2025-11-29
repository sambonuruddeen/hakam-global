<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vin' => $this->vin,
            'make' => $this->make,
            'model' => $this->model,
            'year' => $this->year,
            'value' => $this->value,
            'currency' => $this->currency,
            'color' => $this->color,
            'mileage' => $this->mileage,
            'engine_type' => $this->engine_type,
            'fuel_type' => $this->fuel_type,
            'transmission' => $this->transmission,
            'body_style' => $this->body_style,
            'drive_train' => $this->drive_train,
            'condition' => $this->condition,
            'location' => $this->location,
            'options' => $this->options,
            'status' => $this->status,
            'additional_notes' => $this->additional_notes,
            'added_by' => $this->added_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
