<?php

declare(strict_types=1);


namespace Service;


use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Symfony\Component\Dotenv\Dotenv;
use UnexpectedValueException;

final class TokenService
{
    /**
     * @var string
     */
    private $token_secret;

    public function __construct()
    {
        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../../.env');

        $this->token_secret = getenv('TOKEN_SECRET');
    }
    
    public function create_token(int $user_id): string
    {
        $week_in_seconds = 604800;

        $payload = [
            "user_id" => $user_id,
            "exp" => time() + $week_in_seconds
        ];

        try{
            $jwt = JWT::encode($payload, $this->token_secret);
        }catch (UnexpectedValueException $e) {
            throw new \Exception($e->getMessage());
        }
        
        return (string) $jwt;
    }

    public function decode_user_id(string $token): ?int
    {
        try{
            $decoded = JWT::decode($token, $this->token_secret, array('HS256'));
        }catch (UnexpectedValueException $e) {
          if($e instanceof ExpiredException){
              throw new \Exception('Token expired!');
          }

            return null;
        }

        return $decoded->user_id;
    }
}