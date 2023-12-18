<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Gallery;

use App\Models\Buku;
use App\Models\Rating;
use App\Models\Favourite;

use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    public function index(){
        // mengambil data yang berada didalam tabel buku di database
        $data_buku = Buku::all();

        // menghitung jumlah baris
        $jumlah_data = Buku::count();

        // menghitung total harga
        $total_harga = 0;
        foreach ($data_buku as $buku) {
            $total_harga += $buku->harga;
        }

        $batas = 5;
        $jumlah_buku = Buku::count();
        $data_buku = Buku::orderBy('id','desc') -> paginate($batas);
        $no_buku = $batas * ($data_buku -> currentPage() - 1);

        // me-return hasilnya menggunakan sebuah view
        return view('index', compact('data_buku', 'jumlah_data', 'total_harga', 'jumlah_buku', 'no_buku'));
    }

    public function create(){
        return view('create');
    }

    public function store(Request $request){
        $buku = new Buku;
        $buku -> judul = $request -> judul;
        $buku -> penulis = $request -> penulis;
        $buku -> harga = $request -> harga;
        $buku -> tgl_terbit = $request -> tgl_terbit;

        $this->validate($request,[
            'judul'  => 'required|string',
            'penulis' => 'required|string|max:30',
            'harga' => 'required|numeric',
            'tgl_terbit' =>'required|date'
        ]);

        $request->validate([
            'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
        $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');
        $buku -> fileName = $fileName;
        $buku -> filepath = '/storage/'.$filePath;

        Image::make(storage_path().'/app/public/uploads/'.$fileName)
        ->fit(140,220)
        ->save();

        $buku -> save();

        if ($request->file('gallery')) {
            foreach($request->file('gallery') as $key => $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                $gallery = Gallery::create([
                    'nama_galeri' => $fileName,
                    'path' => '/storage/'. $filePath,
                    'foto' => $fileName,
                    'buku_id' => $buku -> id
                ]);
            }
        }
        // menambahkan pesan menggunakan with
        return redirect('/buku')->with('pesan','Data Buku Berhasil di Simpan');
    }

    public function destroy($id) {
        $buku = Buku::find($id);
        $buku->delete();
        return redirect('/buku')->with('pesan','Data Buku Berhasil di Hapus');
    }

    public function edit($id) {
        $buku = Buku::find($id);
        return view('update',compact('buku'));
    }

    public function update(Request $request, $id) {
        $buku = Buku::find($id);

        if ($request->file('thumbnail')) {
            $request->validate([
                'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
            ]);

            $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');

            Image::make(storage_path().'/app/public/uploads/'.$fileName)
            ->fit(140,220)
            ->save();
        }

        if ($request->file('gallery')) {
            foreach($request->file('gallery') as $key => $file) {
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads', $fileName, 'public');

                $gallery = Gallery::create([
                    'nama_galeri' => $fileName,
                    'path' => '/storage/'. $filePath,
                    'foto' => $fileName,
                    'buku_id' => $id
                ]);
            }
        }

        if ($request->file('thumbnail')) {
            $buku->update([
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'harga' => $request->harga,
                'tgl_terbit' => $request->tgl_terbit,
                'filename' => $fileName,
                'filepath' => '/storage/' . $filePath
            ]);
        } else {
            if ($buku->filepath) {
                $buku->update([
                    'judul' => $request->judul,
                    'penulis' => $request->penulis,
                    'harga' => $request->harga,
                    'tgl_terbit' => $request->tgl_terbit,
                    'filename' => $buku->filename,
                    'filepath' => $buku->filepath
                ]);
            }
        }

        return redirect('/buku')->with('pesan','Data Buku Berhasil di Update');
    }

    public function search(Request $request){
        $batas = 5;
        $cari= $request->kata;
        $data_buku = Buku::where('judul','like',"%".$cari."%") -> orwhere('penulis','like',"%".$cari."%")->paginate($batas);
        $no_buku = $batas * ($data_buku -> currentPage() - 1);
        $jumlah_buku = Buku::count();

        // me-return hasilnya menggunakan sebuah view
        return view('search', compact( 'jumlah_buku', 'no_buku', 'data_buku','cari'));
    }

    public function deleteGallery($id) {
        $gallery = Gallery::findOrFail($id);

        $gallery->delete();

        return redirect()->back();
    }

    public function showDetail(Request $request, $id)
    {
        // Ambil data buku dari database
        $buku = Buku::find($id);
        // Kirim data buku ke view 'detail_buku'
        return view('detail', compact('buku'));
    }

    public function addRating(Request $request, $id)
    {
        // Ambil data buku dari database
        $buku = Buku::find($id);

        $currentRating = $request->input('currentRating');
        $rating = Rating::create([
            'rating' => $currentRating,
            'buku_id' => $buku->id,
        ]);

        $averageRating = $buku->calculateAverageRating($id);
        $buku->update([
            'rating' => $averageRating,
        ]);

        return redirect('/buku');
    }

    public function galbuku($judul) {
        $buku = Buku::where('judul', $judul) -> first();
        $galeris = $buku -> galleries() -> orderBy('id', 'desc') -> paginate(6);
        return view('detail', compact('buku', 'galeris'));
    }

    public function addToFavourite(Request $request, $id){
        // Ambil data buku dari database
        $buku = Buku::find($id);
        $user = Auth::user()->id;
        $addToFav = Favourite::all();
        $existingFav = Favourite::where('user_id',$user)->where('judul_buku', $buku -> judul)->first();

        if(!$existingFav) {
            $fav = new Favourite();
            $fav -> create ([
                'judul_buku' => $buku -> judul,
                'penulis' => $buku -> penulis,
                'user_id' => $buku -> $user,
                'file_path' => $buku -> filepath
            ]);
        }
        else{
            $existingFav-> delete();
        }
        return redirect('/buku');
    }

    public function showFavourite() {
        $addFav = Favourite::all();
        return view('showFav', compact('addFav'));
    }

}

