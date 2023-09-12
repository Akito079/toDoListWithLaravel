<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{   //customer create page
    public function create()
    {
        // $posts = Post::orderby('created_at','desc')->paginate(3);
        // $posts = Post::pluck('title');     //pluck('value','key')
        // $posts = Post::select('title')->get();
        // $posts = Post::where('id','<','6')->pluck('title');
        // $posts = Post::where('id','<','10')->get()->random();
        // where is &&       orwhere is ||
        // $posts = Post::orWhere('id','<',20)->orWhere('address','pyay')->get();
        // $posts = Post::select('id', 'address', 'price')
        //     ->where('address', 'yangon')
        //     ->whereBetween('price', [3000,9000])
        //     ->orderby('price', 'desc')
        //     ->dd();
        // $posts = Post::select('title','price')->where('address','pyay')->orderby('price','asc')->get()->toArray();
        // $posts = Post::find(3);
        // $posts = Post::avg('price');
        // $posts = Post::where('address','tokyo')->exists();
        // $posts = Post::select('id','title as post_title','title')->get();

        // $posts = Post::select('address',DB::raw('COUNT(address) as address_count'),DB::raw('Sum(price) as price_total'))
        // ->groupBy('address')
        // ->get();

        // $posts = Post::get()->map(function($post){    // map and each is the same
        //     $post->title = strtoupper($post->title);
        //     $post->description = strtoupper($post->description);
        //     $post->price = $post->price * 2 ;
        //     return $post ;
        // });

        // $posts = Post::paginate(5)->through(function($post){     //we can use through when we want to use paginate
        //     $post->title = strtoupper($post->title);
        //     $post->description = strtoupper($post->descrition);
        //     $post->price = $post->price * 2 ;
        //     return $post;
        // });

        //http://127.0.0.1:8000/customer/createPage?key=codelab
        // $post = Post::where('title','like','%'.$searchKey.'%')->get()->toArray();

        // $post = Post::when(request('key'),function($p){
        //  $searchKey = request('key');
        //  $p->where('title','like','%'.$searchKey.'%');
        // })->paginate(2);
        // dd($posts->toArray());
        $posts = Post::when(request('searchKey'), function($query) {
            $key = request('searchKey');
            $query->orwhere('title','like','%'.$key.'%')->orwhere('description','like','%'.$key.'%');
        })->orderBy('created_at','desc')->paginate(3);
        return view('create',compact('posts'));
    }

    //post create

    public function postCreate(Request $request)    {
        $this->validationCheck($request);
        $data = $this->getPostData($request);
        if($request->hasFile('postImage')){
            $fileName = uniqid(). $request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public',$fileName);
            $data['image']  = $fileName;
        }
        Post::create($data);
        return redirect()->route('post#createPage')->with(['insertSuccess' => 'Postဖန်တီးမှုအောင်မြင်ပါသည်။']);
        //   return view('create');
        //    return back();
        // return redirect();                   //url
        // return redirect()->route('test');  //name
    }
    //get post data

    //post delete
    public function postDelete($id)
    {
        //first way
        // Post::where('id',$id)->delete();
        // return redirect()->route('post#createPage');
        //second way
        Post::find($id)->delete();
        return back();
    }
    //update page
    public function updatePage($id)
    {
        // $post = Post::where('id',$id)->get()->toArray();
        // $post = Post::first()->toArray();
        $post = Post::where('id', $id)->first();    //use first to get the only array when updating
        return view('update', compact('post'));
    }
    //edit page
    public function editPage($id)
    {
        $post = Post::where('id', $id)->first();
        return view('edit', compact('post'));
    }
    //update post
    public function update(Request $request)
    {
        $this->validationCheck($request);
        $id = $request->postId;
        $updateData = $this->getPostData($request); // array
        if($request->hasFile('postImage')){
            //delet old image
            $oldImageName = Post::select('image')->where('id',$request->postId)->first();
            $oldImageName = $oldImageName->image;
            if($oldImageName != null){
                Storage::delete('public/'.$oldImageName);
            }

            $fileName = uniqid(). $request->file('postImage')->getClientOriginalName();
            $request->file('postImage')->storeAs('public',$fileName);
            $updateData['image']  = $fileName;
        }
        Post::where('id', $id)->update($updateData);
        return redirect()->route('post#createPage')->with(['updateSuccess' => 'Updateအောင်မြင်ပါပြီ။']);
    }

    private function getPostData($request)
    {
        $postData = [
            'title' => $request->postTitle,
            'description' => $request->postDescription,
        ];
        $postData['price'] = $request->postPrice == null? 2000 : $request->postPrice;
        $postData['address'] = $request->postAddress == null? "Yangon" : $request->postAddress;
        $postData['rating'] = $request->postRating == null? 3 : $request->postRating ;

        return $postData;
    }
    private function validationCheck($request)
    {

        $validationRules = [
            'postTitle' => 'required|min:5|unique:posts,title,' . $request->postId,
            'postDescription' => 'required|min:5',
            'postImage' =>  'mimes:jpg,jpeg,bmp,png|file'
        ];


        $validationMessage = [
            'postTitle.required' => 'Post Title ဖြည့်စွက်ရန်လိုအပ်ပါသည်။',
            'postTitle.min' => 'အနည်းဆုံးစာလုံး5လုံးလိုအပ်သည်။',
            // 'postPrice.gte' => 'your price must be between 2000 and 50000',
            // 'postPrice.lte' => 'your price must be between 2000 and 50000',
            // 'postPrice.required' => 'you need to enter price',
            // 'postAddress.required' => 'you need to add your location',
            'postTitle.unique' => 'Post Titleတူနေပါသည်ထပ်ရေးပါ။',
            'postDescription.required' => 'Post Description ဖြည့်စွက်ရန်လိုအပ်ပါသည်။',
            // 'postRating.required' => 'You need to add rating',
            'postImage.mimes' => 'Your image must be jpg,jpeg,png type',
            'postImage.file' => 'Your image must be a file type'
        ];
        Validator::make($request->all(), $validationRules, $validationMessage)->validate();
    }
}
