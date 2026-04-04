<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class AssignedTaskMembersMigration_100
 */
class GggAssignedTaskMembersMigration_100 extends Migration {
  /**
   * Define the table structure
   *
   * @return void
   * @throws Exception
   */
  public function morph(): void {
    $this->morphTable('assigned_task_members', [
      'columns' => [
        new Column('id', [
          'type'          => Column::TYPE_INTEGER,
          'autoIncrement' => true,
          'primary'       => true,
          'notNull'       => true,
        ]),
        new Column('task_id', [
          'type'    => Column::TYPE_INTEGER,
          'notNull' => true,
        ]),
        new Column('assigned_member_id', [
          'type'    => Column::TYPE_INTEGER,
          'notNull' => true,
        ]),
      ],
      /* 'references' => [
        new Reference('fk_assigned_task_members_project_tasks', [
          'referencedTable'   => 'tasks',
          'columns'           => ['task_id'],
          'referencedColumns' => ['id'],
          'onDelete'          => 'CASCADE',
        ]),
        new Reference('fk_assigned_task_members_assigned_member', [
          'referencedTable'   => 'assigned_project_members',
          'columns'           => ['assigned_member_id'],
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
    $this->connection->execute('ALTER TABLE assigned_task_members DROP CONSTRAINT fk_assigned_task_members_tasks');
    $this->connection->execute('ALTER TABLE assigned_task_members DROP CONSTRAINT fk_assigned_task_members_assigned_member');
    $this->connection->dropTable("assigned_task_members");
  }
}
