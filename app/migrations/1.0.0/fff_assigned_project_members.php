<?php

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
  public function morph(): void {}

  /**
   * Run the migrations
   *
   * @return void
   */
  public function up(): void {
    $this->getConnection()->execute("
      CREATE TABLE
        assigned_project_members (
            id SERIAL PRIMARY KEY,
            project_id INT NOT NULL,
            membership_id INT NOT NULL
        )
    ");
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
