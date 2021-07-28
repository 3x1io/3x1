{!! input('text', 'name', trans('admin.permission.columns.name'), 'required') !!}
{!! input('text', 'guard_name', trans('admin.permission.columns.guard_name'), 'required') !!}
{!! input('m-select', 'permissions', trans('admin.permission.columns.guard_name'), 'required', [
    "name" => "name",
    "id" => "id",
    "data" => $permissions,
    "multi" => true
]) !!}

