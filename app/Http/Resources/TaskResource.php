<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'status'      => $this->status,
            'completed'   => $this->completed,
            'due_date'    => $this->due_date,
            'priority'    => $this->priority,
            'user'        => new UserResource($this->whenLoaded('user')),
            'created_at'  => $this->created_at->format('Y-m-d'),
        ];
    }
}
