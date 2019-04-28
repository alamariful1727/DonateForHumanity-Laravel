@extends('layouts.app') 
@section('content')
  @include('inc.msg')
<div class="container">
  <h1 class="text-center head-text">Users experience with us!!</h1>
  <hr class="head-hr">
  <!-- row ends -->
  <div class="row">
    @if (count($blogs)>0)
    <div class="card-columns">
      @foreach ($blogs as $blog)
      <div class="card">
        @if (Auth::check()) @if (Auth::user()->id == $blog->user->id || Auth::user()->type == 'admin')
        <div class="text-right abs-opt">
          <button type="button" data-bid="{{$blog->bid}}" onclick="getBid(this);" id="btnEdit" class="btn btn-info" data-toggle="modal"
            data-target="#editModal">
            <span><i class="fas fa-edit text-light"></i></span>
          </button>
          <button type="button" data-bid="{{$blog->bid}}" onclick="getBid(this);" id="btnDelete" class="btn btn-danger ml-1" data-toggle="modal"
            data-target="#exampleModalCenter">
            <span><i class="fas fa-trash-alt text-light"></i></span>
          </button>
        </div>
        @endif @endif @if ($blog->cover_image != '')
        <img class="card-img-top" src="/storage/blog_images/{{$blog->cover_image}}" alt="Sorry: Admin will Add a image later..">        @endif

        <blockquote class="blockquote mb-0 card-body">
          <p>{{$blog->body}}</p>
          <footer class="blockquote-footer">
            <small class="text-muted"><cite title="{{$blog->user->type}}">{{$blog->user->email}}</cite>
              </small>
            <p class="card-text"><small class="text-muted">Updated on {{$blog->blog_updated_at}}</small></p>
          </footer>
        </blockquote>
      </div>
      @endforeach
    </div>
    @else
    <p>No blogs found!!</p>
    @endif
    <!-- card columns ends -->

    <!-- edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Edit your blog here!!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="body">Blog Description</label>
              <textarea name="body" class="form-control" placeholder="Write your thoughts about us.. ^_^" id="bbody" rows="3"></textarea>
              <small id="bodyError" class="form-text text-danger"></small>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="editBlog" type="button" class="btn btn-danger">Edit</button>
          </div>
        </div>
      </div>
    </div>
    <!-- edit Modal ends -->
    <!-- Delete Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Are you sure to delete this blog ?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            Once you delete this blog, you will never get it back!!
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button id="deleteBlog" type="button" class="btn btn-danger">Delete</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Delete Modal ends -->

  </div>
  {{-- pagination --}} @if(Request::url() === 'http://onlinecarrent.com/blog') {{$blogs->links()}} @endif
  <!-- row ends -->
</div>
<script>
  // edit & delete blog [Ajax using axios]
    var blogID = null, body = null, id = null;
    function getBid(btn) {
      blogID = $(btn).data('bid');
      id = $(btn).attr('id');
      console.log(blogID, id);
      const request = async () => {
        const response = await fetch('http://onlinecarrent.com/blog/' + blogID);
        const data = await response.json();
        console.log(data.body);
        document.getElementById('bbody').value = data.body;
        // $('#bbody').ckeditor();
      }
      request();
      
    }
// editBlog
    document.getElementById('editBlog').addEventListener("click", function () {

      var blogInfo = { bid: blogID, body: document.getElementById('bbody').value };

      if (blogInfo.body.length == 0) {
        document.getElementById('bodyError').innerHTML = "Can't be empty!!";
      } else if (blogInfo.body.length > 191 ) {
        document.getElementById('bodyError').innerHTML = "Length should be between 1-191!!";
      } else {

        axios.put('http://onlinecarrent.com/blog/' + blogID, {
          body: document.getElementById('bbody').value
        })
        .then(response => {
          console.log(response);
          window.location.href = "{{route('blog.index')}}";
        })
        .catch(error => {
          console.log(error.response);
        });

      }
    });
// delete blog
    document.getElementById('deleteBlog').addEventListener("click", function () {
        axios.delete('http://onlinecarrent.com/blog/' + blogID, { data: null })
        .then(response => {
          console.log(response);
          window.location.href = "http://onlinecarrent.com/blog";
        })
        .catch(error => {
          console.log(error);
        });
    });

// dit & delete blogs ends

</script>
@endsection