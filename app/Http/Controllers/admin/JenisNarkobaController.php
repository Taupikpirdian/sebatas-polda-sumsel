<?php

namespace App\Http\Controllers\Admin;

use App\TypeNarkoba;
use App\Perkara;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class JenisNarkobaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jenis_narkobas = TypeNarkoba::orderBy('name', 'asc')->paginate(10);
        return view('admin.jenis_narkoba.list', compact('jenis_narkobas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View::make('admin.jenis_narkoba.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check nama jenis pidana tidak boleh ada yang sama
        $jenis_narkoba = strtoupper($request->name);
        $jenis_narkobas = TypeNarkoba::where('name', $jenis_narkoba)->exists();
        // jika ditemukan data sama
        if($jenis_narkobas){
            return Redirect::back()->with('flash-error', $request->name.' sudah terdaftar');
        }

        // create data
        $jenisNarkoba   = new TypeNarkoba;
        $jenisNarkoba->name   = $jenis_narkoba;
        $jenisNarkoba->save();

        return Redirect::action('admin\JenisNarkobaController@index')->with('flash-store','Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jenis_narkoba = TypeNarkoba::where('id', $id)->firstOrFail();
        return view('admin.jenis_narkoba.edit', compact('jenis_narkoba'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // check nama jenis pidana tidak boleh ada yang sama
        $jenis_narkoba = strtoupper($request->name);
        $jenis_narkobas = TypeNarkoba::where('id', '!=', $id)->where('name', $jenis_narkoba)->exists();
        // jika ditemukan data sama
        if($jenis_narkobas){
            return Redirect::back()->with('flash-error', $request->name.' sudah terdaftar');
        }

        $jenisNarkoba = TypeNarkoba::findOrFail($id);
        $jenisNarkoba->name                  = $jenis_narkoba;
        $jenisNarkoba->save();
        return Redirect::action('admin\JenisNarkobaController@index', compact('jenisNarkoba'))->with('flash-update','Data berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // cek data narkoba sudah digunakan atau belum
        $check = Perkara::where('material', $id)->first();

        if($check != null){
          return Redirect::back()->with('flash-error','Tidak bisa menghapus data ini, karena sudah memiliki data perkara');
        }else{
          $jenisNarkoba = TypeNarkoba::where('id', $id)->firstOrFail();
          $jenisNarkoba->delete();
          return Redirect::action('admin\JenisNarkobaController@index')->with('flash-store','Data berhasil dihapus.');
        }
    }
}
