<?php

use Phalcon\Db\Exception;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class ProjectTasksMigration_100
 */
class EeeTasksMigration_100 extends Migration {
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
        tasks (
            id SERIAL PRIMARY KEY,
            title VARCHAR(50) NOT NULL,
            description VARCHAR(500),
            created_at TIMESTAMPTZ,
            startline TIMESTAMPTZ,
            deadline TIMESTAMPTZ,
            project_id INT NOT NULL
        )
    ");
  }

  /**
   * Reverse the migrations
   *
   * @return void
   */
  public function down(): void {
    $this->connection->execute('ALTER TABLE projects DROP CONSTRAINT fk_tasks_projects');
    $this->connection->dropTable('projects');
  }
}
