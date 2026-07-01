<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource['id'],
            'title' => $this->resource['title'],
            'description' => $this->resource['description'],
            'priority' => $this->resource['priority'],
            'status' => $this->resource['status'],
            'created_at' => $this->resource['created_at'],
            'completed_at' => $this->resource['completed_at'],
            'owner_id' => $this->resource['owner_id'],
        ];
    }
}
