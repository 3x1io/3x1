<?php

namespace Brackets\Media\Test\Feature;

use Brackets\Media\Test\TestCase;
use Illuminate\Http\UploadedFile;

class FileUploaderTest extends TestCase
{

    /** @test */
    public function a_user_can_upload_file()
    {
        $this->disableAuthorization();
        $data = [
            'name'      => 'test',
            'path'      => $this->getTestFilesDirectory('test.psd'),
        ];
        $file = new UploadedFile($data['path'], $data['name'], 'image/jpeg', null, true);
        $response = $this->call('POST', 'upload', $data, [], ['file' => $file], [], []);

        $response->assertStatus(200);
        $response->assertSee('psd');
    }

//    /** @test */
    public function unauthorized_user_cannot_upload_file()
    {
//        TODO
        return true;
    }
}
