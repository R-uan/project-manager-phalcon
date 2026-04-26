<?php

use App\Models\Project;
use App\Repositories\Interfaces\IProjectRepository;
use App\Services\Interfaces\IMembershipService;
use App\Services\Interfaces\IUserService;

class ProjectService implements IProjectService {
  public function __construct(
    private IUserService $userService,
    private IProjectRepository $projectRepository,
    private IMembershipService $membershipService,
  ) {}

  // Project is always hidden for people not in the organization
  //
  public function findProject(int $userId, int $projectId): ?Project {
    $project = $this->projectRepository->findProject($projectId);
    // project not found
    if (isset($project) === false) {throw new \Exception("Project not found");}
    $membership = $this->membershipService->findUserOrgMembership($project->orgId, $userId);
    // not member
    if (isset($membership) === false) {throw new \Exception("Unautorized");}
    return $project;
  }
}