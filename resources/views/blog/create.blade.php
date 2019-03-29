@extends('layouts.app') 
@section('content')
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
  <h1 class="text-center head-text">Share your experience with us!!</h1>
  <hr class="head-hr">

  <!-- row ends -->
  <div class="row">
    <div class="offset-lg-3 col-lg-6 col-md-12">
      <div class="card p-3">
        <form method="POST" action="{{route('blog.store')}}">
          <div class="form-group">
            <label for="body">Blog Description</label>
            <textarea name="body" class="form-control" placeholder="Write your thoughts about us.. ^_^" id="body" rows="3"></textarea>
            <small id="ccError" class="form-text text-danger"></small>
          </div>
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <button type="submit" class="btn btn-primary mx-auto d-block">Share <span><i
                  class="fas fa-share ml-2"></i></span></button>
        </form>
      </div>
      <!-- card ends -->
      <a href="{{route('blog.index')}}" class="head-text d-block text-center my-4 toggle-text">All blogs!!</a>
    </div>
    <!-- row ends -->
  </div>

  <script>
    console.log('{{ csrf_token() }}');
    // $('#body').ckeditor();
  </script>
@endsection