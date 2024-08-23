<?php
namespace App\Http\Controllers;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\{File, Storage};

class PostController extends Controller
{
    //index function
    public function index()
    {
        return new PostResource(Post::paginate(10), 'index');
    }

    //post by id function
    public function show($id)
    {
        return new PostResource(Post::find($id), 'show');
    }

    //create post
    public function store(PostRequest $request)
    {
        $post = Post::create(array_merge(
            $request->only('Name', 'Description'),
            ['Status' => '1', 'Image' => $request->file('Image')?->store('upload/posts', 'public')]
        ));

        return new PostResource($post, 'store');
    }

    //edit post
    public function update(PostRequest $request, $id)
    {
        $post = Post::find($id) ?? null;
        if (!$post) return new PostResource(null, 'update');

        if ($request->hasFile('Image')) {
            Storage::delete($post->Image);
            $post->Image = $request->file('Image')->store('upload/posts', 'public');
        }

        $post->update($request->only('Name', 'Description', 'Status'));

        return new PostResource($post, 'update');
    }

    //delete post
    public function destroy($id)
    {
        $post = Post::find($id);
        if (!$post) {
            return response()->json(['response' => ['message' => 'Post not found.', 'status' => 404]], 404);
        }

        File::delete(public_path('storage/' . $post->Image));
        $post->delete();

        return new PostResource(null, 'destroy');
    }
}