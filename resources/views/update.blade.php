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

    <title>Update</title>
</head>
<body style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">

    {{-- @section('content') --}}
    <x-slot name="header">
        <h2 class="font-semibold font-sans text-center text-xl text-gray-800 dark:text-gray-200 leading-tight" 
        style="font-weight: bold; color: #04364A;">
            {{ __('Edit Buku') }}
        </h2>
    </x-slot>

    <div class="container mt-5 p-4 rounded-lg shadow-md" style="background-color: #0D617D;">
    <form method="Post" action="{{ route('buku.update', ['id' => $buku->id]) }}" class="form" enctype="multipart/form-data">
        @csrf
        <table class="table table-bordered" style="font-weight:bold; font-size:large; color:white;">
            <tr>
                <td><label for="judul">Judul</label></td>
                <td><input type="text" name="judul" value="{{ $buku->judul }}"  class="form-control" style="color:black;"></td>
            </tr>
            <tr>
                <td><label for="penulis">Penulis</label></td>
                <td><input type="text" name="penulis" value="{{ $buku->penulis }}" class="form-control" style="color:black;"></td>
            </tr>
            <tr>
                <td><label for="harga">Harga</label></td>
                <td><input type="text" name="harga" value="{{ $buku->harga }}"  class="form-control" placeholder=" "></td>
            </tr>
            <tr>
                <td><label for="tgl_terbit">Tanggal Terbit</label></td>
                <td><input type="date" id="tgl_terbit" name="tgl_terbit" value="{{ $buku->tgl_terbit }}" class="date form-control" placeholder="dd/mm/yyyy"></td>
            </tr>
            <tr >
                <td><label for="thumbnail">Thumbnail</label></td>
                <td><input type="file" id="thumbnail" name="thumbnail">
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
                    <a href="javascript:void(0);" id="tambah" onclick="addFileInput()" style="color: white;">Tambah</a>
                    <script type="text/javascript">
                        function addFileInput () {
                            var div = document.getElementById('fileinput_wrapper');
                            div.innerHTML += '<input type="file" name="gallery[]" id="gallery" class="block w-full mb-5" style="margin-bottom:5px;">';
                        };
                    </script>
                    
                    <div class="gallery_items">
                    @foreach($buku->galleries()->get() as $gallery)
                        <div class="gallery_item">
                            <img
                            class="h-50 w-50 object-cover object-center"
                            src="{{ asset($gallery->path) }}"
                            alt=""
                            width="100"
                            />
                            <a href="{{ route('buku.deleteGallery', $gallery->id) }}" 
                            class="btn btn-danger btn-sm shadow mt-2 mb-5" 
                            style="position:inherit; top: 10px; right: 10px;">
                            <i class="bi bi-x-lg"></i>Delete</a>
                        </div>
                    @endforeach
                </div>  
                </td>
                
            </tr>     
            <tr>
                <td align="right" colspan="2">
                    <!-- Tambahkan tombol "Simpan Perubahan" -->
                    <button type="submit" class="btn" style="background-color:#04364A; color: white;">Simpan Perubahan</button>
                    <a href="/buku" class="btn btn-secondary" style=" color:white;">&nbsp; Batal &nbsp;</a>
                </td>
            </tr>
            
        </table>
    </form>
    {{-- @endsection --}}
    </div>
    <br>
</body>
</html>
</x-app-layout>

