<?php
namespace App\Models;

use Phalcon\Mvc\Model;

class User extends Model {
  public $id;         // int
  public $email;      // string
  public $password;   // string
  public $first_name; // string
  public $last_name;  // string
  public $created_at; // date
  public $location;   // string
  public $last_login; // date
  public $url;        // string

  public function initialize() {
    $this->setSchema('public');
    $this->setSource("users");

    $this->hasMany(
      'id',
      Membership::class,
      'user_id',
      [
        'alias'    => 'memberships',
        'reusable' => true,
      ]
    );

    $this->addBehavior(
      new \Phalcon\Mvc\Model\Behavior\Timestampable([
        'beforeCreate' => [
          'field'  => 'created_at',
          'format' => 'Y-m-d H:i:s',
        ],
      ])
    );

    $this->addBehavior(
      new \Phalcon\Mvc\Model\Behavior\Timestampable([
        'beforeCreate' => [
          'field'  => 'last_login',
          'format' => 'Y-m-d H:i:s',
        ],
      ])
    );
  }
}