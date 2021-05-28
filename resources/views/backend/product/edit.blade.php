@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <h5 class="card-header">Edit Product</h5>
  <div class="card-body">
    <form method="post" action="{{route('product.update',$product->id)}}">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{$product->title}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
        <textarea class="form-control" id="summary" name="summary">{{$product->summary}}</textarea>
        @error('summary')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="description" class="col-form-label">Description</label>
        <textarea class="form-control" id="description" name="description">{{$product->description}}</textarea>
        @error('description')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>


      <div class="form-group">
        <label for="is_featured">Is Featured</label><br>
        <input type="checkbox" name='is_featured' id='is_featured' value='{{$product->is_featured}}' {{(($product->is_featured) ? 'checked' : '')}}> Yes
      </div>
      {{-- {{$categories}} --}}

      <div class="form-group">
        <label for="cat_id">Category <span class="text-danger">*</span></label>
        <select name="cat_id" id="cat_id" class="form-control">
          <option value="">--Select any category--</option>
          @foreach($categories as $cat_data)
          <option value='{{$cat_data->id}}' {{(($product->cat_id==$cat_data->id)? 'selected' : '')}}>{{$cat_data->title}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="price" class="col-form-label">Price(VND) <span class="text-danger">*</span></label>
        <input id="price" type="number" name="price" placeholder="Enter price" value="{{$product->price}}" class="form-control">
        @error('price')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="discount" class="col-form-label">Discount(%)</label>
        <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount" value="{{$product->discount}}" class="form-control">
        @error('discount')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="weight" class="col-form-label">Weight(gam)</label>
        <input id="weight" type="number" name="weight" min="0" placeholder="Enter weight" value="{{$product->weight}}" class="form-control">
        @error('discount')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="manufacturer" class="col-form-label">Manufacturer</label>
        <input id="manufacturer" type="text" name="manufacturer" placeholder="Enter manufacturer" value="{{$product->manufacturer}}" class="form-control">
        @error('manufacturer')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="condition">Condition</label>
        <select name="condition" class="form-control">
          <option value="">--Select Condition--</option>
          <option value="default" {{(($product->condition=='default')? 'selected':'')}}>Default</option>
          <option value="new" {{(($product->condition=='new')? 'selected':'')}}>New</option>
          <option value="hot" {{(($product->condition=='hot')? 'selected':'')}}>Hot</option>
        </select>
      </div>

      <div class="form-group">
        <label for="stock">Quantity <span class="text-danger">*</span></label>
        <input id="quantity" type="number" name="stock" min="0" placeholder="Enter quantity" value="{{$product->stock}}" class="form-control">
        @error('stock')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="stock">Expiry <span class="text-danger">*</span></label>
        <input id="expiry" type="number" name="expiry" min="0" placeholder="Enter expiry" value="{{$product->expiry}}" class="form-control">
        @error('expiry')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
        <div class="input-group">
          <span class="input-group-btn">
            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
              <i class="fas fa-image"></i> Choose
            </a>
          </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$product->photo}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
        @error('photo')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-control">
          <option value="active" {{(($product->status=='active')? 'selected' : '')}}>Active</option>
          <option value="inactive" {{(($product->status=='inactive')? 'selected' : '')}}>Inactive</option>
        </select>
        @error('status')
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
<script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
  $('#summary').summernote();
  $('#description').summernote();
  var route_prefix = "{{url('/filemanager')}}";
  $('#lfm').filemanager('image', {
    prefix: route_prefix
  });
</script>
@endpush