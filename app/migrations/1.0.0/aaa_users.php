<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
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
    $this->morphTable('users', [
      'columns' => [
        new Column(
          'id',
          [
            'type'          => Column::TYPE_INTEGER,
            'primary'       => true,
            'notNull'       => true,
            'autoIncrement' => true,
            'first'         => true,
          ]
        ),
        new Column(
          'email',
          [
            'type'    => Column::TYPE_VARCHAR,
            'notNull' => true,
            'size'    => 255,
            'after'   => 'id',
          ]
        ),
        new Column(
          'password',
          [
            'type'    => Column::TYPE_VARCHAR,
            'notNull' => true,
            'size'    => 255,
            'after'   => 'email',
          ]
        ),
        new Column(
          'first_name',
          [
            'type'    => Column::TYPE_VARCHAR,
            'notNull' => false,
            'size'    => 100,
            'after'   => 'password',
          ]
        ),
        new Column(
          'last_name',
          [
            'type'    => Column::TYPE_VARCHAR,
            'notNull' => false,
            'size'    => 100,
            'after'   => 'first_name',
          ]
        ),
        new Column(
          'created_at',
          [
            'type'    => Column::TYPE_TIMESTAMP,
            'default' => "CURRENT_TIMESTAMP",
            'notNull' => true,
            'after'   => 'last_name',
          ]
        ),
      ],
      'indexes' => [
        new Index('users_unique_email', ['email'], 'UNIQUE'),
      ],
    ]);
  }

  /**
   * Run the migrations
   *
   * @return void
   */
  public function up(): void {
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
