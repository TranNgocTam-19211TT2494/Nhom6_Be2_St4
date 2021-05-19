@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <h5 class="card-header">Site setting</h5>
  <div class="card-body">
    @include('backend.layouts.notification')
    <form method="post" action="{{route('setting.update')}}">
      @csrf
      <div class="form-group">
        <label for="title" class="col-form-label">Title <span class="text-danger">*</span></label>
        <textarea class="form-control" id="title" name="title">{{$data->title}}</textarea>
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="message" class="col-form-label">Title <span class="text-danger">*</span></label>
        <textarea class="form-control" id="message" name="message">{{$data->message}}</textarea>
        @error('message')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group">
        <label for="description" class="col-form-label">Description <span class="text-danger">*</span></label>
        <textarea class="form-control" id="description" name="description">{{$data->description}}</textarea>
        @error('description')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Logo <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-btn">
            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
              <i class="fa fa-picture-o"></i> Choose
            </a>
          </span>
          <input id="thumbnail" class="form-control" type="text" name="logo" value="{{$data->logo}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>

        @error('logo')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="address" class="col-form-label">Address <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="address" required value="{{$data->address}}">
        @error('address')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group">
        <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
        <input type="email" class="form-control" name="email" required value="{{$data->email}}">
        @error('email')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <div class="form-group">
        <label for="phone" class="col-form-label">Phone Number <span class="text-danger">*</span></label>
        <input type="text" class="form-control" name="phone" required value="{{$data->phone}}">
        @error('phone')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group mb-3">
        <button class="btn btn-success" type="submit">Update</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
  $('#description').summernote();
  var route_prefix = "{{url('/filemanager')}}";
  $('#lfm').filemanager('image', {
    prefix: route_prefix
  });
</script>
@endpush