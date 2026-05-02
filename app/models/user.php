<?php
namespace App\Models;

use App\Dto\Request\CreateUserRequestDto;
use Phalcon\Mvc\Model;

class User extends Model {
  public $id;        // int
  public $email;     // string
  public $username;  // string
  public $password;  // string
  public $firstName; // string
  public $lastName;  // string
  public $createdAt; // date
  public $location;  // string
  public $lastLogin; // date
  public $website;   // string

  public function columnMap(): array {
    return [
      'id'         => 'id',
      'email'      => 'email',
      'password'   => 'password',
      'first_name' => 'firstName',
      'last_name'  => 'lastName',
      'created_at' => 'createdAt',
      'location'   => 'location',
      'last_login' => 'lastLogin',
      'website'    => 'website',
      'username'   => 'username',
    ];
  }

  public static function fromRequest(CreateUserRequestDto $request) {
    $user            = new User();
    $user->email     = $request->email;
    $user->username  = $request->username;
    $user->firstName = $request->first_name;
    $user->lastName  = $request->last_name;
    $user->password  = $request->password;
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