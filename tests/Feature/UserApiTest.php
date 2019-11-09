<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Log;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    public function setUp():void
    {
        parent::setUp();
        Log::info($this->user);
        // テストユーザー作成
        $this->user = factory(User::class)->create();

        Log::info($this->user);
    }

    /**
     * @test
     */
    public function should_ログイン中のユーザーを返却する()
    {
        Log::info('ddddd');
        Log::info($this->user);
        $response = $this->actingAs($this->user)->json('GET', route('user'));

        $response
            ->assertStatus(200)
            ->assertJson([
                'name' => $this->user->name,
            ]);
    }

    /**
     * @test
     */
    public function should_ログインされていない場合は空文字を返却する()
    {
        $response = $this->json('GET', route('user'));

        $response->assertStatus(200);
        $this->assertEquals("", $response->content());
    }
}
