<?php

namespace Whitegfx\LaravelValidation\Tests;

use Illuminate\Validation\Validator;
use LaravelValidation;

class LaravelValidationTest extends TestCase
{
    /**
     * Check that the multiply method returns correct result
     * @return void
     */
    public function testLaravelValidationDisposableEmail()
    {
        $rules = [
            'field1' => 'disposable_email'
        ];

        $data = [
            'field1' => "example@mailinator.com",
        ];

        $v = $this->app['validator']->make($data, $rules);
        $this->assertFalse($v->passes());

        $data = [
            'field1' => "example@guerrillamail.com",
        ];

        $v = $this->app['validator']->make($data, $rules);
        $this->assertFalse($v->passes());

        $data = [
            'field1' => "example@example.com",
        ];

        $v = $this->app['validator']->make($data, $rules);
        $this->assertTrue($v->passes());

        $data = [
            'field1' => "example@google.com",
        ];

        $v = $this->app['validator']->make($data, $rules);
        $this->assertTrue($v->passes());
    }
}
