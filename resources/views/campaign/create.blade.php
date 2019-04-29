@extends('layouts.app') 
@section('content') {{--
  @include('inc.msg') --}}
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
  <h1 class="text-center head-text">Create Campaign!!</h1>
  <hr class="head-hr">

  <!-- row ends -->
  <div class="row">
    <div class="offset-lg-3 col-lg-6 col-md-12">
      <div class="card p-3">
        <form method="POST" action="{{route('campaign.store')}}" enctype="multipart/form-data">
          <!-- title -->
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="title">Title</span>
            </div>
            <input type="text" required name="title" class="form-control" placeholder="Eg. Health and care" aria-label="title" aria-describedby="title"
              value="{{old('title')}}">
          </div>
          <!-- title error -->
          @if ($errors->has('title'))
          <span class="invalid-feedback d-block" role="alert">
              <strong>{{ $errors->first('title') }}</strong>
          </span> @endif
          <!-- title error ends -->
          <!-- c_desc -->
          <div class="form-group">
            <label for="c_desc">Description</label>
            <textarea name="c_desc" required class="form-control" placeholder="campaign's description" id="c_desc" rows="3">{{old('c_desc')}}</textarea>
          </div>
          <!-- c_desc error -->
          @if ($errors->has('c_desc'))
          <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $errors->first('c_desc') }}</strong>
              </span> @endif
          <!-- c_desc error ends -->
          <!-- budget&duration -->
          <div class="form-row">
            <div class="col form-group">
              <label for="budget">Budget</label>
              <input type="number" id="budget" required class="form-control" name="c_budget" value="{{old('c_budget')}}" placeholder="Enter your budget">
              <!-- c_budget error -->
              @if ($errors->has('c_budget'))
              <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $errors->first('c_budget') }}</strong>
              </span> @endif
              <!-- c_budget error ends -->
            </div>
            <div class="col form-group">
              <label for="duration">Duration</label>
              <input type="number" id="duration" required class="form-control" name="duration" value="{{old('duration')}}" placeholder="campaign duration">
              <!-- duration error -->
              @if ($errors->has('duration'))
              <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $errors->first('duration') }}</strong>
              </span> @endif
              <!-- duration error ends -->
            </div>
          </div>
          <!-- budget&duration error ends -->
          <!-- file -->
          <div class="form-group">
            <div class="custom-file">
              <input name="cover_image" type="file" onchange="readURL(this);" class="custom-file-input" id="cover_image" aria-describedby="inputGroupFileAddon04"
                accept="image/*">
              <label class="custom-file-label" for="cover_image">Choose photo..</label>
            </div>
            <!-- cover_image error -->
            @if ($errors->has('cover_image'))
            <span class="invalid-feedback d-block" role="alert">
                <strong>{{ $errors->first('cover_image') }}</strong>
            </span> @endif
            <!-- cover_image error ends -->
          </div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-info mx-auto d-block mt-4">Create</button>
        </form>
      </div>
      <!-- card ends -->
      <a href="{{route('campaign.index')}}" class="head-text d-block text-center my-4 toggle-text">All campaigns!!</a>
    </div>
    <!-- row ends -->
  </div>

  <script>
    console.log('{{ csrf_token() }}');
  </script>
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