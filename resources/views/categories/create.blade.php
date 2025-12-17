@extends('layout')
@section('content')
<div class="container py-5" style="max-width: 600px;">
    <h3 class="text-white text-uppercase mb-4">Створення категорії</h3>
    <form action="{{ route('categories.store') }}" method="POST" class="card bg-dark border-secondary p-4">
        @csrf
        <div class="mb-3">
            <label class="text-secondary text-uppercase small fw-bold mb-2">Назва типу</label>
            <input type="text" name="name" class="form-control bg-black text-white border-secondary rounded-0" required>
        </div>
        <button type="submit" class="btn btn-warning fw-bold text-uppercase rounded-0 w-100">Зберегти</button>
    </form>
</div>
@endsection