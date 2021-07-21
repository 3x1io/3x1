@extends('brackets/admin-ui::admin.layout.default')

@section('body')
    <div class="row">
        <div class="col-md-12">
            <form class="mb-3" method="GET" action="{{url('admin/search')}}">
                <div class="input-group">
                    <input type="search" class="form-control" name="search" id="search" placeholder="{{__('What Are You Searching About?')}}">
                    <span class="input-group-append">
                        <select class="form-control" id="type" name="type">
                            <option value="customer">{{__('Customer')}}</option>
                            <option value="product">{{__('Product')}}</option>
                        </select>
                        <button type="submit" class="input-group-btn btn-primary"><i class="fa fa-search"></i> {{__('Search')}}</button>
                    </span>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-primary p-3">
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
            <div class="card text-white bg-info p-3">
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
            <div class="card text-white bg-warning p-3">
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
            <div class="card text-white bg-danger p-3">
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
    <table class="table table-responsive-sm table-hover table-outline">
        <thead class="thead-light">
            <tr>
            <th class="text-center">
                <i class="fa fa-users"></i>
            </th>
            <th>User</th>
            <th class="text-center">Country</th>
            <th>Usage</th>
            <th class="text-center">Payment Method</th>
            <th>Activity</th>
        </tr>
        </thead>
        <tbody>
            <tr>
            <td class="text-center">
                <div class="c-avatar"><img class="avatar" src="{{url('placeholder.webp')}}" alt="user@email.com"><span class="c-avatar-status bg-success"></span></div>
            </td>
            <td>
                <div>Yiorgos Avraamu</div>
                <div class="small text-muted"><span>New</span> | Registered: Jan 1, 2015</div>
            </td>
            <td class="text-center">
                <i class="fa fa-flag"></i>
            </td>
            <td>
                <div class="clearfix">
                    <div class="float-left"><strong>50%</strong></div>
                    <div class="float-right"><small class="text-muted">Jun 11, 2015 - Jul 10, 2015</small></div>
                </div>
                <div class="progress progress-xs">
                    <div class="progress-bar bg-gradient-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </td>
            <td class="text-center">
                <i class="fa fa-cc-visa"></i>
            </td>
            <td>
                <div class="small text-muted">Last login</div><strong>10 sec ago</strong>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
