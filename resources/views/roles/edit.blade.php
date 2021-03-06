@extends('layouts.main')
@section('content')
    <div class="content col-md-8">

        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">编辑角色</h3>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                <form class="form-horizontal w5c-form" role="form" name="validateForm" onsubmit="return formSubmit()">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">角色名称</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" value="{{ $role['name'] }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">角色权限</label>
                        <div class="col-sm-9">

                            <?php
                            $rolePerms = [];
                            if ( ! empty($role['perms'])) {
                                foreach ($role['perms'] as $rolePerm) {
                                    $rolePerms[] = $rolePerm['id'];
                                }
                            }
                            ?>
                            @foreach($permissions as $permission)

                                <div class="checkbox col-md-4">
                                    <label>
                                        @if(in_array($permission['id'], $rolePerms))
                                            <input type="checkbox" name="permission"
                                                   value="{{ $permission['id'] }}"
                                                   checked="checked">{{ $permission['display_name'] }}
                                        @else
                                            <input type="checkbox" name="permission"
                                                   value="{{ $permission['id'] }}">{{ $permission['display_name'] }}
                                        @endif
                                    </label>
                                </div>

                            @endforeach
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">角色描述</label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="description" value="" id=""
                                      rows="2">{{ $role['description'] }}</textarea>
                        </div>
                    </div>

                </form>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
                <input type="button" class="btn btn-primary pull-right" onclick="formSubmit()" value="提交">
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script src="{{ asset('/js/shopping-cart.js') }}"></script>
    <script>

      function formSubmit() {

        var permission = [];
        var permissionChecked = $('input[name="permission"]:checked');
        for (var i = 0; i < permissionChecked.length; i++) {
          permission.push(permissionChecked[i].value);
        }

        var roleData = {
          name: $('input[name="name"]').val(),
          permission: permission,
          description: $('textarea[name="description"]').val()
        };

        $.post('/roles/update/{{ $role['id'] }}', roleData, function (response) {
          if (response.errCode == 0) {
            responseSuccess(response.message, function () {
              window.location.reload();
            });
          } else {
            swal('', response.message, 'error');
          }
        });

        return false;
      }
    </script>
@endsection