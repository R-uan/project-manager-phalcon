<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Migrations\Mvc\Model\Migration;

class UsersMigration_104 extends Migration {
  public function morph(): void {
    $this->morphTable('users', [
      'columns' => [
        new Column('id', [
          'type'          => Column::TYPE_INTEGER,
          'notNull'       => true,
          'autoIncrement' => true,
          'primary'       => true,
        ]),
        new Column('email', [
          'type'    => Column::TYPE_VARCHAR,
          'size'    => 255,
          'notNull' => true,
        ]),
        new Column('password', [
          'type'    => Column::TYPE_VARCHAR,
          'size'    => 255,
          'notNull' => true,
        ]),
        new Column('first_name', [
          'type'    => Column::TYPE_VARCHAR,
          'size'    => 100,
          'notNull' => false,
        ]),
        new Column('last_name', [
          'type'    => Column::TYPE_VARCHAR,
          'size'    => 100,
          'notNull' => false,
        ]),
        new Column('created_at', [
          'type'    => Column::TYPE_TIMESTAMP,
          'notNull' => true,
          'default' => 'CURRENT_TIMESTAMP',
        ]),
      ],
      'indexes' => [
        new Index('users_unique_email', ['email'], 'UNIQUE'),
      ],
    ]);
  }

  public function up(): void {
    // Code here runs after morph() during 'run'
  }

  public function down(): void {
    // Code here runs during 'rollback'
  }
}