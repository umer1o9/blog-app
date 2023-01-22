<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::where('status',1)->get();

        return view('blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $blog = new Blog();
        $blog->title = $request->title;
        $blog->read_time = $request->read_time;
        $blog->meta_data = $request->meta_data;
        $blog->description = $request->description;
        if (isset($request->image)){
            $imageName = time().'.'.$request->image->extension();

            // Public Folder
            $request->image->move(public_path('images'), $imageName);
            $blog->image = $imageName;
        }
        if (isset($request->alt_image)){
            $imageName = time().'.'.$request->alt_image->extension();

            // Public Folder
            $request->alt_image->move(public_path('images'), $imageName);
            $blog->alt_image = $imageName;
        }
        if (isset($request->status)){
            $blog->status = 1;
        }
        if (isset($request->is_featured)){
            $blog->is_featured = 1;
        }
        $blog->save();
        toastr()->success('Blog Created Successfully');
        DB::commit();
        return response()->json(['code'=> 200, 'status' => true, 'message' => 'Blog Created Successfully']);
        }
        catch (\Exception $ex) {
            toastr()->error($ex->getMessage());
            return response()->json(['code' => $ex->getCode(), 'status' => false, 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::find($id);
        return view('blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            DB::beginTransaction();
            $blog = Blog::find($id);
            $blog->title = $request->title;
            $blog->read_time = $request->read_time;
            $blog->meta_data = $request->meta_data;
            $blog->description = $request->description;
            if (isset($request->image)){
                $imageName = time().'.'.$request->image->extension();

                // Public Folder
                $request->image->move(public_path('images'), $imageName);
                $blog->image = $imageName;
            }
            if (isset($request->alt_image)){
                $imageName = time().'.'.$request->alt_image->extension();

                // Public Folder
                $request->alt_image->move(public_path('images'), $imageName);
                $blog->alt_image = $imageName;
            }
            if (isset($request->status)){
                $blog->status = 1;
            }
            if (isset($request->is_featured)){
                $blog->is_featured = 1;
            }
            $blog->save();
            toastr()->success('Blog Created Successfully');
            DB::commit();
            return response()->json(['code'=> 200, 'status' => true, 'message' => 'Blog Created Successfully']);
        }
        catch (\Exception $ex) {
            toastr()->error($ex->getMessage());
            return response()->json(['code' => $ex->getCode(), 'status' => false, 'message' => $ex->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        //
    }


    /**
     * APIS FOR BLOG
     */
    public function get_blogs(Request $request){

        $blogs = Blog::where('status', 1)->orderBy('id', 'DESC');
        $is_featured = $request->get('is_featured');
        if ($is_featured){
            $blogs = $blogs->where('is_featured', 1);
        }
        $blogs = $blogs->get();
        $base_url = $_SERVER['SERVER_NAME'] . '/images/';
        return response()->json(['code' => 200, 'status' => true, 'message' => '', 'data' => ['blogs' => $blogs, 'base_url' => $base_url]]);
    }
}
