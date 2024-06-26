@extends('admin/admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add blog category page</h4><br>

                            <form method="post" id="myForm" action="{{ route('store.blog.category') }}">
                            @csrf

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Blog category name</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" name="blog_category" type="text" id="example-text-input">
                                    </div>
                                </div>
                                <!-- end row -->

                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Insert blog category">
                            </form>
                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#myForm').validate({
            rules: {
                blog_category: {
                    required: true, 
                },
            },
            messages: {
                blog_category: {
                    required: 'Please enter blog category',
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element){
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            hightlight: function(element, errorClass, validClass){
                ($element).addClass('is-invalid');
            },
            unhightlight: function(element, errorClass, validClass){
                ($element).removeClass('is-invalid');
            },
        });
    });
</script>
    
@endsection