<?php
namespace App\Models;

use App\Dto\Request\CreateUserRequestDto;
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
  public $website;    // string

  public static function fromRequest(CreateUserRequestDto $request) {
    $user             = new User();
    $user->email      = $request->email;
    $user->first_name = $request->first_name;
    $user->last_name  = $request->last_name;
    $user->password   = $request->password;
    return $user;
  }

  public function initialize() {
    $this->setSchema('public');
    $this->setSource("users");
    $this->skipAttributesOnCreate(['id']);

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