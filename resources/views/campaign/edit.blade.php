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
  <h1 class="text-center head-text">Edit Campaign!!</h1>
  <hr class="head-hr">

  <!-- row -->
  <div class="row">
    <div class="offset-lg-3 col-lg-6 col-md-12">
      <div class="card p-3">
        <!-- delete btn -->
        @if (Auth::user()->type=='admin')
        <a class="text-danger pl-1" href="{{route('campaign.destroy',[$campaign->cid])}}" onclick="event.preventDefault(); document.getElementById('campaign-delete-form').submit();">Delete <i class="fas fa-trash-alt"></i></a>
        <form id="campaign-delete-form" action="{{route('campaign.destroy',[$campaign->cid])}}" method="POST" style="display: none;">
          {{ method_field('DELETE') }} {{ csrf_field() }}
        </form>
        @endif
        <!-- delete btn ends -->
        <form method="POST" action="{{route('campaign.update',[$campaign->cid])}}" enctype="multipart/form-data">
          <!-- title -->
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="title">Title</span>
            </div>
            <input type="text" required name="title" class="form-control" placeholder="Eg. Health and care" aria-label="title" aria-describedby="title"
              value="@if (old('title')!='') {{old('title')}} @else {{$campaign->title}} @endif">
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
            <!-- c_desc check -->
            @if (old('c_desc')!='')
            <textarea name="c_desc" required class="form-control" placeholder="who you are!!" id="c_desc" rows="3">{{old('c_desc')}}</textarea>
            <!-- c_desc intially -->
            @else
            <textarea name="c_desc" class="form-control" placeholder="who you are!!" id="c_desc" rows="3">{{$campaign->c_desc}}</textarea>@endif
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
              <input type="number" id="budget" required class="form-control" name="c_budget" placeholder="Enter your budget">

              <!-- c_budget error -->
              @if ($errors->has('c_budget'))
              <span class="invalid-feedback d-block" role="alert">
                  <strong>{{ $errors->first('c_budget') }}</strong>
              </span> @endif
              <!-- c_budget error ends -->
            </div>
            <div class="col form-group">
              <label for="duration">Duration</label>
              <input type="number" id="duration" required class="form-control" name="duration" placeholder="campaign duration">
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
          {{ method_field('PUT') }} {{ csrf_field() }}
          <button type="submit" class="btn btn-info mx-auto d-block mt-4">Edit</button>
        </form>
      </div>
      <!-- card ends -->
      <a href="{{route('campaign.show',[$campaign->c_url])}}" class="head-text d-block text-center my-4 toggle-text">preview this campign!!</a>
    </div>
  </div>
  <!-- row ends -->
</div>
<script>
  $("#budget").val(@if (old('c_budget')!='') {{old('c_budget')}} @else {{$campaign->c_budget}} @endif);
  $("#duration").val(@if (old('duration')!='') {{old('duration')}} @else {{$campaign->duration}} @endif);

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