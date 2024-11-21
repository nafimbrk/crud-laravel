<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 4;
        if(strlen($katakunci)) {
            $data = Mahasiswa::where('nim', 'like', "%$katakunci%")
            ->orWhere('nama', 'like', "%$katakunci%")
            ->orWhere('jurusan', 'like', "%$katakunci%")
            ->paginate($jumlahbaris);
        } else {
            $data = Mahasiswa::orderBy('nim', 'desc')->paginate($jumlahbaris);
        }

        return view('mahasiswa.index')->with('data', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        Session::flash('nim', $request->nim);
        Session::flash('nama', $request->nama);
        Session::flash('jurusan', $request->jurusan);

        $request->validate([
            'nim' => 'required|numeric|unique:mahasiswa,nim',
            'nama' => 'required',
            'jurusan' => 'required'
        ],[
            'nim.required' => 'nim wajib diisi',
            'nim.numeric' => 'nim wajib angka',
            'nim.unique' => 'nim sudah ada',
            'nama.required' => 'nama wajib diisi',
            'jurusan.required' => 'jurusan wajib diisi'
        ]);

        $data = [
            'nim' => $request->nim,
            'nama' => $request->nama,
            'jurusan' => $request->jurusan
        ];

        Mahasiswa::create($data);
        return redirect()->to('mahasiswa')->with('success', 'berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Mahasiswa::where('nim', $id)->first();
        return view('mahasiswa.edit')->with('data', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required',
            'jurusan' => 'required'
        ],[
            'nama.required' => 'nama wajib diisi',
            'jurusan.required' => 'jurusan wajib diisi'
        ]);

        $data = [
            'nama' => $request->nama,
            'jurusan' => $request->jurusan
        ];
        Mahasiswa::where('nim', $id)->update($data);
        return redirect()->to('mahasiswa')->with('success', 'berhasil mengedit data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Mahasiswa::where('nim', $id)->delete();
        return redirect()->to('mahasiswa')->with('success', 'berhasil hapus data');
    }
}
