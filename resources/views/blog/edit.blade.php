@extends('layouts.layout')



@section('content')

    <aside class="right-side">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Edit Blog
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Blog</li>
                <li class="active">Edit</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Edit Blog</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form id="widget_form" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="title">Title </label>
                                            <input type="text" name="title" value="{{ $blog->title }}" class="form-control" id="title" placeholder="My Blog" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="read_time">Read Time</label>
                                            <input type="text" class="form-control" value="{{ $blog->read_time }}" name="read_time" id="read_time" placeholder="2 min" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="meta_data">Meta Data</label>
                                            <input type="text" class="form-control" name="meta_data" value="{{ $blog->meta_data }}" id="meta_data" placeholder="Enter Meta Data" required>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" name="image" id="image">
                                            <img src="/images/{{ $blog->image }}" style="width: 50px; height: 50px; border-radius: 50%" alt="Image">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="alt_image">Alt Image</label>
                                            <input type="file" name="alt_image" id="alt_image">
                                            <img src="/images/{{ $blog->alt_image }}" style="width: 50px; height: 50px; border-radius: 50%" alt="alt_image">

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="is_featured">Is Featured</label>

                                            <input type="checkbox" name="is_featured" id="is_featured" {{ $blog->is_featured ? 'checked="true"' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">is Active</label>
                                            <input type="checkbox" name="status" id="status" {{ $blog->status ? 'checked="true"' : '' }}>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" name="description" id="description" placeholder="Description for Admin Use" required>{{ $blog->description  }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div><!-- /.box -->

                </div>
            </div>

        </section>
    </aside>
@endsection

@section('script')
    <script src="{{ asset('assets/admin/js/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        $(function() {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('prompt_text');
            //bootstrap WYSIHTML5 - text editor
            $(".textarea").wysihtml5();
        });
    </script>

    <script>
        function updateUrl(){
            let name = $('#name').val();
            $('#url').val(name.toLowerCase().replaceAll(' ', '-'));
        }
        let prompt = [];
        function setPrompt(key) {
            $('#prompt_text_error').text('');
            $('#widget_field_error').text('');
            if (key == 'prompt_text'){
                let text = document.getElementById('prompt_text').value;
                if (text == ''){
                    $('#prompt_text_error').text('Text Required');
                    return false
                }
                prompt.push({
                    'text' : text,
                    'field_id': '',
                    'field_text': ''
                });
                $('#prompt_text').val('');
            }else if(key == 'widget_field'){
                let e = document.getElementById("widget_field");
                let value = e.options[e.selectedIndex].value;
                let text = e.options[e.selectedIndex].text;
                prompt.push({
                    'text' : '',
                    'field_id': value,
                    'field_text': text
                });
            }
            display_prompt();
        }
        function display_prompt(){
            let html = '';
            $('#prompt_formula').html('');

            for (const index in prompt){

                if (prompt[index].text != ''){
                    html += '<span><pre style="display: flex;justify-content: space-between">'+ prompt[index].text +'' +
                        '<span onclick=removePrompt(`'+ index +'`) style="margin-left: 4px;padding: 3px 6px;" class="btn btn-danger btn-sm" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></span></pre></span>';
                }else{
                    html += '<span> <pre style="display: flex;justify-content: space-between">[' + prompt[index].field_text + ']' +
                        '<span onclick=removePrompt(`'+ index +'`) style="float:right;padding: 3px 6px;" class="btn btn-danger btn-sm" data-toggle="tooltip" title="" data-original-title="Delete"><i class="fa fa-trash-o"></i></span></pre> </span>';
                }
            }
            $('#prompt_formula').append(html);
        }
        function removePrompt(index){
            prompt.splice(index, 1);
            display_prompt();

        }

        $('#widget_form').submit(function(e){
            e.preventDefault();
            // wellness_scoring_form
            var formData = new FormData(document.querySelector('form'));
            if (prompt.length > 0){
                formData.append('prompt', JSON.stringify(prompt));
            }
            $.ajax({
                url: '{{ route('admin.blog.update', $blog->id) }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (response) {
                    if (response.status) {
                        toastr.success(response.message);
                        window.location.href = "/admin/blog";
                    } else {
                        toastr.error(response.message);
                    }
                }, error: function (err) {
                    $.each(err.responseJSON.errors, function (key, value) {
                        toastr.error(value[0]);
                    });
                },
                timeout: 3000
            });
        });


    </script>
@endsection
