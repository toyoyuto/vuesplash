<?php

namespace Tests\Feature;

use App\Photo;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Log;

class PhotoSubmitApiTest extends TestCase
{
    use RefreshDatabase;

    public function setUp():void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
    }

    /**
     * @test
     */
    public function should_ファイルをアップロードできる()
    {
        // S3ではなくテスト用のストレージを使用する
        // → storage/framework/testing
        Storage::fake('s3');
        
        $response = $this->actingAs($this->user)
            ->json('POST', route('photo.create'), [
                // ダミーファイルを作成して送信している
                'photo' => UploadedFile::fake()->image('photo.jpg'),
            ]);
        // レスポンスが201(CREATED)であること
        $response->assertStatus(201);

        $photo = Photo::first();

        // 写真のIDが12桁のランダムな文字列であること
        $this->assertRegExp('/^[0-9a-zA-Z-_]{12}$/', $photo->id);

        // DBに挿入されたファイル名のファイルがストレージに保存されていること
        Storage::disk('s3')->assertExists($photo->filename);
    }

    /**
     * @test
     */
    // public function should_データベースエラーの場合はファイルを保存しない()
    // {
    //     // 乱暴だがこれでDBエラーを起こす
    //     Log::info('eeeeeeeeeeee');
    //     Schema::drop('photos');
    //     Log::info('e1');
    //     $dis = Storage::fake('s3');
    //     Log::info('e2');
    //     $response = $this->actingAs($this->user)
    //         ->json('POST', route('photo.create'), [
    //             'photo' => UploadedFile::fake()->image('photo.jpg'),
    //         ]);
    //         Log::info('e3');
    //     // レスポンスが500(INTERNAL SERVER ERROR)であること
    //     $response->assertStatus(500);
    //     Log::info('e0');
    //     // ストレージにファイルが保存されていないこと
    //     $count = count($dis->files());
    //     $this->assertEquals(0, $count);
    // }

    // /**
    //  * @test
    //  */
    public function should_ファイル保存エラーの場合はDBへの挿入はしない()
    {
        // ストレージをモックして保存時にエラーを起こさせる
        Storage::shouldReceive('disk')
            ->with('s3')
            ->once()
            ->andReturnNull();

        $response = $this->actingAs($this->user)
            ->json('POST', route('photo.create'), [
                'photo' => UploadedFile::fake()->image('photo.jpg'),
            ]);

        // レスポンスが500(INTERNAL SERVER ERROR)であること
        $response->assertStatus(500);

        // データベースに何も挿入されていないこと
        $this->assertEmpty(Photo::all());
    }
}