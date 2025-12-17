@extends('layout')

@section('content')
<div class="container py-4">
    <div class="row align-items-center mb-4">
        <div class="col-6"><h2 class="text-white text-uppercase border-start border-4 border-warning ps-3">Типи озброєння</h2></div>
        <div class="col-6 text-end">
            <a href="{{ route('categories.create') }}" class="btn btn-warning fw-bold text-uppercase rounded-0"><i class="bi bi-plus-lg"></i> Додати тип</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success bg-dark text-success border-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="card bg-dark border-secondary">
        <table class="table table-dark table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-warning text-uppercase">ID</th>
                    <th class="text-warning text-uppercase">Назва</th>
                    <th class="text-end text-warning text-uppercase">Дії</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td class="fw-bold">{{ $category->name }}</td>
                    <td class="text-end">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-light rounded-0 me-2"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger rounded-0" onclick="return confirm('Видалити категорію?')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection