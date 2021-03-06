@extends('layouts.app') 
@section('content')
  @include('inc.msg')
<style>
  body {
    background: #FC354C;
    /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #0ABFBC, #FC354C);
    /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #0ABFBC, #FC354C);
    /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
  }
</style>
<div class="container">
  <h1 class="text-center head-text">Edit details!!</h1>
  <hr class="head-hr">

  <!-- row ends -->
  <div class="row">
    <div class="offset-lg-3 col-lg-6 col-md-12">
      <div class="card p-3">
        <form method="POST" action="{{route('dashboard.update',[Auth::user()->id])}}" enctype="multipart/form-data">
          <!-- name -->
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="name">@</span>
            </div>
            <input type="text" required name="name" class="form-control" placeholder="name" aria-label="name" aria-describedby="name"
              value="@if (old('name')!='') {{old('name')}} @else {{$user->name}} @endif">
          </div>
          <!-- name error -->
          @if ($errors->has('name'))
          <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $errors->first('name') }}</strong>
              </span> @endif
          <!-- name error ends -->
          <!-- description -->
          <div class="form-group">
            <label for="description">Description</label> @if (old('description')!='')
            <textarea name="description" required class="form-control" placeholder="who you are!!" id="description" rows="3">{{old('description')}}</textarea>            @else
            <textarea name="description" class="form-control" placeholder="who you are!!" id="description" rows="3">{{$user->description}}</textarea>            @endif
          </div>
          <!-- description error -->
          @if ($errors->has('description'))
          <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $errors->first('description') }}</strong>
              </span> @endif
          <!-- description error ends -->
          <!-- URL -->
          <label for="basic-url">URL</label>
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="url">https://ocr.com/</span>
            </div>
            <input type="text" required name="url" class="form-control" id="basic-url" aria-describedby="url" value="@if (old('url')!='') {{old('url')}} @else {{$user->url}} @endif">
          </div>
          <!-- url error -->
          @if ($errors->has('url'))
          <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $errors->first('url') }}</strong>
              </span> @endif
          <!-- url error ends -->
          <!-- image -->
          <div class="imgwrapper mb-2 text-center">
            <img style="width:50%;" class="d-inline-block" src="/storage/user_images/{{$user->image}}">
          </div>
          <!-- file -->
          <div class="input-group">
            <div class="custom-file">
              <input name="cover_image" type="file" onchange="readURL(this);" class="custom-file-input" id="cover_image" aria-describedby="inputGroupFileAddon04"
                accept="image/*">
              <label class="custom-file-label" for="cover_image">Choose photo..</label>
            </div>
            <small id="fileError" class="form-text text-danger"></small>
          </div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-info mx-auto d-block mt-4">Edit <span><i class="far fa-edit"></i></span></button>
        </form>
      </div>
      <!-- card ends -->
      <a href="{{Auth::user()->url}}" class="head-text d-block text-center my-4 toggle-text">Dashboard!!</a>
    </div>
    <!-- row ends -->
  </div>

  <script>
    ////////////// file preview /////////////////
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('.custom-file-label').html(input.files[0].name);
    };
    reader.readAsDataURL(input.files[0]);
  } 
}
  </script>
@endsection