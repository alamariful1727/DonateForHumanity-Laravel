@extends('layouts.app')




















@section('content')
@include('inc.msg')
<style>
    body {
        background: linear-gradient(to right, #30CFD0 0%, #330867 100%);
    }
</style>
<div class="container">
    <h1 class="text-center head-text">Profile</h1>
    <hr class="head-hr">

    <!-- row starts -->
    <div class="row">
        <div class="col-lg-5 col-md-12 mt-3">

            <!--Section: Basic Info-->
            <section class="card card-cascade card-avatar mb-4">
                <div class="mt-2">
                    <div class="d-flex justify-content-center h-100">
                        <div class="image_outer_container">
                            @if (Auth::check() && Auth::user()->id == $user->id)
                            <div class="green_icon"></div>
                            @endif
                            <div class="image_inner_container">
                                <img class="img-fluid" src="/storage/user_images/{{$user->image}}">
                            </div>
                        </div>
                    </div>
                </div>
                <!--Card content-->
                <div class="card-body">
                    <!--Title-->
                    <h4 class="card-title">Hi, I'm <strong style="text-transform: capitalize;">{{$user->name}}</strong>
                    </h4>
                    <hr class="my-3">
                    <!-- Email -->
                    <h6><i class="fas fa-envelope mr-2"></i>Email</h6>
                    <p class="text-muted">{{$user->email}}</p>
                    <!-- Member Since -->
                    <h6><i class="fas fa-user mr-2"></i>Member Since</h6>
                    <p class="text-muted">@php $date= explode(" ",$user->created_at); echo $date[0];@endphp
                    </p>
                    <hr class="my-3">
                    <!-- description -->
                    <h6><i class="fas fa-address-card mr-2"></i>Description</h6>
                    <p class="text-muted">{{$user->description}}</p>
                    {{--URL --}}
                    <label for="basic-url">Your profile URL</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon3">https://ocr.com/</span>
                        </div>
                        <input type="text" readonly value='{{$user->url}}' class="form-control" id="basic-url"
                            aria-describedby="basic-addon3">
                    </div>
                    <!-- edit btn -->
                    @if (Auth::check() && Auth::user()->id == $user->id)
                    <a class="btn btn-info btn-md" href="{{route('dashboard.edit',[$user->id])}}" role="button"
                        data-toggle="">Edit profile<i class="fas fa-pencil-alt ml-2"></i></a> @endif

                </div>

            </section>
            <!--Section: Basic Info ENDS-->
            <!-- Section: balance -->
            @if (Auth::check() && Auth::user()->id == $user->id)
            <section class="card mb-4">
                <div class="card-body text-center">
                    <h5>
                        <strong><i class="fas fa-coins"></i> Balance</strong>
                    </h5>
                    <h4>{{$user->balance}}</h4>
                    <a class="btn btn-success btn-md" href="{{route('dashboard.recharge')}}" role="button"
                        data-toggle="">Recharge</a>
                </div>
            </section>
            @endif
            <!-- Section: balance ends-->

        </div>
        <!-- Section: left ends-->

        <div class="col-lg-7 col-md-12 mt-3">
            <!--Section: campaign history-->
            <section class="card mb-4">
                <div class="card-body text-center">
                    <h5>
                        <strong>campaign history</strong>
                    </h5>
                    @if (count($user->campaigns)>0)
                    <table class="table table-striped table-dark table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1;@endphp
                            @foreach ($user->campaigns as $campaign)
                            <tr>
                                <td scope="row">{{$i++}}</td>
                                <td>{{$campaign->title}}</td>
                                <td>{{$campaign->c_status}}</td>
                                <td><a href="{{route('campaign.show',[$campaign->c_url])}}"
                                        class="btn btn-info">view</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <small>No campaign has been created yet!!</small>
                    @endif
                </div>
            </section>
            <!--Section: campaign history ends-->
            <!--Section: Donation history-->
            <section class="card mb-4">
                <div class="card-body text-center">
                    <h5>
                        <strong>Donation history</strong>
                    </h5>
                    @if (count($donations)>0)
                    <table class="table table-striped table-dark table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No.</th>
                                <th>Title</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i=1;@endphp
                            @foreach ($donations as $donation)
                            <tr>
                                <td scope="row">{{$i++}}</td>
                                <td><a href="{{route('campaign.show',[$donation->c_url])}}"
                                        class="text-decoration-none text-info">{{$donation->title}}</a></td>
                                <td>{{$donation->d_amount}}</td>
                                <td>{{$donation->d_created_at}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <small>No contributions yet!!</small>
                    @endif
                </div>
            </section>
            <!--Section: Donation history ends-->
        </div>
    </div>
    <!-- row ends -->
</div>
@endsection