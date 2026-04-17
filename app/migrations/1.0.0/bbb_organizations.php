<?php

use Phalcon\Db\Exception;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class OrganizationsMigration_100
 */
class BbbOrganizationsMigration_100 extends Migration {
  /**
   * Define the table structure
   *
   * @return void
   * @throws Exception
   */
  public function morph(): void {
    /* $this->morphTable('organizations', [
      'columns' => [
        new Column('id', [
          'type'          => Column::TYPE_INTEGER,
          'primary'       => true,
          'autoIncrement' => true,
          'notNull'       => true,
        ]),
        new Column('name', [
          'type'    => Column::TYPE_VARCHAR,
          'size'    => 255,
          'notNull' => true,
        ]),
        new Column('created_at', [
          'type' => Column::TYPE_TIMESTAMPTZ,
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
        organizations (
            id INTEGER GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
            name VARCHAR(50) NOT NULL,
            created_at TIMESTAMPTZ
        )
    ");
  }

  /**
   * Reverse the migrations
   *
   * @return void
   */
  public function down(): void {
    $this->connection->dropTable('organizations');
  }
}
