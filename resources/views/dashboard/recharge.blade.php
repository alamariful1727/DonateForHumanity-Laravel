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
  <h1 class="text-center head-text">Recharge balance!!</h1>
  <hr class="head-hr">

  <!-- row -->
  <div class="row">
    <div class="col-md-8 mx-auto">
      <div class="card">
        <div class="card-header d-flex align-items-center">
          <h4>Request to ADMIN</h4>
        </div>
        <div class="card-body">
          <form method="POST" action="">
            <!-- amount -->
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text" id="amount">Amount</span>
              </div>
              <input type="number" required name="amount" class="form-control" placeholder="Round amount in Dollar."
                aria-label="amount" aria-describedby="amount" value="{{old('amount')}}">
            </div>
            <!-- amount error -->
            @if ($errors->has('amount'))
            <span class="invalid-feedback d-block" role="alert">
              <strong>{{ $errors->first('amount') }}</strong>
            </span> @endif
            <!-- amount error ends -->
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-info mx-auto d-block mt-4">Request</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- row ends -->
@endsection