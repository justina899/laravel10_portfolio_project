@extends('admin/admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Blogs all</h4><br>
                </div>
            </div>
        </div>
        <!-- end page title -->
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Blogs all data</h4>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>Blog category</th>
                                    <th>Blog title</th>
                                    <th>Blog tags</th>
                                    <th>Blog image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @php($i = 1)

                                @foreach($blogs as $item)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $item['category']['blog_category'] }}</td> <!-- function 'category loaded here' -->
                                    <td>{{ $item->blog_title }}</td>
                                    <td>{{ $item->blog_tags }}</td>
                                    <td><img src="{{ asset($item->blog_image) }}" style="width: 60px; height: 50px"></td>
                                    <td>
                                        <a href="{{ route('edit.blog', $item->id) }}" class="btn btn-info sm" title="Edit data"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('delete.blog', $item->id) }}" class="btn btn-danger sm" title="Delete data" id="delete"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
</div>
                                
@endsection