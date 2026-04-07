<?php
namespace App\Library;

use App\Models\User;
use Firebase\JWT\JWT;
use Phalcon\Config\Config;

class JwtService {
  private string $secret;
  private string $algorithm;
  private int $expiration;

  public function __construct(Config $config) {
    $this->secret     = $config->jwt->secret;
    $this->algorithm  = $config->jwt->algorithm;
    $this->expiration = $config->jwt->expiration;
  }

  public function encode(User $user): string {
    return JWT::encode([
      'user_id' => $user->id,
      'exp'     => time() + $this->expiration,
    ], $this->secret, $this->algorithm);
  }
}