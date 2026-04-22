<?php

use Phalcon\Db\Exception;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class OrganizationContactsMigration_101
 */
class HhhOrganizationContactsMigration_100 extends Migration {
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
        organization_contacts (
          id SERIAL PRIMARY KEY,
          website VARCHAR(100),
          email VARCHAR(100),
          number VARCHAR(20),
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
  }
}
