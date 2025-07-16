@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="my-5 text-center header-green">タスク登録</h2>

        <div class="row">
            <div class="col-12 col-md-8 mx-auto">
                {{-- バリデーションエラー部分テンプレート --}}
                @include('layouts.errors')
                <form method="POST" action="{{ route('todo.store') }}">
                    @csrf

                    <div class="my-3">
                        <input
                            type="text"
                            name="title"
                            value=''
                            class="form-control form-control-lg"
                            placeholder="例) 再配達を頼む"
                        >
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-green px-4">
                            登録する
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

