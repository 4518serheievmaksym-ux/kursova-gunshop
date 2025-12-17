@extends('layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h3 class="text-white text-uppercase border-start border-4 border-warning ps-3 mb-4">Редагування: {{ $product->name }}</h3>
            
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="card bg-dark border-secondary p-4 shadow-lg">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="text-secondary text-uppercase small fw-bold mb-2">Назва моделі</label>
                    <input type="text" name="name" value="{{ $product->name }}" class="form-control bg-black text-white border-secondary rounded-0" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-secondary text-uppercase small fw-bold mb-2">Ціна (грн)</label>
                        <input type="number" step="0.01" name="price" value="{{ $product->price }}" class="form-control bg-black text-white border-secondary rounded-0" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-secondary text-uppercase small fw-bold mb-2">Тип озброєння</label>
                        <select name="category_id" class="form-select bg-black text-white border-secondary rounded-0" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="text-secondary text-uppercase small fw-bold mb-2">Опис</label>
                    <textarea name="description" rows="5" class="form-control bg-black text-white border-secondary rounded-0" required>{{ $product->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="text-secondary text-uppercase small fw-bold mb-2">Зображення</label>
                    @if($product->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $product->image) }}" height="100" class="border border-secondary">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control bg-black text-white border-secondary rounded-0">
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.index') }}" class="btn btn-outline-light rounded-0 px-4 text-uppercase">Скасувати</a>
                    <button type="submit" class="btn btn-warning fw-bold text-uppercase rounded-0 px-5">Оновити дані</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection