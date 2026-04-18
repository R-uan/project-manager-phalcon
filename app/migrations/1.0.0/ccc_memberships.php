<?php

use Phalcon\Db\Exception;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class MembershipsMigration_100
 */
class CccMembershipsMigration_100 extends Migration {
  /**
   * Define the table structure
   *
   * @return void
   * @throws Exception
   */
  public function morph(): void {
    /* $this->morphTable('memberships', [
      'columns' => [
        new Column('id', [
          'type'          => Column::TYPE_INTEGER,
          'primary'       => true,
          'autoIncrement' => true,
          'notNull'       => true,
        ]),
        new Column('role', [
          'type'    => Column::TYPE_VARCHAR,
          'size'    => 20,
          'notNull' => true,
        ]),
        new Column('user_id', [
          'type'    => Column::TYPE_INTEGER,
          'notNull' => true,
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
        memberships (
            id SERIAL PRIMARY KEY,
            role VARCHAR(20) NOT NULL,
            user_id INT NOT NULL,
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
    $this->connection->execute('ALTER TABLE memberships DROP CONSTRAINT fk_membership_user');
    $this->connection->execute('ALTER TABLE memberships DROP CONSTRAINT fk_membership_org');
    $this->connection->dropTable("organizations");
  }
}
