@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="my-4">Dashboard</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tambah Artikel -->
    <a href="{{ route('article.create') }}" class="btn btn-primary mb-3">Tambah Artikel</a>

    <!-- Tabel Artikel -->
    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Gambar</th>
                <th>Rating</th> <!-- Kolom Rating -->
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articles as $article)
                <tr>
                    <td>{{ $article->judul }}</td>
                    <td>{{ $article->deskripsi }}</td>
                    <td><img src="{{ asset('storage/' . $article->gambar) }}" width="100"></td>

                    <!-- Tampilkan Rating Bintang -->
                    <td>
                        @php
                            $averageRating = $article->ratings->avg('rating'); // Menghitung rata-rata rating
                            $fullStars = floor($averageRating); // Bintang penuh
                            $halfStar = $averageRating - $fullStars >= 0.5 ? true : false; // Cek apakah ada bintang setengah
                        @endphp

                        <span class="text-warning">
                            @for ($i = 1; $i <= $fullStars; $i++)
                                ★
                            @endfor

                            @if ($halfStar)
                                ✰
                            @endif

                            @for ($i = $fullStars + $halfStar; $i < 5; $i++)
                                ☆
                            @endfor
                        </span>
                    </td>

                    <td>
                        <a href="{{ route('article.edit', $article->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('article.destroy', $article->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">Delete</button>
                        </form>
                    </td>                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection