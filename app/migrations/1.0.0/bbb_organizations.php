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
  public function morph(): void {}

  /**
   * Run the migrations
   *
   * @return void
   */
  public function up(): void {
    $this->getConnection()->execute("
      CREATE TABLE
        organizations (
            id SERIAL PRIMARY KEY,
            handle VARCHAR(50) NOT NULL UNIQUE,
            display_name VARCHAR(255) NOT NULL,
            is_public BOOLEAN NOT NULL,
            location VARCHAR(20),
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
