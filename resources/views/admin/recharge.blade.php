@extends('layouts.admin')










@section('content')
@include('inc.msg')
<!-- Breadcrumb-->
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Recharge balance</li>
        </ul>
    </div>
</div>
<section class="">
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h3 display text-center">Rechage Balance</h1>
        </header>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="email">Search user:</label>
                                <input type="email" name="email" value="{{old('email')}}"
                                    class="form-control awesomplete" list="mylist" id="email" placeholder="by email">
                                <datalist id="mylist">
                                    @if (count($users)>0)
                                    @foreach ($users as $user)
                                    <option>{{$user->email}}</option>
                                    @endforeach
                                    @endif
                                </datalist>
                            </div>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="amount">Amount</span>
                                </div>
                                <input type="number" required name="amount" class="form-control"
                                    placeholder="Round amount in Dollar." aria-label="amount" aria-describedby="amount"
                                    value="{{old('amount')}}">
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-info mx-auto d-block mt-4">Recharge</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection