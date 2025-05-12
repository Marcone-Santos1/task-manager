<?php

namespace App\Http\Resources;

use App\Core\Application\DTOs\TaskDto;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function __construct(TaskDto $dto)
    {
        parent::__construct($dto);
    }

    public function toArray($request): array
    {
        /** @var TaskDto $dto */
        $dto = $this->resource;

        return [
            'id' => $dto->id,
            'title' => $dto->title,
            'description' => $dto->description,
            'due_date' => $dto->dueDate,
            'completed' => $dto->completed,
            'created_at' => $this->when(false, null),
            'updated_at' => $this->when(false, null),
        ];
    }
}
