@extends('layouts.admin')











@section('content')
    @include('inc.msg')

<!-- Breadcrumb-->
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Campaign requests</li>
        </ul>
    </div>
</div>
<script>
    var i = 0,j=0,action=false;
    function setReq(item,cid) {
        var changestatus = item.value;
        console.log(changestatus,cid);
        if(action){
            i=0;
            window.location.href = "/admin/campaign/"+cid+"/"+changestatus;
        }
    }
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
                        <!-- Search bar -->
                        <div class="form-group">
                            <label for="status">Choose request type: </label>
                            <select class="form-control-sm" name="status" id="status"
                                onchange="event.preventDefault(); j++; getReq(this);">
                                <option disabled selected>Select request</option>
                                <option value="pending">Pending</option>
                                <option value="active">Active</option>
                                <option value="finish">Finish</option>
                                <option value="success">Success</option>
                            </select>
                            <script type="text/javascript">
                                function getReq(item) {
                                    var status = item.value;
                                    console.log(status);
                                    window.location.href = "/admin/campaign-request/"+status;
                                }
                            </script>
                        </div>
                        <!-- Searched data  -->
                        <div class="table-responsive">
                            <h3 class="text-center my-2">Total Campaign: <span
                                    id="total-req">{{count($requests)}}</span></h3>
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Creator</th>
                                        <th>Created at</th>
                                        <th>Start</th>
                                        <th>End</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($requests)>0) @foreach ($requests as $req)
                                    <tr>
                                        <th scope="row">{{$req->cid}}</th>
                                        <td>{{$req->title}}</td>
                                        <td>{{$req->user->email}}</td>
                                        <td>{{$req->c_created_at}}</td>
                                        <td>{{$req->starts}}</td>
                                        <td>{{$req->ends}}</td>
                                        <td>
                                            <select
                                                class="form-control-sm @if ($req->c_status == 'pending') {{'text-danger'}} @endif @if ($req->c_status == 'active'){{'text-success'}}@endif @if ($req->c_status == 'finish'){{'text-warning'}} @endif @if ($req->c_status == 'success') {{'text-success'}}@endif"
                                                name="changestatus" id="c{{$req->cid}}"
                                                onchange="event.preventDefault(); i++;  setReq(this,'{{$req->cid}}');">
                                                <option class="text-danger" value="pending">Pending</option>
                                                <option class="text-success" value="active">Active</option>
                                                <option class="text-warning" value="finish">Finish</option>
                                                <option class="text-success" value="success">Success</option>
                                            </select>
                                            <script>
                                                if (i==0) {
                                                    $("#c{{$req->cid}}").val("{{$req->c_status}}").change();
                                                    i=0;
                                                }
                                            </script>
                                        </td>
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