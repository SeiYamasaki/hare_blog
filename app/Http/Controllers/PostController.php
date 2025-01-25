<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //作成
        return view("posts.index");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //作成
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        //
        $post = new Post($request->all()); //ここでタイトルとボディの2つの内容が代入されているpost.phpのプロテクトの部分
        $post->user_id = $request->user()->id;

        $file = $request->file('image'); //create.blade.phpのname属性
        $post->image = date('YmdHis') . '_' . $file->getClientOriginalName();
        //Ymdは分秒なし

        // トランザクション開始
        +DB::beginTransaction();
        try {
            // 登録
            $post->save();

            // 画像アップロード ストレージクラスでpublic/images/postsにアップロードさせる｡失敗したら(！)をつける
            if (!Storage::putFileAs('images/posts', $file, $post->image)) {
                // 例外を投げてロールバックさせる
                throw new \Exception('画像ファイルの保存に失敗しました。');
            }
            // トランザクション終了(成功)
            DB::commit();
        } catch (\Exception $e) {
            // トランザクション終了(失敗)
            DB::rollback();
            return back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()
            ->route('posts.show', $post);
        //reture redirect(route("posts.show",$post));メモアプリはこの記述だがどちらでもよい
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
