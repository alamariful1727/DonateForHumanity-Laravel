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
        <!-- check login -->
        @if (Auth::check())
        <!-- show EDIT option for valid user / admin -->
        @if (Auth::user()->id == $campaign->user->id || Auth::user()->type == 'admin')
        <div class="text-right abs-opt pr-1">
          <a class="text-info" href="{{route('campaign.edit',[$campaign->cid])}}"><i class="fas fa-edit"></i></a>
          <!-- show DELETE option for admin -->
          @if (Auth::user()->type=='admin')
          <a class="text-danger pl-1" href="{{route('campaign.destroy',[$campaign->cid])}}"
            onclick="event.preventDefault(); document.getElementById('campaign-delete-form').submit();"><i
              class="fas fa-trash-alt"></i></a>
          <form id="campaign-delete-form" action="{{route('campaign.destroy',[$campaign->cid])}}" method="POST"
            style="display: none;">
            {{ method_field('DELETE') }} {{ csrf_field() }}
          </form>
          @endif
          <!-- show DELETE option for admin ends-->
        </div>
        @endif
        <!-- show EDIT option for valid user / admin -->
        @endif
        <!-- check login ends -->
        <a href="{{route('campaign.show',[$campaign->c_url])}}"><img class="card-img-top"
            src="/storage/campaign_images/{{$campaign->c_image}}"></a>
        <h5 class="card-title p-2 mb-0 text-info">{{$campaign->title}}</h5>
        <blockquote class="blockquote mb-0 pt-0 card-body">
          <p>{{$campaign->c_desc}}</p>
          <footer class="blockquote-footer">
            <small class="text-muted"><cite title="{{$campaign->user->name}}">{{$campaign->user->email}}</cite>
            </small>
            <p class="card-text"><small class="text-muted">Finish on : {{$campaign->ends}}</small></p>
          </footer>
        </blockquote>
        <ul class="list-group list-group-flush">
          <li
            class="list-group-item @if ($campaign->c_status == 'active') {{'text-success'}}@else{{'text-danger'}}@endif">
            Status : {{$campaign->c_status}}
          </li>
          <li class="list-group-item">Duration : {{$campaign->duration}} days</li>
          <li class="list-group-item">Budget : {{$campaign->c_budget}}$</li>
          <li class="list-group-item">Donated : {{$campaign->c_balance}}$ @if ($campaign->c_status == 'active') <a
              href="#" class="btn btn-outline-danger ml-5">Donate now!! <i
                class="fas fa-heart text-warning"></i></a>@endif</li>
        </ul>
      </div> @endforeach
    </div>
    @else
    <p>No campaigns found!!</p>
    @endif
    <!-- card columns ends -->

  </div> {{$campaigns->links()}}
  <!-- row ends -->
</div>
@endsection