<?php

declare(strict_types=1);

namespace Controller\Base;

//todo remove
abstract class BaseController
{
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
        $bearer_token = getallheaders()['Authorization'] ?? null;
        if ($bearer_token) {
            if (preg_match('\'Bearer\s[\d|a-f]{8}-([\d|a-f]{4}-){3}[\d|a-f]{12}\'', $bearer_token, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
}