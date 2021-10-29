@extends('brackets/admin-ui::admin.layout.default')

@section('body')
    <x-card title="{{__('Dashboard')}}" icon="fa fa-dashboard">
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-primary p-3 border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fa fa-users fa-4x"></i>
                                </div>
                                <div>
                                    <div class="text-value-lg">9.823</div>
                                    <div>Customers</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-info p-3 border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fa fa-rocket fa-4x"></i>
                                </div>
                                <div>
                                    <div class="text-value-lg">9.823</div>
                                    <div>Orders</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-warning p-3 border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fa fa-money fa-4x"></i>
                                </div>
                                <div>
                                    <div class="text-value-lg">9.823</div>
                                    <div>Income</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="card text-white bg-danger p-3 border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fa fa-arrow-circle-down fa-4x"></i>
                                </div>
                                <div>
                                    <div class="text-value-lg">9.823</div>
                                    <div>Outcome</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </x-card>
    <x-card title="{{__('Review This Packages First [3x1 Framework v1.07]')}}" icon="fa fa-info">
        <h5>Thanks for this packages that's create our framework base <i class="fa fa-heart text-danger"></i></h5>
        <ul>
            <li><a href="https://www.getcraftable.com/" target="_blank"><b>Carftable</b> <small>[It's a Core Folder & CURD Generator & Admin Panel]</small></a></li>
            <li><a href="https://www.infyom.com/open-source" target="_blank"><b>Infyom</b> <small>[APIs Scaffolding]</small></a></li>
            <li><a href="https://github.com/milon/barcode" target="_blank"><b>Barcode</b> <small>[Generate Barcode]</small></a></li>
            <li><a href="https://tenancyforlaravel.com/" target="_blank"><b>Tenancy</b> <small>[SaaS]</small></a></li>
            <li><a href="https://github.com/creativeorange/gravatar" target="_blank"><b>Gravatar</b> <small>[Profile Avatar]</small></a></li>
            <li><a href="https://github.com/realrashid/sweet-alert" target="_blank"><b>Sweet Alert</b> <small>[Alerts]</small></a></li>
            <li><a href="https://laravel.com/" target="_blank"><b>Laravel</b> <small>[Main Framework]</small></a></li>
            <li><a href="https://laravel.com/docs/8.x/sanctum" target="_blank"><b>Laravel Sanctum</b> <small>[APIs Token Auth]</small></a></li>
            <li><a href="https://laravel.com/docs/8.x/socialite" target="_blank"><b>Laravel Socialite</b> <small>[Social Media Links]</small></a></li>
            <li><a href="https://spatie.be/docs/laravel-permission/v4/introduction" target="_blank"><b>Laravel Permission</b> <small>[User ACL]</small></a></li>
            <li><a href="https://packagist.org/packages/arrilot/laravel-widgets" target="_blank"><b>Laravel Widgets</b> <small>[Widgets]</small></a></li>
            <li><a href="https://nwidart.com/laravel-modules/v6/introduction" target="_blank"><b>Laravel Module</b> <small>[MVC Modular Arch]</small></a></li>
            <li><a href="https://laravel-excel.com/" target="_blank"><b>Laravel Excel</b> <small>[Import & Export Excel]</small></a></li>
            <li><a href="https://github.com/spatie/laravel-sitemap" target="_blank"><b>Laravel Sitemap</b> <small>[Sitemap Generator]</small></a></li>
            <li><a href="https://github.com/spatie/laravel-translatable" target="_blank"><b>Laravel Translatable</b> <small>[Translation]</small></a></li>
            <li><a href="https://github.com/spatie/laravel-medialibrary" target="_blank"><b>Laravel Media Library</b> <small>[Media & Upload]</small></a></li>
            <li><a href="https://github.com/spatie/laravel-backup" target="_blank"><b>Laravel Backup</b> <small>[Backup]</small></a></li>
            <li><a href="https://github.com/beyondcode/laravel-websockets" target="_blank"><b>Laravel WebSockets</b> <small>[WebSockets]</small></a></li>
            <li><a href="https://github.com/corcel/corcel" target="_blank"><b>Corcel</b> <small>[Wordpress Link]</small></a></li>
        </ul>
    </x-card>
@endsection
