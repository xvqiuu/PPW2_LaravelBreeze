<x-app-layout>
{{-- @extends('layouts.master') --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">

    <link href="{{ asset('dist/css/lightbox.min.css')}}" rel="stylesheet">

</head>

    <style>
            .rating-container {
            text-align: center;
            }

            .rating-stars {
            font-size: 2em;
            cursor: pointer;
            }

            .star {
            color: #ccc;
            transition: color 0.3s;
            }

            .star:hover,
            .star.active {
            color: #ffcc00;
            }
    </style>

<body style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">

    {{-- @section('content') --}}
    <x-slot name="header">
        <h2 class="font-semibold font-sans text-center text-xl text-gray-800 dark:text-gray-200 leading-tight"
        style="font-weight: bold; color: #04364A;">
            {{ __('Detail Buku') }}
        </h2>
    </x-slot>

    <div class="container mt-5 p-4 rounded-lg shadow-md" style="background-color: #0D617D;">
    <form method="post" action="{{ route('buku.rating', ['id' => $buku->id]) }}" enctype="multipart/form-data">
        @csrf
        <table class="table table-bordered" style="font-weight:bold; font-size:large; color:white;">
            <tr>
                <td><label for="judul">Judul</label></td>
                <td><input type="text" name="judul" value="{{ $buku->judul }}"  class="form-control" style="color:black;" disabled></td>
            </tr>
            <tr>
                <td><label for="penulis">Penulis</label></td>
                <td><input type="text" name="penulis" value="{{ $buku->penulis }}" class="form-control" style="color:black;" disabled></td>
            </tr>
            <tr>
                <td><label for="harga">Harga</label></td>
                <td><input type="text" name="harga" value="{{ $buku->harga }}"  class="form-control" placeholder=" " disabled></td>
            </tr>
            <tr>
                <td><label for="tgl_terbit">Tanggal Terbit</label></td>
                <td><input type="date" id="tgl_terbit" name="tgl_terbit" value="{{ $buku->tgl_terbit }}" class="date form-control" placeholder="dd/mm/yyyy" disabled></td>
            </tr>
            <tr >
                <td><label for="thumbnail">Thumbnail</label></td>
                <td>
                    @if ($buku -> filepath)
                        <div class="relative">
                            <br>
                            <img class="h-30 w-30 object-cover object-center" src="{{ asset($buku -> filepath) }}" alt=" "/>
                        </div>
                    @endif
                </td>
            </tr>
            <tr>
                <td><label for="gallery">Gallery</label></td>
                <td><div class="mt-2" id="fileinput_wrapper"></div>

                    <div class="gallery_items">
                    @foreach($buku->galleries()->get() as $gallery)
                    <div class="gallery_item">
                        <a href ="{{ asset('storage/uploads/'.$gallery -> foto) }}"
                            data-lightbox ="image-1" data-title="{{ $gallery -> keterangan}}">
                            <img
                            class="object-cover object-center"
                            src="{{ asset($gallery->path) }}"
                            alt=""
                            width="300"
                            />
                        </a>
                    </div>
                    @endforeach
                </div>
                </td>

            </tr>

            <tr>
                <!-- Fitur Rating -->
                <td><label for="rating">Rating</label></td>
                <td><div class="rating-stars" id="stars-container">
                    <span class="star" onclick="rate(1)">&#9733;</span>
                    <span class="star" onclick="rate(2)">&#9733;</span>
                    <span class="star" onclick="rate(3)">&#9733;</span>
                    <span class="star" onclick="rate(4)">&#9733;</span>
                    <span class="star" onclick="rate(5)">&#9733;</span>
                </div>
                <p id="rating-value">Rating: <span id="current-rating">0</span></p>
                <input type="hidden" name="currentRating" id="inputCurrentRating" value="0">
                </td>
            </tr>

            <tr>
                <td align="right" colspan="2">
                    <a href="{{ route('buku.addToFavourite', $buku->id) }}" class="btn btn-secondary" style="background-color:#04364A;color:white;">Tambah Ke Favorit </a>
                    <button type="submit" class="btn" style="background-color:#04364A; color: white;">Simpan</button>
                    <a href="/buku" class="btn btn-secondary" style="background-color:#04364A;color:white;">Kembali ke Daftar Buku</a>
                </td>
            </tr>

        </table>
    </form>
    {{-- @endsection --}}
    </div>
    <br>

    <script src="{{ asset('dist/js/lightbox-plus-jquery.min.js') }}"> </script>
    <script>
        let currentRating = 0;

        function rate(value) {
            currentRating = value;
            updateRatingDisplay();
        }

        function updateRatingDisplay() {
            const starsContainer = document.getElementById('stars-container');
            const ratingValue = document.getElementById('rating-value');
            const currentRatingElement = document.getElementById('current-rating');
            const inputCurrentRating = document.getElementById('inputCurrentRating')

            for (let i = 1; i <= 5; i++) {
                const star = starsContainer.children[i - 1];
                star.classList.remove('active');
                if (i <= currentRating) {
                star.classList.add('active');
                }
            }

            currentRatingElement.innerText = currentRating;
            ratingValue.innerText = `Rating: ${currentRating}`;

            inputCurrentRating.value = currentRating;
        }
    </script>

</body>
</html>
</x-app-layout>

