<?php
namespace App\Dto\Request;

class CreateProjectRequestDto {
  public $organizationId;
  public $projectName;
  public $isPublic;
  public $startline;
  public $endline;
  public $description;
}