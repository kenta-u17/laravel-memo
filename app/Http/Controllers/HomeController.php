<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Memo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //ここでメモを取得
        $memos = Memo::select('memos.*')
            ->where('user_id', '=', \Auth::id())
            ->whereNull('deleted_at')
            ->orderBy('updated_at', 'DESC') // ASC=小さい順、DESC=大きい順
            ->get();

        return view('create', compact('memos'));
    }

    public function store(Request $request)
    {
        $posts = $request->all();
        // dump die略　→ メソッドの引数の値を取った値を展開して止める　→ データ確認

        Memo::insert(['content' => $posts['content'], 'user_id' => \Auth::id()]);

        return redirect( route('home') );

    }
}
