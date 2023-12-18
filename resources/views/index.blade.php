<x-app-layout>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">

    <title>Buku</title>
</head>

<body style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;">
    @if(Session::has('pesan'))
        <div class="alert alert-success">{{Session::get('pesan')}}</div>
    @endif

    <x-slot name="header">
        <h2 class="font-semibold font-sans text-center text-xl text-gray-800 dark:text-gray-200 leading-tight"
        style="font-weight: bold; color: #04364A;">
            {{ __('Daftar Buku') }}
        </h2>
    </x-slot>

    <div class="container bg-white mt-10 mb-4 p-4 rounded-lg shadow-md">
        <div class="flex justify-between items-center">
            <a href="{{ route('buku.create') }}" class="btn btn-primary"
            style="background-color: #04364A; color: white; font-weight: bold;" >Tambah Buku </i></a>

            <form action="{{ route('buku.search') }}" method="get" class="flex items-center">
                @csrf
                <input type="text" name="kata" class="form-control rounded" placeholder="Cari ....."
                style="width: 100%; display: inline; margin-top: 10px; margin-bottom: 10px; float: right;">
                <a href="{{ route('buku.search') }}" class="ml-2 btn" style="background-color: #04364A; color:white"><i class="fas fa-search"></i></a>
            </form>
        </div>

        <div>
            <a href="{{ route('buku.myfavourite') }}" class="btn btn-primary"
                style="background-color: #04364A; color: white; font-weight: bold;" > &nbsp;Buku Favorit&nbsp; </i>
            </a>
        </div>

        <div align="center"> {{ $data_buku -> links() }}</div>

        <div style="font-size:medium; font-weight: medium;">{{ "Jumlah Buku : " .$jumlah_buku ." buku"}}</div>
        <br>

<table class= "table table-bordered"  style="background-color: #0D617D; color: white;">
    <thead  class="text-center" style="background-color: #04364A;">
        <tr>
            <th>Id</th>
            <th>Thumbnail</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Harga</th>
            <th>Rating</th>
            <th>Tanggal Terbit</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody align="center">
    @foreach($data_buku as $buku)
        <tr>
            <td>{{$buku -> id}}</td>
            <td>
            @if ($buku -> filepath)
                <div class="relative">
                    <img class="h-30 w-30 object-cover object-center" src="{{ asset($buku -> filepath) }}" alt=" "/>
                </div>
            @endif
            </td>
            <td align="left">{{$buku -> judul}}</td>
            <td align="left">{{$buku -> penulis}}</td>

            <!-- number_format digunakan untuk memformat angka pada kolom harga -->
            <td>{{"Rp ".number_format($buku -> harga, 2, ',', '.')}}</td>

            <!-- menampilkan buku yang belum di rating -->
            @if($buku->rating != 0)
            <td>{{$buku->rating}}</td>
            @else
            <td>Rating is not available</td>
            @endif

            <td>{{\Carbon\Carbon::parse($buku->tgl_terbit)->format('d/m/Y') }}</td>

            <td>
                <form action= "{{route('buku.destroy',$buku->id)}}" method="post">
                    @csrf
                    <button onclick="return confirm('Apakah yakin ingin menghapus data?')"
                    class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Hapus </button>
                </form>
                <br>
                <a href="{{ route('buku.edit', $buku->id) }}"
                class="btn btn-sm btn-primary"><i class="fas fa-edit"></i>&nbsp; Edit &nbsp;</a>
                <br><br>
                <a href="{{ route('buku.detail', $buku->id) }}"
                class="btn btn-sm btn-primary bg-warning"><i class="fas fa-eye"></i> Detail </a>
              
            </td>
        </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr  align="center">
            <th> Jumlah </th>
            <th> </th>
            <th>{{ $jumlah_data }}</th>
            <th> </th>
            <th>{{"Rp " .number_format($total_harga, 2, ',', '.') }}</th>
            <th> </th>
            <th> </th>
        </tr>
    </tfoot>

</table>
</body>
</html>

</x-app-layout>

