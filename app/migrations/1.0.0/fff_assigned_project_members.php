<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class AssignedProjectMembersMigration_100
 */
class FffAssignedProjectMembersMigration_100 extends Migration {
  /**
   * Define the table structure
   *
   * @return void
   * @throws Exception
   */
  public function morph(): void {
    $this->morphTable('assigned_project_members', [
      'columns' => [
        new Column('id', [
          'type'          => Column::TYPE_INTEGER,
          'autoIncrement' => true,
          'primary'       => true,
          'notNull'       => true,
        ]),
        new Column('project_id', [
          'type'    => Column::TYPE_INTEGER,
          'notNull' => true,
        ]),
        new Column('membership_id', [
          'type'    => Column::TYPE_INTEGER,
          'notNull' => true,
        ]),
      ],
      /* 'references' => [
        new Reference('fk_assigned_project_members_memberships', [
          'referencedTable'   => 'memberships',
          'columns'           => ['membership_id'],
          'referencedColumns' => ['id'],
          'onDelete'          => 'CASCADE',
        ]),
        new Reference('fk_assigned_project_members_projects', [
          'referencedTable'   => 'projects',
          'columns'           => ['project_id'],
          'referencedColumns' => ['id'],
          'onDelete'          => 'CASCADE',
        ]),
      ], */
    ]);
  }

  /**
   * Run the migrations
   *
   * @return void
   */
  public function up(): void {
  }

  /**
   * Reverse the migrations
   *
   * @return void
   */
  public function down(): void {
    $this->connection->execute('ALTER TABLE assigned_project_members DROP CONSTRAINT fk_assigned_project_members_memberships');
    $this->connection->execute('ALTER TABLE assigned_project_members DROP CONSTRAINT fk_assigned_project_members_projects');
    $this->connection->dropTable("assigned_project_members");
  }
}
