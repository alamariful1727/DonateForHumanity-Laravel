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
  <h1 class="text-center head-text">Show your humanity!!</h1>
  <hr class="head-hr">

  <!-- row -->
  <div class="row">
    <div class="offset-lg-3 col-lg-6 col-md-12">
      <div class="card p-3">
        <h3 class="text-info my-3 text-center">Title: {{$campaign->title}}</h3>
        <div class="row mb-3">
          <div class="col">
            <h4>Budget: {{$campaign->c_budget}}$</h4>
          </div>
          <div class="col">
            <h4>Current balance: {{$campaign->c_balance}}$</h4>
          </div>
        </div>
        <form method="POST" action="{{route('campaign.donate',[$campaign->cid])}}">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="amount">Amount</span>
            </div>
            <input type="number" required name="amount" class="form-control"
              placeholder="Donate 1-{{$campaign->c_budget - $campaign->c_balance}} Dollar." aria-label="amount"
              aria-describedby="amount" value="{{old('amount')}}">
          </div>
          {{ csrf_field() }}
          <button type="submit" class="btn btn-info mx-auto d-block mt-4">Donate</button>
        </form>
      </div>
      <!-- card ends -->
      <a href="{{route('campaign.show',[$campaign->c_url])}}"
        class="head-text d-block text-center my-4 toggle-text">preview this campign!!</a>
    </div>
  </div>
  <!-- row ends -->
</div>
@endsection