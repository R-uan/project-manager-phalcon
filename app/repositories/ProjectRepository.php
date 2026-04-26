<?php
namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\IProjectRepository;

class ProjectRepository implements IProjectRepository {
  public function __construct(
    private \Phalcon\Mvc\Model\Manager $modelsManager
  ) {}

  public function findProject(int $projectId): ?Project {
    return Project::findFirst([
      'conditions' => 'id = :id:',
      'bind'       => ['id' => $projectId],
    ]);
  }

  /** @return Project[] */
  public function findProjects(int $orgId): array {
    $projects = $this->modelsManager->createQuery('
      SELECT *
      FROM App\Models\Projects
      WHERE organizationId = :orgId:
    ')->execute(['orgId' => $orgId]);
    return iterator_to_array($projects);
  }
}