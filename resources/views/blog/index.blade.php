@extends('layouts.layout')



@section('content')

    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Blog
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Blog</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Blog</h3>
                            <a href="{{ route('admin.blog.create') }}" class="btn btn-success" style="float: right;margin: 10px">Create</a>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Read Time</th>
                                    <th>Meta Data</th>
                                    <th>image</th>
                                    <th>Alt Image</th>
                                    <th>status</th>
                                    <th>Featured</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($blogs as $key => $blog)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $blog->title ?? '-'  }}</td>
                                        <td>{{ $blog->read_time ?? '-'  }}</td>
                                        <td>{{ $blog->meta_data ?? '-'  }}</td>
                                        <td>
                                            <img src="/images/{{$blog->image}}" style="width: 80px; height: 80px;border-radius: 50%">
                                        </td>
                                        <td>
                                            <img src="/images/{{$blog->alt_image}}" style="width: 80px; height: 80px;border-radius: 50%">

                                        </td>
                                        <td>{{ $blog->status ?? '-'  }}</td>
                                        <td>{{ $blog->is_featured ?? '-'  }}</td>
                                        <td>
                                            <a href="{{ route('admin.blog.edit', $blog->id)  }}" class="btn btn-primary btn-sm">Edit</a>
                                            <a href="{{ route('admin.blog.delete', $blog->id)  }}" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>

        </section>
    </aside>
@endsection

@section('script')
    <script type="text/javascript">
        $(function() {
            $("#example1").dataTable();
            $('#example2').dataTable({
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": false,
                "bSort": true,
                "bInfo": true,
                "bAutoWidth": false
            });
        });
    </script>
@endsection
