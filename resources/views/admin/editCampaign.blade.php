@extends('layouts.admin') 
@section('content')
    @include('inc.msg')
<!-- Breadcrumb-->
<div class="breadcrumb-holder">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
            <li class="breadcrumb-item active">Edit-Campaign</li>
        </ul>
    </div>
</div>
<section class="">
    <div class="container-fluid">
        <!-- Page Header-->
        <header>
            <h1 class="h3 display text-center">Details of ID: {{$campaign->id}}</h1>
        </header>
        <!-- row -->
        <div class="row">
            <div class="offset-lg-3 col-lg-6 col-md-12">
                <div class="card p-3">
                    <!-- delete btn -->
                    @if (Auth::user()->type=='admin')
                    <a class="text-danger pl-1" href="{{route('admin.deleteCampaign',[$campaign->cid])}}">Delete <i class="fas fa-trash-alt"></i></a>                    @endif
                    <!-- delete btn ends -->
                    <form method="POST" action="{{route('admin.updateCampaign',[$campaign->cid])}}" enctype="multipart/form-data">
                        <!-- title -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="title">Title</span>
                            </div>
                            <input type="text" required name="title" class="form-control" placeholder="Eg. Health and care" aria-label="title" aria-describedby="title"
                                value="@if (old('title')!='') {{old('title')}} @else {{$campaign->title}} @endif">
                        </div>
                        <!-- title error -->
                        @if ($errors->has('title'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span> @endif
                        <!-- title error ends -->
                        <!-- c_desc -->
                        <div class="form-group">
                            <label for="c_desc">Description</label>
                            <!-- c_desc check -->
                            @if (old('c_desc')!='')
                            <textarea name="c_desc" required class="form-control" placeholder="who you are!!" id="c_desc" rows="3">{{old('c_desc')}}</textarea>
                            <!-- c_desc intially -->
                            @else
                            <textarea name="c_desc" class="form-control" placeholder="who you are!!" id="c_desc" rows="3">{{$campaign->c_desc}}</textarea>@endif
                        </div>
                        <!-- c_desc error -->
                        @if ($errors->has('c_desc'))
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('c_desc') }}</strong>
                        </span> @endif
                        <!-- c_desc error ends -->
                        <!-- budget&duration -->
                        <div class="form-row">
                            <div class="col form-group">
                                <label for="budget">Budget</label>
                                <input type="number" id="budget" required class="form-control" name="c_budget" placeholder="Enter your budget">

                                <!-- c_budget error -->
                                @if ($errors->has('c_budget'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('c_budget') }}</strong>
                                </span> @endif
                                <!-- c_budget error ends -->
                            </div>
                            <div class="col form-group">
                                <label for="duration">Duration</label>
                                <input type="number" id="duration" required class="form-control" name="duration" placeholder="campaign duration">
                                <!-- duration error -->
                                @if ($errors->has('duration'))
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $errors->first('duration') }}</strong>
                                </span> @endif
                                <!-- duration error ends -->
                            </div>
                        </div>
                        <!-- budget&duration error ends -->
                        <!-- file -->
                        <div class="form-group">
                            <div class="custom-file">
                                <input name="cover_image" type="file" onchange="readURL(this);" class="custom-file-input" id="cover_image" aria-describedby="inputGroupFileAddon04"
                                    accept="image/*">
                                <label class="custom-file-label" for="cover_image">Choose photo..</label>
                            </div>
                            <!-- cover_image error -->
                            @if ($errors->has('cover_image'))
                            <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $errors->first('cover_image') }}</strong>
                        </span> @endif
                            <!-- cover_image error ends -->
                        </div>
                        {{ method_field('PUT') }} {{ csrf_field() }}
                        <button type="submit" class="btn btn-info mx-auto d-block mt-4">Edit</button>

                    </form>
                </div>
            </div>
        </div>
        <!-- row ends -->
    </div>
</section>

<script>
    $("#budget").val(@if (old('c_budget')!='') {{old('c_budget')}} @else {{$campaign->c_budget}} @endif);
    $("#duration").val(@if (old('duration')!='') {{old('duration')}} @else {{$campaign->duration}} @endif);
    @if (old('cover_image')=='') $('.custom-file-label').html('{{$campaign->c_image}}') @endif
    ////////////// file preview /////////////////
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
        $('.custom-file-label').html(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
    } 
    }

</script>
@endsection