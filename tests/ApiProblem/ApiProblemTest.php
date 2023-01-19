<?php

namespace Tests\ApiProblem;

use ApiProblem\ApiProblem;
use PHPUnit\Framework\TestCase;

class ApiProblemTest extends TestCase
{
    /**
     * @test
     */
    public function creation()
    {
        $apiProblem = new ApiProblem(ApiProblem::WRONG_CREDENTIALS);
        $this->assertSame($apiProblem->getMessage(), ApiProblem::WRONG_CREDENTIALS[0]);
    }
}
