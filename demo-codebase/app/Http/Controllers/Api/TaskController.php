<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use InvalidArgumentException;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService,
    ) {}

    public function index(Request $request): JsonResponse
    {
        try {
            $tasks = $this->taskService->getByOwner(
                (int) $request->query('owner_id'),
                $request->query('priority'),
            );

            return TaskResource::collection($tasks)->response();
        } catch (InvalidArgumentException $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function show(int $id): JsonResponse
    {
        $task = $this->taskService->getById($id);

        return $task === null
            ? response()->json(null, 404)
            : response()->json(TaskResource::make($task));
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $created = $this->taskService->create($request->validated());

            return response()->json(TaskResource::make($created), 201);
        } catch (InvalidArgumentException $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function update(int $id, UpdateTaskRequest $request): JsonResponse
    {
        try {
            $updated = $this->taskService->update($id, $request->validated());

            return $updated === null
                ? response()->json(null, 404)
                : response()->json(TaskResource::make($updated));
        } catch (InvalidArgumentException $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    // NOTE FOR DEMO: Delete endpoint is missing.
    // Good PRD-driven demo: give delegates a user story and ask them to add it.
}
