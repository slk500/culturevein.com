<?php

declare(strict_types=1);

namespace Controller\Base;

//todo remove
use Service\TokenService;

abstract class BaseController
{
    public ?int $user_id = null;

    protected function response_not_found($data = null): ?string
    {
        http_response_code(404);
        if ($data) {
            return json_encode(['errors' => $data]);
        }
        die();
    }

    protected function response_bad_request($data = null): string
    {
        http_response_code(400);
        if ($data) {
            return json_encode($data);
        }
        die();
    }

    protected function response_unauthorized($data = null): string
    {
        http_response_code(401);
        if ($data) {
            return json_encode($data);
        }
        die();
    }

    function get_bearer_token(): ?string
    {
        $bearer_token = $this->getallheaders()['Authorization'] ?? null;
        if ($bearer_token) {
            if (preg_match('\'Bearer\s[\d|a-f]{8}-([\d|a-f]{4}-){3}[\d|a-f]{12}\'', $bearer_token, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    public function authentication(): void
    {
        $token = $this->get_bearer_token();
        $this->user_id = $token ? (new TokenService())->decode_user_id($token) : null;
    }

    public function create_token(int $user_id)
    {
        return (new TokenService())->create_token($user_id);
    }

    //function exist only in apache not nginx
    function getallheaders()
    {
        $headers = array ();
        foreach ($_SERVER as $name => $value)
        {
            if (substr($name, 0, 5) == 'HTTP_')
            {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}