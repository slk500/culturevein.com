<?php

declare(strict_types=1);

namespace Controller;

use Container;
use Controller\Base\BaseController;
use Model\User;
use Repository\UserRepository;

class UserController extends BaseController
{
    private UserRepository $user_repository;

    public function __construct()
    {
        $container = new Container();
        $this->user_repository = $container->get(UserRepository::class);
    }

    public function create(\stdClass $data)
    {
        foreach (['username', 'email', 'password'] as $field){
            if(!property_exists($data, $field)) {
                return $this->response_bad_request("You have to provide $field");
            }
        }

        if(!filter_var($data->email, FILTER_VALIDATE_EMAIL)){
            return $this->response_bad_request('Not a valid email!');
        };

        if($this->user_repository->find($data->email)){
            return $this->response_bad_request('User with provided email address already exist!');
        };

        $password_encrypted = password_hash($data->password, PASSWORD_BCRYPT);

        $user = new User(
            $data->email,
            $password_encrypted,
            $data->username
        );

        $user_id = $this->user_repository->save($user);
        $token = $this->create_token($user_id);

        return ['token' => $token];
    }

    public function login(\stdClass $data)
    {
        if(!property_exists($data, 'email') ||
            !property_exists($data, 'password')){
            return $this->response_unauthorized('Wrong credentials');
        }

        $user = $this->user_repository->find($data->email);

        if(!$user) {
            return $this->response_unauthorized('Wrong credentials');
        }

        if (!password_verify($data->password, $user->password)) {
            return $this->response_unauthorized('Password Mismatch');
        }

        $token = $this->create_token($user->user_id);

        return ['token' => $token];
    }
}