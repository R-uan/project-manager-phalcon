<?php

use App\Dto\Request\CreateProjectRequestDto;
use App\Models\Project;

interface IProjectService {
  public function findProjects(int $userId, int $orgId): array;
  public function deleteProject(int $userId, int $projectId): bool;
  public function findProject(int $userId, int $projectId): ?Project;
  public function createProject(int $userId, CreateProjectRequestDto $request);
}