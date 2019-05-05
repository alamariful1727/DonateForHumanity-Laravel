@extends('layouts.admin') 
@section('content')
    @include('inc.msg')
<!-- Breadcrumb-->
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Edit-User</li>
        </ul>
    </div>
</div>
<section class="">
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h3 display text-center">Details of ID: {{$blog->bid}}</h1>
        </header>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{route('admin.updateBlog',[$blog->bid])}}">
                            {{-- description --}}
                            <div class="form-group">
                                <label for="body">Description</label> @if (old('body')!='')
                                <textarea name="body" required class="form-control" placeholder="who you are!!" id="body" rows="3">{{old('body')}}</textarea>                                @else<textarea name="body" class="form-control" placeholder="who you are!!" id="body" rows="3">{{$blog->body}}</textarea>                                @endif
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-info mx-auto d-block mt-4">Edit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection