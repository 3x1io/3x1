{!! input('text', 'first_name',trans('admin.admin-user.columns.first_name'), 'required' ) !!}
{!! input('text', 'last_name',trans('admin.admin-user.columns.last_name'), 'required' ) !!}
{!! input('email', 'email',trans('admin.admin-user.columns.email'), 'required|email' ) !!}
{!! input('password', 'password',trans('admin.admin-user.columns.password'), 'required|min:7' ) !!}
{!! input('password', 'password_confirmation',trans('admin.admin-user.columns.password_repeat'), 'required|confirmed:password|min:7' ) !!}
{!! input('m-select', 'language',trans('admin.admin-user.columns.language'), 'required', [
    "data" => $locales
] ) !!}

{!! input('m-select', 'roles',trans('admin.admin-user.columns.roles'), '', [
    "name" => "name",
    "id" => "id",
    "data" => $roles,
    "multi"=> true
] ) !!}
{!! input('checkbox', 'activated',trans('admin.admin-user.columns.activated')) !!}
{!! input('checkbox', 'forbidden',trans('admin.admin-user.columns.forbidden')) !!}
