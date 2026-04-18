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
  public function morph(): void {
    /* $this->morphTable('tasks', [
      'columns' => [
        new Column('id', [
          'type'          => Column::TYPE_INTEGER,
          'primary'       => true,
          'autoIncrement' => true,
          'notNull'       => true,
        ]),
        new Column('title', [
          'type' => Column::TYPE_VARCHAR,
          'size' => 50,
        ]),
        new Column('description', [
          'type' => Column::TYPE_VARCHAR,
          'size' => 500,
        ]),
        new Column('created_at', [
          'type'    => Column::TYPE_TIMESTAMP,
          'default' => "CURRENT_TIMESTAMP",
          'notNull' => true,
        ]),
        new Column('startline', [
          'type' => Column::TYPE_TIMESTAMPTZ,
        ]),
        new Column('deadline', [
          'type' => Column::TYPE_TIMESTAMPTZ,
        ]),
        new Column('project_id', [
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
