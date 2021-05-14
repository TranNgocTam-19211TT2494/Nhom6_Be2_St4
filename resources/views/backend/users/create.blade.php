@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <h5 class="card-header">Add User</h5>
  <div class="card-body">
    <form method="post" action="{{route('users.store')}}">
      {{csrf_field()}}
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Name</label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter name" value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="inputEmail" class="col-form-label">Email</label>
        <input id="inputEmail" type="email" name="email" placeholder="Enter email" value="{{old('email')}}" class="form-control">
        @error('email')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="inputPassword" class="col-form-label">Password</label>
        <input id="inputPassword" type="password" name="password" placeholder="Enter password" value="{{old('password')}}" class="form-control">
        @error('password')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-btn">
            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
              <i class="fa fa-picture-o"></i> Choose
            </a>
          </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:500px;"></div>
        @error('photo')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="role" class="col-form-label">Role</label>
        <select name="role" class="form-control">
          <option value="">-----Select Role-----</option>


          <option value="admin">ADMIN</option>
          <option value="mod">MOD</option>
          <option value="writter">WRITTER</option>
          <option value="user">USER</option>

        </select>
        @error('role')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group">
        <label for="status" class="col-form-label">Status</label>
        <select name="status" class="form-control">
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
        @error('status')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group mb-3">
        <button type="reset" class="btn btn-warning">Reset</button>
        <button class="btn btn-success" type="submit">Submit</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
  var route_prefix = "{{url('/filemanager')}}";
  $('#lfm').filemanager('image', {
    prefix: route_prefix
  });
</script>
@endpush