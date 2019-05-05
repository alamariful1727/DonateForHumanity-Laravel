@extends('layouts.app')



@section('content')
  @include('inc.msg')
<div class="container">
  <h1 class="text-center head-text">{{$campaign->title}}</h1>
  <!-- check login -->
  @if (Auth::check())
  <!-- check valid useer/admin -->
  @if ($campaign->user_id == Auth::user()->id || Auth::user()->type == 'admin')
  <a class="text-info" href="{{route('campaign.edit',[$campaign->cid])}}"><span class="h3">Edit <i
        class="fas fa-edit text-light"></i></span></a> @endif
  <!-- check valid useer/admin ends-->
  @endif
  <!-- check login ends -->
  <hr class="head-hr">
  <!-- Image -->
  <div class="row justify-content-center">
    <div class="col-lg-8 text-center">
      <img src="/storage/campaign_images/{{$campaign->c_image}}" class="img-fluid">
    </div>
  </div>
  <!-- Image ends -->
  <div class="row justify-content-center my-4">
    <div class="card col-8">
      <div class="card-body">
        <h4 class="card-title">Creator</h4>
        <p class="card-text">{{$campaign->user->name}} <span class="text-info">{{$campaign->user->email}}</span></p>
        <h4 class="card-title">Description</h4>
        <p class="card-text">{{$campaign->c_desc}}</p>
      </div>
      <ul class="list-group list-group-flush">
        <li
          class="list-group-item @if ($campaign->c_status == 'active') {{'text-success'}}@else{{'text-danger'}}@endif">
          Status : {{$campaign->c_status}}
        </li>
        <li class="list-group-item">Finish on : {{$campaign->ends}}</li>
        <li class="list-group-item">Budget : {{$campaign->c_budget}}$</li>
        <li class="list-group-item">Donated : {{$campaign->c_balance}}$ @if ($campaign->c_status == 'active') <a
            href="#" class="btn btn-outline-danger ml-5">Donate now!! <i
              class="fas fa-heart text-warning"></i></a>@endif</li>
        <li class="list-group-item">
          <h3>Name of contributors: </h3>
          <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">None</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
  <!-- row ends -->
</div>
@endsection