<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css"> 
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.16/dist/tailwind.min.css" rel="stylesheet">
    @if(count($data_buku))
        <div class="alert alert-success">Ditemukan <strong>{{count($data_buku)}}</strong> data dengan
    kata: <strong>{{ $cari }}</strong></div>
    @else
        <div class="alert alert-warning"><h4>Data {{ $cari }} tidak ditemukan</h4>
        <br>
        <a href="/buku" class="btn btn-warning">Kembali</a></div>
    @endif
    <title>Search</title>
</head>

<body style="font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;" class="container-sm">

<table class= "table table-bordered"  style="background-color: #0D617D; color: white;">
    <thead style="background-color: #04364A;">
        <tr align="center">
            <th>Id</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Harga</th>
            <th>Tanggal Terbit</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody align="center">
        @if(Session::has('pesan'))
            <div class="alert alert-success">{{Session::get('pesan')}}</div>
        @endif
        <br>
        <h1 align='center' style="font-size:xx-large; font-weight: bold; color: #04364A;">Daftar Buku</h1>
        <br>
        
        <h1 align='left' style="font-size: large; font-weight: medium;"><a class="btn" 
        style="background-color: #04364A; color: white; font-weight: bold;" href="{{ route('buku.create') }}"> Tambah Buku </a> 
        </h1>

        <br>
        <div style="font-size:large; font-weight: medium;">{{ "Jumlah Buku : " .$jumlah_buku ." buku"}}</div>
        
        <div align="center"> {{ $data_buku -> links() }}</div>  

        <form action="{{ route('buku.search')}}" method="get">
            @csrf
            <input type="text" name="kata" class="form-control" placeholder= "Cari ....." style=" width:40%;
                display: inline; margin-top: 10px; margin-bottom: 10px; float: rigth;">
        </form>

        @foreach($data_buku as $buku)
        <tr>
            <td>{{$buku -> id}}</td>
            <td align="left">{{$buku -> judul}}</td>
            <td align="left">{{$buku -> penulis}}</td>
            
            <!-- number_format digunakan untuk memformat angka pada kolom harga -->
            <td>{{"Rp ".number_format($buku -> harga, 0, ',', '.')}}</td> 
            <td>{{\Carbon\Carbon::parse($buku->tgl_terbit)->format('d/m/Y') }}</td>

            <td>
                <form action= "{{route('buku.destroy',$buku->id)}}" method="post">
                    @csrf
                    <button onClick="return confirm('Yakin mau dihapus?')" class="btn btn-danger" style="font-weight: 700;">Hapus</button>
                </form>

                <br>

                <a href="{{route('buku.edit', ['id' => $buku->id]) }}" class="btn" 
                style="background-color:#04364A; color:white; font-weight:700;">&nbsp; Edit &nbsp;</a>
                
            </td>

        </tr>
        @endforeach
    </tbody>

</table>
</body>
</html>
</x-app-layout>
