<?php

use Phalcon\Db\Exception;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class ProjectsMigration_100
 */
class DddProjectsMigration_100 extends Migration {
  /**
   * Define the table structure
   *
   * @return void
   * @throws Exception
   */
  public function morph(): void {
    /* $this->morphTable('projects', [
      'columns' => [
        new Column('id', [
          'type'          => Column::TYPE_INTEGER,
          'primary'       => true,
          'autoIncrement' => true,
          'notNull'       => true,
        ]),
        new Column('name', [
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
        new Column('organization_id', [
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
        projects (
            id SERIAL PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            description VARCHAR(500),
            deadline TIMESTAMPTZ,
            startline TIMESTAMPTZ,
            created_at TIMESTAMPTZ,
            updated_at TIMESTAMPTZ,
            organization_id INT NOT NULL
        )
    ");
  }

  /**
   * Reverse the migrations
   *
   * @return void
   */
  public function down(): void {
    $this->connection->execute('ALTER TABLE projects DROP CONSTRAINT fk_projects_organizations');
    $this->connection->dropTable('projects');
  }
}
