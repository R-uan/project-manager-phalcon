<?php

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
    /* $this->morphTable('assigned_task_members', [
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
    ]); */
  }

  /**
   * Run the migrations
   *
   * @return void
   */
  public function up(): void {
    $this->getConnection()->execute("
      CREATE TABLE
        assigned_task_members (
            id SERIAL PRIMARY KEY,
            task_id INT NOT NULL,
            assigned_member_id INT NOT NULL
        )
    ");
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
