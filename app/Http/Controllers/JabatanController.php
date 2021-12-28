<?php

namespace App\Http\Controllers;


use App\Jabatan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class JabatanController extends Controller
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

        $query = Jabatan::where('nama', 'LIKE', '%' . $term . '%')
            ->skip($offset)
            ->take($resultCount);

        $data['results'] = $query->get([DB::raw('nama as text'), 'jabatan.*']);

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

        $jabatan = Jabatan::where('nama', 'LIKE', '%' . $request->get('search') . '%');

        $data['total'] = $jabatan->count();

        $jabatan->skip($offset)->limit($limit)->orderBy($sort, $order);

        $data['rows'] = $jabatan->get();

        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jabatan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jabatan.create');
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
            'nama' => ['required', 'string', 'max:255'],
            'gaji_pokok' => ['required'],
        ]);

        $jabatan = Jabatan::create([
            'nama' => $request->get('nama'),
            'gaji_pokok' => $request->get('gaji_pokok'),
        ]);

        return redirect()->route('jabatan.index')->with('success', 'Jabatan created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jabatan = Jabatan::find($id);

        if ($jabatan) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => [
                    'jabatan' => $jabatan
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
    public function edit(Jabatan $jabatan)
    {
        return view('jabatan.edit', compact('jabatan'));
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

        $jabatan = Jabatan::find($id);
        $jabatan->update($data);

        return redirect()->route('jabatan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);
        $jabatan->delete();

        return response()->json([
            'status' => true,
            'data' => [
                'jabatan' => $jabatan
            ],
            'message' => "Jabatan deleted"
        ]);
    }
}
