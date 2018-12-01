<?php

declare(strict_types=1);

namespace Controller;


use Container;
use Controller\Base\BaseController;
use Model\User;
use Repository\UserRepository;
use Service\TokenService;

class UserController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $user_repository;

    /**
     * @var TokenService
     */
    private $token_service;

    public function __construct()
    {
        $container = new Container();
        $this->user_repository = $container->get(UserRepository::class);
        $this->token_service = new TokenService();
    }

    public function create()
    {
        $data = $this->get_body();

        if(!property_exists($data, 'username')) {
            $this->response_bad_request('You have to provide username!');
            die;
        }

        if(!property_exists($data, 'email')) {
            $this->response_bad_request('You have to provide email!');
            die;
        }

        if(!property_exists($data, 'password')) {
            $this->response_bad_request('You have to provide password!');
            die;
        }

        if(!filter_var($data->email, FILTER_VALIDATE_EMAIL)){
            $this->response_bad_request('Not a valid email!');
            die;
        };

        if($this->user_repository->find($data->email)){
            $this->response_bad_request('User with provided email address already exist!');
            die;
        };

        $password_encrypted = password_hash($data->password, PASSWORD_BCRYPT);

        $user = new User(
            $data->email,
            $password_encrypted,
            $data->username
        );

        $user_id = $this->user_repository->save($user);

        $token = $this->token_service->create_token($user_id);

        $this->response_created(['token' => $token]);
    }

    public function login()
    {
        $data = $this->get_body();

        if(!property_exists($data, 'email') ||
            !property_exists($data, 'password')){
            $this->response_unauthorized('Wrong credentials');die;
        }

        $user = $this->user_repository->find($data->email);

        if(!$user) {
            $this->response_unauthorized('Wrong credentials');die;
        }

        if (!password_verify($data->password, $user->password)) {
            $this->response_unauthorized('Password Mismatch');die;
        }

        $token = $this->token_service->create_token($user->user_id);

        $this->response(['token' => $token]);
    }
}