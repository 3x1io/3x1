<?php

namespace Brackets\Media\Test\Feature;

use Brackets\Media\Exceptions\FileCannotBeAdded\FileIsTooBig;
use Brackets\Media\Exceptions\FileCannotBeAdded\TooManyFiles;

use Brackets\Media\Test\TestCase;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\MimeTypeNotAllowed;

class HasMediaCollectionsTest extends TestCase
{

    /** @test */
    public function empty_collection_returns_a_laravel_collection()
    {
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $this->testModel->getMediaCollections());
    }

    /** @test */
    public function not_empty_collection_returns_a_laravel_collection()
    {
        $this->assertInstanceOf(\Illuminate\Support\Collection::class, $this->testModelWithCollections->getMediaCollections());
    }

    /** @test */
    public function check_media_collections_count()
    {
        $this->assertCount(0, $this->testModel->getMediaCollections());
        $this->assertCount(3, $this->testModelWithCollections->getMediaCollections());
    }

    /** @test */
    public function check_image_media_collections_count()
    {
        $this->assertCount(0, $this->testModel->getMediaCollections()->filter->isImage());
        $this->assertCount(1, $this->testModelWithCollections->getMediaCollections()->filter->isImage());
    }

    /** @test */
    public function just_for_dev()
    {
        $this->testModel->addMediaCollection('documents');
        $this->testModel->addMediaCollection('video');

        $this->assertCount(2, $this->testModel->getMediaCollections());
        $this->assertCount(0, $this->testModel->getMedia());

        $request = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test',
                    ],
                ],
                [
                    'collection_name' => 'documents',
                    'path' => 'test.docx',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test',
                    ],
                ]
            ],
            'video' => [
                [
                    'collection_name' => 'video',
                    'path' => 'test.zip',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'video test',
                    ],
                ]
            ]
        ]);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();

        $this->assertCount(2, $this->testModel->getMedia('documents'));
        $firstMedia = $this->testModel->getMedia('documents')->first();
        $this->assertStringStartsWith('application/pdf', $firstMedia->mime_type);
    }

    /** @test */
    public function user_can_register_new_file_collection_and_upload_files()
    {
        $this->testModel->addMediaCollection('documents');

        $this->assertCount(1, $this->testModel->getMediaCollections());
        $this->assertCount(0, $this->testModel->getMedia());

        $request = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test',
                    ],
                ],
                [
                    'collection_name' => 'documents',
                    'path' => 'test.docx',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test',
                    ],
                ]
            ],
        ]);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();

        $this->assertCount(2, $this->testModel->getMedia('documents'));
        $firstMedia = $this->testModel->getMedia('documents')->first();
        $this->assertStringStartsWith('application/pdf', $firstMedia->mime_type);
    }

    /** @test */
    public function media_is_saved_automatically_when_model_is_saved()
    {
        $this->disableExceptionHandling();
        $response = $this->post('/test-model/create', [
            'name' => 'Test auto process',
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test',
                    ],
                ]
            ],
        ]);

        $response->assertStatus(201);

        $media = $this->app['db']->connection()->table('media')->first();

        $this->assertStringStartsWith('test.pdf', $media->file_name);
        $this->assertStringStartsWith('{"name":"test"}', $media->custom_properties);
    }

    /** @test */
    public function media_is_not_saved_automatically_while_model_is_saved_if_this_feature_is_disabled()
    {
        $response = $this->post('/test-model-disabled/create', [
            'name' => 'Test auto process disabled',
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test',
                    ],
                ]
            ],
        ]);

        $response->assertStatus(201);

        $this->assertEmpty($this->app['db']->connection()->table('media')->first());
    }

    /** @test */
    public function user_cannot_upload_not_allowed_file_types()
    {
        $this->disableExceptionHandling();
        $this->expectException(MimeTypeNotAllowed::class);

        $this->testModel->addMediaCollection('documents')
                        ->accepts('application/pdf', 'application/msword');

        $request = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.psd',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test',
                    ],
                ]
            ],
        ]);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();

        $this->assertCount(0, $this->testModel->getMedia('documents'));
    }

    public function multiple_allowed_mime_types_can_be_defined()
    {
        $this->testModel->addMediaCollection('documents')
                        ->accepts('application/pdf', 'application/msword');

        $request = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test',
                    ],
                ]
            ],
        ]);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();

        $this->assertCount(1, $this->testModel->getMedia('documents'));
    }

    /** @test */
    public function user_cannot_upload_more_files_than_allowed()
    {
        $this->expectException(TooManyFiles::class);

        $this->testModel->addMediaCollection('documents')
                        ->maxNumberOfFiles(2);

        $request = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ],
                [
                    'collection_name' => 'documents',
                    'path' => 'test.txt',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 2',
                    ],
                ],
                [
                    'collection_name' => 'documents',
                    'path' => 'test.docx',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 3',
                    ],
                ],
            ],
        ]);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();

        $this->assertCount(0, $this->testModel->getMedia('documents'));
    }

    /** @test */
    public function user_cannot_upload_more_files_than_is_allowed_in_multiple_requests()
    {
        $this->expectException(TooManyFiles::class);

        $this->testModel->addMediaCollection('documents')
                        ->maxNumberOfFiles(2);

        $request = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ],
                [
                    'collection_name' => 'documents',
                    'path' => 'test.txt',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 2',
                    ],
                ],
            ],
        ]);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();
        // let's be sure we arranged this test correctly (so this is not a real test assertion)
        $this->assertCount(0, $this->testModel->getMediaCollections());

        $this->testModel->addMediaCollection('documents')
                        ->maxNumberOfFiles(2);

        $request2 = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.docx',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 3',
                    ],
                ],
            ],
        ]);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();

        // finally we can assert
        $this->assertCount(2, $this->testModel->getMedia('documents'));
        // TODO let's double-check that original two documents are attached (and not replaced by new one)
    }

    /** @test */ // FIXME this one is redundant, we already tested that in previous test, I think we can totally delete this one
    public function user_can_upload_exact_number_of_defined_files()
    {
        $this->testModel->addMediaCollection('documents')
                        ->maxNumberOfFiles(2);

        $request = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ],
                [
                    'collection_name' => 'documents',
                    'path' => 'test.txt',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 2',
                    ],
                ],
            ],
        ]);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();

        $this->assertCount(2, $this->testModel->getMedia('documents'));
    }

    /** @test */
    public function user_cannot_upload_file_exceeding_max_file_size()
    {
        $this->expectException(FileIsTooBig::class);

        $this->testModel->addMediaCollection('documents')
                        ->maxFilesize(100*1024); //100kb


        $request = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.psd',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ],
            ],
        ]);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();

        $this->assertCount(0, $this->testModel->getMedia('documents'));
    }

    /** @test */
    public function user_can_upload_files_in_max_file_size()
    {
        $this->testModel->addMediaCollection('documents')
                        ->maxFilesize(1*1024); //1kb

        $request = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.txt',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ],
            ],
        ]);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();

        $this->assertCount(1, $this->testModel->getMedia('documents'));
    }

    /** @test */
    public function not_authorized_user_can_get_public_media()
    {
        $this->assertCount(0, $this->testModelWithCollections->getMedia('gallery'));

        $request = $this->getRequest([
            'gallery' => [
                [
                    'collection_name' => 'gallery',
                    'path' => 'test.jpg',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                        'width'      => 200,
                        'height'     => 200,
                    ],
                ],
            ],
        ]);

        $this->testModelWithCollections->processMedia(collect($request->only($this->testModelWithCollections->getMediaCollections()->map->getName()->toArray())));
        $this->testModelWithCollections = $this->testModelWithCollections->fresh()->load('media');

        $media = $this->testModelWithCollections->getMedia('gallery');

        $this->assertCount(1, $media);

        $response = $this->call('GET', $media->first()->getUrl());

        // let's assert that the access was not forbidden (but as long as we don't have a real nginx serving the file, we cannot actually get the file
        $this->assertNotEquals(403, $response->getStatusCode());
        // that's why we at least check if the final URL is correct
        // TODO
    }

    /** @test */
    public function not_authorized_user_cannot_get_protected_media()
    {
        $this->disableAuthorization();
        $this->assertCount(0, $this->testModelWithCollections->getMedia('documents'));

        $request = $this->getRequest([
             'documents' => [
                 [
                     'collection_name' => 'documents',
                     'path' => 'test.pdf',
                     'action' => 'add',
                     'meta_data' => [
                         'name' => 'test 1',
                     ],
                 ],
             ],
        ]);

        $this->testModelWithCollections->processMedia(collect($request->only($this->testModelWithCollections->getMediaCollections()->map->getName()->toArray())));
        $this->testModelWithCollections = $this->testModelWithCollections->fresh();

        $media = $this->testModelWithCollections->getMedia('documents');

        $this->assertCount(1, $media);

        $response = $this->json('GET', $media->first()->getUrl());

        $response->assertStatus(403);
    }

    /** @test */
    public function should_save_model_with_in_auto_process()
    {
        $response = $this->post('/test-model/create', [
            'name' => 'Test small file',
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ],
            ],
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas($this->testModelWithCollections->getTable(), [ 'id' => 2, 'name' => 'Test small file', 'width' => null ]);
    }

    /** @test */
    public function should_not_save_model_if_media_failed_in_auto_process()
    {
        $response = $this->post('/test-model/create', [
            'name' => 'Test big file',
            'zip' => [
                [
                    'collection_name' => 'zip',
                    'path' => 'test.zip',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ],
            ],
        ]);

        $response->assertStatus(500);

        $this->assertDatabaseMissing($this->testModelWithCollections->getTable(), [ 'id' => 1, 'name' => 'Test big file', 'width' => null ]);
    }

    //FIXME With spatie collection, you can have multiple collection with same name
//    /** @test */
//    public function model_cannot_have_multiple_collections_with_same_name()
//    {
//        $this->expectException(MediaCollectionAlreadyDefined::class);
//
//        $this->testModelWithCollections->addMediaCollection('documents');
//    }

    /** @test */
    public function user_can_delete_file_from_collection()
    {
        $this->testModel->addMediaCollection('documents')
            ->maxNumberOfFiles(2);

        $request = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ],
                [
                    'collection_name' => 'documents',
                    'path' => 'test.txt',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 2',
                    ],
                ],
            ],
        ]);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();
        $media = $this->testModel->getMedia('documents');
        $this->assertCount(2, $media);

        $request = $this->getRequest([
            'documents' => [
                [
                    'id' => $media->first()->id,
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'delete',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ]
            ],
        ]);

        $this->testModel->addMediaCollection('documents')
            ->maxNumberOfFiles(2);

        $this->testModel->processMedia(collect($request->only($this->testModel->getMediaCollections()->map->getName()->toArray())));
        $this->testModel = $this->testModel->fresh();
        $media = $this->testModel->getMedia('documents');
        $this->assertCount(1, $media);
        $this->assertEquals('test.txt', $media->first()->file_name);
    }

    /** @test */
    public function user_can_get_thumbs()
    {
        $this->assertCount(0, $this->testModelWithCollections->getMedia('gallery'));

        $request = $this->getRequest([
            'gallery' => [
                [
                    'collection_name' => 'gallery',
                    'path' => 'test.jpg',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                        'width'      => 200,
                        'height'     => 200,
                    ],
                ],
            ],
        ]);

        $this->testModelWithCollections->processMedia(collect($request->only($this->testModelWithCollections->getMediaCollections()->map->getName()->toArray())));
        $this->testModelWithCollections = $this->testModelWithCollections->fresh()->load('media');

        $this->assertCount(1, $this->testModelWithCollections->getThumbs200ForCollection('gallery'));
    }

    /** @test */
    public function user_can_get_file_if_thumbs_not_registered()
    {
        $this->assertCount(0, $this->testModelWithCollections->getMedia('gallery'));

        $request = $this->getRequest([
            'documents' => [
                [
                    'collection_name' => 'documents',
                    'path' => 'test.pdf',
                    'action' => 'add',
                    'meta_data' => [
                        'name' => 'test 1',
                    ],
                ],
            ],
        ]);

        $this->testModelWithCollections->processMedia(collect($request->only($this->testModelWithCollections->getMediaCollections()->map->getName()->toArray())));
        $this->testModelWithCollections = $this->testModelWithCollections->fresh()->load('media');

        $this->assertCount(1, $this->testModelWithCollections->getThumbs200ForCollection('documents'));
    }

    /** @test */
    public function system_automatically_detects_image_collection_based_on_mime_type()
    {
        $this->assertCount(1, $this->testModelWithCollections->getMediaCollections()->filter->isImage());

        //collection without mimetype is not image
        $this->testModelWithCollections->addMediaCollection('without_mime_type')->accepts('');
        $this->assertCount(1, $this->testModelWithCollections->getMediaCollections()->filter->isImage());

        //collection with only image mimetypes is image
        $this->testModelWithCollections->addMediaCollection('image_mime_type')->accepts('image/jpeg', 'image/png');
        $this->assertCount(2, $this->testModelWithCollections->getMediaCollections()->filter->isImage());

        //collection with mixed mimetypes is not image
        $this->testModelWithCollections->addMediaCollection('mixed_mime_type')->accepts('image/jpeg', 'application/pdf', 'application/msword');
        $this->assertCount(2, $this->testModelWithCollections->getMediaCollections()->filter->isImage());
    }

    private function getRequest($data)
    {
        return Request::create('test', 'GET', $data);
    }
}
