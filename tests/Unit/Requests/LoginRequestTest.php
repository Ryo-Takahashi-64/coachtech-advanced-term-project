<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\Auth\LoginRequest;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @param array 項目名の配列
     * @param array 値の配列
     * @param 期待値
     *
     * @dataProvider dataprovider
     */
    public function test_request_test(array $keys, array $values, bool $expect)
    {
        $dataList = array_combine($keys, $values);
        $request = new LoginRequest();
        $rules = $request->rules();

        $validator = Validator::make($dataList, $rules);
        $result = $validator->passes();

        $this->assertEquals($expect, $result);
    }

    /**
     * @return データプロバイダ
     *
     * @dataProvider dataprovider
     */
    public function dataprovider()
    {
        return [
            'expect' => [
                ['email', 'password'],
                ['test@example', 'password'],
                true
            ],
            'required' => [
                ['email', 'password'],
                [null, 'password'],
                false
            ],
            'required' => [
                ['email', 'password'],
                ['', 'password'],
                false
            ],
            'email' => [
                ['email', 'password'],
                ['test', 'password'],
                false
            ],
            'required' => [
                ['email', 'password'],
                ['test@example', null],
                false
            ],
            'required' => [
                ['email', 'password'],
                ['test@example', ''],
                false
            ],
        ];
    }
}
