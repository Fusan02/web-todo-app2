@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="my-5 text-center header-green">タスク一覧</h2>

        <div class="text-end">
            <a href="{{ route('todo.index', ['done' => true]) }}" class="pe-3 text-decoration-none text-black">
                <strong>
                    完了リスト
                </strong>
            </a>
            |
            <a href="{{ route('todo.index') }}" class="ps-3 pe-3 text-decoration-none text-black">
                <strong>
                    未完了リスト
                </strong>
            </a>
            <a href="{{ route('todo.create') }}" class="btn btn-primary my-3 btn-green">
                <i class="fa-solid fa-circle-plus pe-2"></i>
                <strong>
                    新規登録
                </strong>
            </a>
        </div>

        <div class="row">
            @foreach($todos as $todo)
                <div class="mx-auto">
                    <div class="card mb-3">
                        <div class="card-header text-end">
                            <small>
                                {{ \Carbon\Carbon::parse($todo->created_at)->timezone('Asia/Tokyo')->format('Y/m/d H:i:s') }}
                            </small>
                        </div>
                        <div class="card-body">
                            {{ $todo->title }}
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                {{-- Edit Buttion --}}
                                <a href="{{ route('todo.edit', $todo->id) }}" class="btn btn-orange">
                                    <i class="fa-solid fa-pen pe-2"></i>編集する
                                </a>

                                {{-- Done/UnDone Button --}}
                                @if($todo->is_done === false)
                                    <form method="POST" action="{{ route('todo.done', $todo->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-blue">
                                            <i class="fa-regular fa-circle-check pe-2"></i>
                                            完了！
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('todo.undone', $todo->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-blue">
                                            <i class="fa-solid fa-circle-xmark pe-2"></i>
                                            未完了に戻す！
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>                 
@endsection       