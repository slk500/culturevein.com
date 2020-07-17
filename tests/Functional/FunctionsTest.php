<?php

namespace Tests\Functional;

use PHPUnit\Framework\TestCase;

class FunctionsTest extends TestCase
{
    /**
     * @test
     */
    public function find_token()
    {
        $output = find_token('Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxLCJleHAiOjE1OTU1OTgyNjR9.y0SaR_eM0efodzUUrJR0PV9k19LCuvp0_VH1wj8UPzg');

        $this->assertNotNull($output);
    }
}
