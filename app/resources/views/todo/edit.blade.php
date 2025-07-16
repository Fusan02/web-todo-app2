@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="my-5 text-center header-green">タスク編集</h2>

        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                {{-- バリデーションエラー部分テンプレート --}}
                @include('layouts.errors')

                {{-- 更新フォーム --}}
                <form method="POST" action="{{ route('todo.update', $todo->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="my-3">
                        <label for="title">Title:</label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            value="{{ old('title', $todo->title) }}"
                            class="form-control"
                            placeholder="牛乳を買う">
                    </div>

                    <div>
                        <button type="submit" class="btn btn-green px-4">
                            更新する
                        </button>
                    </div>
                </form>

                {{-- 削除フォーム --}}
                <form method="POST" action="{{ route('todo.destroy', $todo->id) }}" class="mt-3">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-blue px-4">
                        削除する
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection