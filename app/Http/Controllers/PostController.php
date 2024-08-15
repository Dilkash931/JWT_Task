<?php
namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    // Show posts
    public function index()
    {
        $posts = Post::paginate(10); // Paginate results
        return response()->json($posts);
    }

 // Store posts
public function store(StorePostRequest $request)
{
    // Save the data
    $post = new Post();
    $post->Name = $request->Name;
    $post->Description = $request->Description;
    $post->Status = $request->Status;

    // Handle the image upload
    if ($request->hasFile('Image')) {
        $image = $request->file('Image');
        $imagePath = $image->store('upload/posts', 'public'); // Store image in the public disk

        // Save the image path in the database
        $post->Image = $imagePath;
    }

    $post->save();

    return response()->json([
        'message' => 'Post has been created successfully.',
        'post' => $post
    ], 201);
}


    // Show a single post by id
    public function show($id)
    {
        $post = Post::findOrFail($id);
        return response()->json([
            'message' => 'Post founded',
            'post' => $post
        ], 201);
    }

    // Update the post
    public function update(UpdatePostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        // Handle the image upload
        if ($request->hasFile('Image')) {
            Storage::delete($post->Image);
            // Store the new image file and update the image_path field
            $imagePath = $request->file('Image')->store('upload/posts', 'public');
            $post->Image = $imagePath;
        }

        // Update post fields
        $post->Name = $request->input('Name', $post->Name);
        $post->Description = $request->input('Description', $post->Description);
        // $post->Status = $request->input('Status', $post->Status);
        $post->Status = '1';
        $post->save();

        return response()->json([
            'message' => 'Post updated successfully',
            'post' => $post,
            'status' => 200
        ]);
    }


    
  // Delete the post
public function destroy($id, Request $request)
{
    $post = Post::findOrFail($id);
    
    // Ensure the file path matches your storage setup
    $imagePath = public_path('storage/' . $post->Image);

    if (File::exists($imagePath)) {
        File::delete($imagePath);
    }

    $post->delete();

    return response()->json([
        'message' => 'Post deleted successfully',
        'post' => $post,
        'status' => 200
    ]);
}

}


   
      

      
    // public function update(Request $request, $id)
    // {
    //     // Validate the request data
    //     $validator = Validator::make($request->all(), [
    //         'Name' => 'required|string|max:255',
    //         'Description' => 'required|string',
    //         'Image' => 'sometimes|image|mimes:gif,png,jpeg,jpg|max:2048', // Image is optional
    //         'Status' => 'required|string'
    //     ]);
    
    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 400);
    //     }
    
    //     // Find the post by ID
    //     $post = Post::find($id);
    
    //     if (!$post) {
    //         return response()->json(['error' => 'Post not found'], 404);
    //     }
    
    //     // Update the data
    //     $post->Name = $request->Name;
    //     $post->Description = $request->Description;
    //     $post->Status = $request->Status;
    
    //     // Handle the image upload if present
    //     if ($request->hasFile('Image')) {
    //         // Optionally, delete the old image from storage if desired
    //         if ($post->Image) {
    //             Storage::disk('public')->delete($post->Image);
    //         }
    
    //         $image = $request->file('Image');
    //         $imagePath = $image->store('upload/posts', 'public');
    
    //         // Save the image path in the database
    //         $post->Image = $imagePath;
    //     }
    
    //     $post->save();
    
    //     return response()->json(['post' => $post], 200);
    // }
    


//     public function update(Request $request, $id)
//     {
    // // Ensure the authenticated user owns the post
        // if (auth()->user()->id !== $post->user_id) {
        //     return response()->json(['error' => 'Unauthorized','status'=>401], 401);
        // }
//         // Validate the request data
//         $validator = Validator::make($request->all(), [
//             'Name' => 'required|string',
//             'Description' => 'required|string',
//             'Image' => 'sometimes|image|mimes:gif,png,jpeg,jpg|max:2048', // Make image validation optional for update
//             'Status' => 'required|string'
//         ]);
    
//         if ($validator->passes()) {
        
    
//         // Find the post by ID
//         $post = Post::find($id);
//         // Update the post details
//         $post->Name = $request->Name;
//         $post->Description = $request->Description;
//         $post->Status = $request->Status;
    
//         // Handle the image upload if provided
//         if ($request->hasFile('Image')) {
//             // Delete the old image if exists
//             if ($post->Image) {
//                 Storage::disk('public')->delete($post->Image);
//             }
    
//             $image = $request->file('Image');
//             $imagePath = $image->store('upload/posts', 'public'); // Store image in the public disk
    
//             // Save the new image path in the database
//             $post->Image = $imagePath;
        
    
//         $post->save();
//         }
//         return response()->json(['post' => $post], 200);
    
//     }
// }


// public function update(Request $request, $id)  {

//     $post =Post::find($id);
//     $post->update($request->all());
//     return $post;
// }
    
