@extends('backend.layouts.master')

@section('title','E-SHOP || Comment Create')

@section('main-content')

<div class="card">
  <h5 class="card-header">Add Comment</h5>
  <div class="card-body">
    <form method="post" action="{{route('comment.store')}}">
      @csrf
      <div class="form-group">
        <label for="cat_id">Category <span class="text-danger">*</span></label>
        <select name="post_id" id="post_id" class="form-control">
          <option value="">--Select category--</option>
          @foreach($posts as $post)
          <option value='{{$post->id}}'>{{$post->title}}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="inputDesc" class="col-form-label">Comment</label>
        <textarea class="form-control" id="description" name="comment">{{old('description')}}</textarea>
        @error('description')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-control">
          <option value="active">Active</option>
          <option value="inactive" selected>Inactive</option>
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

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="{{asset('/vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
  $('#description').summernote();
  var route_prefix = "{{url('/filemanager')}}";
  $('#lfm').filemanager('image', {
    prefix: route_prefix
  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
@endpush