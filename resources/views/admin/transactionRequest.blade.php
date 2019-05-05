@extends('layouts.admin')
@section('content')
@include('inc.msg')

<!-- Breadcrumb-->
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Transaction requests</li>
        </ul>
    </div>
</div>
<script>
    // var i = 0,j=0,action=false;
    // function setReq(item,cid) {
    //     var changestatus = item.value;
    //     console.log(changestatus,cid);
    //     if(action){
    //         i=0;
    //         window.location.href = "/admin/campaign/"+cid+"/"+changestatus;
    //     }
    // }
</script>
<section class="">
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h3 display text-center">Campaign requests</h1>
        </header>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h3 class="text-center my-2">Total Campaign: <span
                                    id="total-req">{{count($requests)}}</span></h3>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Requested by</th>
                                        <th>Requested at</th>
                                        <th>Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($requests)>0) @foreach ($requests as $req)
                                    <tr>
                                        <th scope="row">{{$req->tid}}</th>
                                        <td>{{$req->user->email}}</td>
                                        <td>{{$req->t_created_at}}</td>
                                        <td>{{$req->amount}}</td>
                                        <td><a class="btn btn-success"
                                                href="{{route('admin.rechargeAccept',[$req->tid])}}"
                                                role="button">Accept</a>
                                        <td>
                                    </tr>
                                    @endforeach @else
                                    <p>No requests found!!</p>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .pagination {
        justify-content: center;
    }
</style>
<script>
    action=true;
</script>
@endsection