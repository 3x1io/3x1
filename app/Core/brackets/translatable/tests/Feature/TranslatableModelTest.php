<?php

namespace Brackets\Translatable\Test\Feature;

use Brackets\Translatable\Test\TestCase;

class TranslatableModelTest extends TestCase
{
    /** @test */
    public function model_by_default_works_only_with_default_locale()
    {
        $this->assertEquals('EN Name', $this->testModel->translatable_name);
        $this->assertEquals([
            'id' => 1,
            'translatable_name' => 'EN Name',
            'regular_name' => 'Regular Name',
        ], $this->testModel->toArray());
    }

    /** @test */
    public function you_can_set_locale()
    {
        $this->assertEquals('en', $this->testModel->getLocale());
        $this->testModel->setLocale('fr');
        $this->assertEquals('fr', $this->testModel->getLocale());
    }

    /** @test */
    public function you_can_change_locale_model_works_with()
    {
        $this->testModel->setLocale('fr');
        $this->assertEquals('FR Name', $this->testModel->translatable_name);
        $this->assertEquals([
            'id' => 1,
            'translatable_name' => 'FR Name',
            'regular_name' => 'Regular Name',
        ], $this->testModel->toArray());
        $this->assertEquals(json_encode([
            'id' => 1,
            'translatable_name' => 'FR Name',
            'regular_name' => 'Regular Name',
        ]), $this->testModel->toJson());
    }

    /** @test */
    public function changing_locale_does_not_affect_on_allLocales_methods()
    {
        $sameOutput = [
            'id' => 1,
            'translatable_name' => [
                'en' => 'EN Name',
                'de' => 'DE Name',
                'fr' => 'FR Name',
            ],
            'regular_name' => 'Regular Name',
        ];

        $this->assertEquals($sameOutput, $this->testModel->toArrayAllLocales());
        $this->assertEquals(json_encode($sameOutput), $this->testModel->toJsonAllLocales());

        $this->testModel->setLocale('fr');

        $this->assertEquals($sameOutput, $this->testModel->toArrayAllLocales());
        $this->assertEquals(json_encode($sameOutput), $this->testModel->toJsonAllLocales());
    }
}
