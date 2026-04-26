<?php
namespace App\Repositories\Interfaces;

use App\Models\Project;

interface IProjectRepository {
  public function findProjects(int $orgId);
  public function findProject(int $projectId): ?Project;
}