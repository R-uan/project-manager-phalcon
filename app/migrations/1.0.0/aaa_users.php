<?php

use Phalcon\Db\Exception;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class UsersMigration_100
 */
class AaaUsersMigration_100 extends Migration {
  /**
   * Define the table structure
   *
   * @return void
   * @throws Exception
   */
  public function morph(): void {
    /* $this->morphTable('users', [
      'columns' => [
        new Column(
          'id',
          [
            'type'     => Column::TYPE_INTEGER,
            'primary'  => true,
            'notNull'  => true,
            'identity' => true,
          ]
        ),
        new Column(
          'email',
          [
            'type'    => Column::TYPE_VARCHAR,
            'notNull' => true,
            'size'    => 255,
          ]
        ),
        new Column(
          'password',
          [
            'type'    => Column::TYPE_VARCHAR,
            'notNull' => true,
            'size'    => 255,
          ]
        ),
        new Column(
          'first_name',
          [
            'type'    => Column::TYPE_VARCHAR,
            'notNull' => false,
            'size'    => 100,
          ]
        ),
        new Column(
          'last_name',
          [
            'type'    => Column::TYPE_VARCHAR,
            'notNull' => false,
            'size'    => 100,
          ]
        ),
        new Column(
          'created_at',
          [
            'type'    => Column::TYPE_TIMESTAMP,
            'default' => "CURRENT_TIMESTAMP",
            'notNull' => true,
          ]
        ),
      ],
      'indexes' => [
        new Index('users_unique_email', ['email'], 'UNIQUE'),
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
      users (
          id SERIAL PRIMARY KEY,
          email VARCHAR(255) NOT NULL UNIQUE,
          password VARCHAR(255) NOT NULL,
          first_name VARCHAR(50) NOT NULL,
          last_name VARCHAR(50),
          created_at TIMESTAMPTZ,
          location VARCHAR(20),
          last_login TIMESTAMPTZ,
          website VARCHAR(50)
      )
    ");
  }

  /**
   * Reverse the migrations
   *
   * @return void
   */
  public function down(): void {
    $this->connection->dropTable('users');
  }
}
