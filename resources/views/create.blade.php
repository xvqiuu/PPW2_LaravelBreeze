<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">

    <title>Create</title>
</head>

<body style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">
    @if(count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold font-sans text-center text-xl text-gray-800 dark:text-gray-200 leading-tight" 
        style="font-weight: bold; color: #04364A;">
            {{ __('Tambah Buku') }}
        </h2>
    </x-slot>

<div class="container mt-5 p-4 rounded-lg shadow-md" style="background-color: #0D617D;">
    <br>
    <form method="post" action="{{ route('buku.store') }}" enctype="multipart/form-data">
        @csrf
        <table class="table table-bordered" style="font-weight:bold; font-size:large; color:white;">
            <tr>
                <td>Judul</td>
                <td><input type="text" name="judul" class="form-control"  placeholder=" "></td>
            </tr>
            <tr>
                <td>Penulis</td>
                <td><input type="text" name="penulis" class="form-control"  placeholder=" "></td>
            </tr>
            <tr>
                <td>Harga</td>
                <td><input type="text" name="harga" class="form-control"  placeholder=" "></td>
            </tr>
            <tr>
                <td>Tanggal Terbit</td>
                <td><input type="date" id="tgl_terbit" name="tgl_terbit" class="date form-control" placeholder="dd/mm/yyyy"></td>
            </tr>
            <tr >
                <td><label for="thumbnail">Thumbnail</label></td>
                <td><input type="file" id="thumbnail" name="thumbnail"></td>    
            </tr>
            <tr>
                <td><label for="gallery">Gallery</label></td>
                <td><div class="mt-2" id="fileinput_wrapper"></div>
                    <a href="javascript:void(0);" id="tambah" onclick="addFileInput()">Tambah</a>
                    <script type="text/javascript">
                        function addFileInput () {
                            var div = document.getElementById('fileinput_wrapper');
                            div.innerHTML += '<input type="file" name="gallery[]" id="gallery" class="block w-full mb-5" style="margin-bottom:5px;">';
                        };
                    </script>
                     
                </td>
                
            </tr> 
            <tr>   
                <td align="right" colspan="2">
                    <button type="submit" class="btn" style="background-color:#04364A; color: white;">Simpan</button>
                    <a href="/buku" class="btn btn-secondary" style=" color:white;">&nbsp; Batal &nbsp;</a>
                </td>
            </tr>
        </table>
    </form>
</div>
<br><br>
</body>
</html>

</x-app-layout>

