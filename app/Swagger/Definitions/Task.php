<?php

namespace App\Swagger\Definitions;

/**
 * @OA\Schema(
 *     schema="Task",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="New Task"),
 *     @OA\Property(property="description", type="string", example="Details here"),
 *     @OA\Property(property="completed", type="string", example="Incomplete"),
 *     @OA\Property(property="due_date", type="string", format="date", example="2025-07-25"),
 *     @OA\Property(property="priority", type="string", example="High"),
 *     @OA\Property(property="status", type="string", example="Active"),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="category", type="string", example="Work"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-07-18T12:34:56Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-07-18T13:00:00Z")
 * )
 */
class Task
{
}
