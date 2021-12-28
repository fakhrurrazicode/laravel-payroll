<?php

namespace App\Http\Controllers;


use App\Tunjangan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class TunjanganController extends Controller
{

    public function select2Data(Request $request)
    {
        $data = array(
            "results" => [],
            "pagination" => array(
                "more" => false
            )
        );

        $term = $request->filled('term') ? $request->get('term') : '';
        $q = $request->filled('q') ? $request->get('q') : '';
        $_type = $request->filled('_type') ? $request->get('_type') : '';
        $page = $request->filled('page') ? $request->get('page') : '';

        $resultCount = 25;
        $offset = ($page - 1) * $resultCount;

        $query = Tunjangan::where('nama', 'LIKE', '%' . $term . '%')
            ->skip($offset)
            ->take($resultCount);

        $data['results'] = $query->get([DB::raw('nama as text'), 'tunjangan.*']);

        $count = $query->count();
        $endCount = $offset + $resultCount;
        $data['pagination']['morePages'] = $count > $endCount;


        return response()->json($data);
    }

    public function tableData(Request $request)
    {
        $limit = $request->filled('limit') ? $request->get('limit') : 10;
        $offset = $request->filled('offset') ? $request->get('offset') : 0;
        $search = $request->filled('search') ? $request->get('search') : '';
        $sort = $request->filled('sort') ? $request->get('sort') : 'created_at';
        $order = $request->filled('order') ? $request->get('order') : 'DESC';

        $tunjangan = Tunjangan::where('nama', 'LIKE', '%' . $request->get('search') . '%');

        $data['total'] = $tunjangan->count();

        $tunjangan->skip($offset)->limit($limit)->orderBy($sort, $order);

        $data['rows'] = $tunjangan->get();

        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tunjangan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tunjangan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'tunjanganable_type' => ['required'],
            'tunjanganable_id' => ['required'],
            'nama' => ['required', 'string', 'max:255'],
            // 'deskripsi' => ['required'],
            'nilai' => ['required'],
        ]);

        $tunjangan = Tunjangan::create([
            'tunjanganable_type' => $request->get('tunjanganable_type'),
            'tunjanganable_id' => $request->get('tunjanganable_id'),
            'nama' => $request->get('nama'),
            'deskripsi' => $request->get('deskripsi'),
            'nilai' => $request->get('nilai'),
            'deleted_at' => $request->get('deleted_at'),
        ]);

        return redirect()->route('tunjangan.index')->with('success', 'Tunjangan created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tunjangan = Tunjangan::find($id);

        if ($tunjangan) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => [
                    'tunjangan' => $tunjangan
                ]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tunjangan $tunjangan)
    {
        return view('tunjangan.edit', compact('tunjangan'));
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
        $rules = [
            'nama' => ['required', 'string', 'max:255'],
            'gaji_pokok' => ['required'],
        ];

        $data = [
            'nama' => $request->get('nama'),
            'gaji_pokok' => $request->get('gaji_pokok'),
        ];

        $request->validate($rules);

        $tunjangan = Tunjangan::find($id);
        $tunjangan->update($data);

        return redirect()->route('tunjangan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tunjangan = Tunjangan::find($id);
        $tunjangan->delete();

        return response()->json([
            'status' => true,
            'data' => [
                'tunjangan' => $tunjangan
            ],
            'message' => "Tunjangan deleted"
        ]);
    }
}
