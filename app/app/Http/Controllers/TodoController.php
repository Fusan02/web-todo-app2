<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TodoController extends Controller
{
    /**
     * TodoControllerの認証を有効にする
     * middleware('auth')を指定することで、認証が必要なコントローラーになる
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ログインしているユーザーのTodoを表示する
     */
    public function index(Request $request)
    {
        // DoneのTodoを表示するかどうか(Getパラメーターで判定)
        if ($request->has('done')) {
            //DoneのTodoを作成日順で表示する
            $todos = TodoItem::where(['user_id' => Auth::id(), 'is_done' => true])
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            //UndoneのTodoを作成日順で表示する
            $todos = TodoItem::where(['user_id' => Auth::id(), 'is_done' => false])
                ->orderBy('created_at', 'desc')
                ->get();
        }

        // compact関数を使うと、変数を配列にまとめて渡せる
        return view('todo.index', compact('todos'));
    }

    /**
     * Todo新規作成画面
     */
    public function create()
    {
        return view('todo.create');
    }

    /**
     * Todoを作成する
     */
    public function store(Request $request)
    {
        // バリデーション
        $request->validate(['title' => 'required|max:255',]);

        // Todoを作成する
        // DB上ではis_doneはデフォルトでfalseだが、明示的にfalseを指定する
        // user_idは、Auth::id()でログインしているユーザーのIDを取得できる
        TodoItem::create(
            [
                'user_id' => Auth::id(),
                'title' => $request->title,
                'is_done' => false,
            ]
        );
        return redirect()->route('todo.index');
    }

    /**
     * Todoの表示
     */
    public function show($id)
    {
        $todo = TodoItem::find($id);

        //compact関数で変数を配列にまとめて渡す
        return view('todo.show', compact('todo'));
    }

    /**
     * Todoの編集
     */
    public function edit($id)
    {
        $todo = TodoItem::find($id);

        return view('todo.edit', compact('todo'));
    }

    /**
     * Todoの更新
     */
    public function update($id, Request $request)
    {
        // バリデーション
        $request->validate([
            'title' => 'required|max:255',
        ]);

        // 必要な項目だけを書き換えて保存する(*1)
        $todo = TodoItem::find($id);
        $todo->title = $request->title;
        $todo->save();

        // route()で指定したURLにリダイレクト
        return redirect()->route('todo.index');
    }

    public function destroy($id)
    {
        TodoItem::find($id)->delete();

        return redirect()->route('todo.index');
    }

    /**
     * TodoをDoneにする
     */
    public function done($id)
    {
        // updateメソッドを使うと、指定した項目だけを更新できる
        // 今回は、is_doneだけを更新する。
        // *1とはまた別の更新方法なとこもポイント。同じ方法でも更新可能。
        TodoItem::find($id)->update(['is_done' => true]);

        return redirect()->route('todo.index');
    }

    /**
     * TodoをUnDoneにする
     */
    public function undone($id)
    {
        TodoItem::find($id)->update(['is_done' => false]);

        return redirect()->route('todo.index', ['done' => true]);
    }
}
