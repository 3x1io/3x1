<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FillSettingsTable extends Migration
{
    /**
     * @var array
     */
    protected $settings;

    /**
     * @var string
     */
    protected $table = 'settings';

    public function __construct()
    {
        $this->settings = [
            [
                "key" => "site.name",
                "group" => "site",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "site.description",
                "group" => "site",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "site.keywords",
                "group" => "site",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "site.logo",
                "group" => "site",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "site.author",
                "group" => "site",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "paytabs.merchant_email",
                "group" => "paytabs",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "paytabs.secret_key",
                "group" => "paytabs",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "email.host",
                "group" => "email",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "email.port",
                "group" => "email",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "email.username",
                "group" => "email",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "email.password",
                "group" => "email",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "email.encryption",
                "group" => "email",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "email.from",
                "group" => "email",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "email.from.name",
                "group" => "email",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "pusher.key",
                "group" => "pusher",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "pusher.secret",
                "group" => "pusher",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "pusher.app_id",
                "group" => "pusher",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "pusher.cluster",
                "group" => "pusher",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "messagebird.access_key",
                "group" => "messagebird",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "messagebird.originator",
                "group" => "messagebird",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "key" => "messagebird.recipients",
                "group" => "messagebird",
                "value" =>"",
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
        ];
    }

    public function up()
    {
        $table = $this->table;
        DB::transaction(function () use($table) {
            foreach ($this->settings as $setting){
                $settingItem = DB::table($table)->where([
                    'key' => $setting['key']
                ])->first();
                if ($settingItem === null) {
                    DB::table($table)->insert($setting);
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = $this->table;
        DB::transaction(function () use($table) {
            foreach ($this->settings as $setting){
                $settingItem = DB::table($table)->where([
                    'key' => $setting['key']
                ])->first();
                if ($settingItem !== null) {
                    DB::table($table)->where([
                        'key' => $setting['key']
                    ])->delete();
                }
            }
        });
    }
}
