@extends('admin/admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style type="text/css">
    .bootstrap-tagsinput .tag{
        margin-right: 2px;
        color: #b70000;
        font-weight: 700px;
    } 
</style>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add blog page</h4><br>

                            <form method="post" action="{{ route('store.blog') }}" enctype="multipart/form-data">
                            @csrf

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog category name</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" name="blog_category_id" aria-label="Default select example">
                                            <option selected="">Open this select menu</option>

                                            @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->blog_category }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog title</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="blog_title" type="text" id="example-text-input">
                                        @error('blog_title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog tag</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="blog_tags" value="home, tech" type="text" data-role="tagsinput">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog description</label>
                                    <div class="col-sm-10">
                                        <textarea id="elm1" name="blog_description"></textarea>
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog image</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="blog_image" type="file" id="image">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <img id="showImage" class="rounded avatar-lg" src="{{ url('upload/no_image.jpg') }}" alt="Card image cap">
                                    </div>
                                </div>
                                <!-- end row -->
                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Insert blog data">
                            </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>


    
@endsection