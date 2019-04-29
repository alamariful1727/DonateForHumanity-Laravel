@extends('layouts.app') 
@section('content')
  @include('inc.msg')
<div class="container">
  <h1 class="text-center head-text">Donation campaigns!!</h1>
  <hr class="head-hr">
  <!-- row ends -->
  <div class="row">
    @if (count($campaigns)>0)
    <div class="card-columns">
      @foreach ($campaigns as $campaign)
      <!-- check a active campaign -->
      {{-- @if ($campaign->c_status == "active") --}}
      <div class="card">
        <!-- edit delete btn -->
        @if (Auth::check()) @if (Auth::user()->id == $campaign->user->id || Auth::user()->type == 'admin')
        <div class="text-right abs-opt">
          <button type="button" data-bid="{{$campaign->bid}}" onclick="getBid(this);" id="btnEdit" class="btn btn-info" data-toggle="modal"
            data-target="#editModal">
              <span><i class="fas fa-edit text-light"></i></span>
            </button>
          <button type="button" data-bid="{{$campaign->bid}}" onclick="getBid(this);" id="btnDelete" class="btn btn-danger ml-1" data-toggle="modal"
            data-target="#exampleModalCenter">
              <span><i class="fas fa-trash-alt text-light"></i></span>
            </button>
        </div>
        @endif @endif
        <!-- edit delete btn ends -->
        <a href="{{route('campaign.show',[$campaign->c_url])}}"><img class="card-img-top" src="/storage/campaign_images/{{$campaign->c_image}}"></a>
        <h5 class="card-title p-2 mb-0 text-info">{{$campaign->title}}</h5>
        <blockquote class="blockquote mb-0 pt-0 card-body">
          <p>{{$campaign->c_desc}}</p>
          <footer class="blockquote-footer">
            <small class="text-muted"><cite title="{{$campaign->user->name}}">{{$campaign->user->email}}</cite>
                </small>
            <p class="card-text"><small class="text-muted">created on {{$campaign->c_created_at}}</small></p>
          </footer>
        </blockquote>
        <ul class="list-group list-group-flush">
          <li class="list-group-item @if ($campaign->c_status == 'active') {{'text-success'}}@else{{'text-danger'}}@endif">
            Status : {{$campaign->c_status}}
          </li>
          <li class="list-group-item">Budget : {{$campaign->c_budget}}</li>
          <li class="list-group-item">Vestibulum at eros</li>
        </ul>
      </div> @endforeach
    </div>
    @else
    <p>No campaigns found!!</p>
    @endif
    <!-- card columns ends -->

  </div>
  {{-- pagination --}} @if(Request::url() === 'http://onlinecarrent.com/campaigns') {{$campaigns->links()}} @endif
  <!-- row ends -->
</div>
@endsection