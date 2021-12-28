<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class PermissionController extends Controller
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

        $query = Permission::where('name', 'LIKE', '%' . $term . '%')
            ->orWhere('guard_name', 'LIKE', '%' . $term . '%')
            ->skip($offset)
            ->take($resultCount);

        $data['results'] = $query->get([DB::raw('name as text'), 'Permissions.*']);

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
        $sort = $request->filled('sort') ? $request->get('sort') : 'name';
        $order = $request->filled('order') ? $request->get('order') : 'ASC';

        $permissions = Permission::where('name', 'LIKE', '%' . $request->get('search') . '%')
            ->orWhere('guard_name', 'LIKE', '%' . $request->get('search') . '%');

        $data['total'] = $permissions->count();

        $permissions->skip($offset)->limit($limit)->orderBy($sort, $order);

        $data['rows'] = $permissions->get();

        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permission.create');
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
            'name' => ['required', 'string', 'max:255'],
            'guard_name' => ['required'],
        ]);

        $permission = Permission::create([
            'name' => $request->get('name'),
            'guard_name' => $request->get('guard_name'),

        ]);

        return redirect()->route('permission.index')->with('success', 'Permission created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::find($id);

        if ($permission) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => [
                    'permission' => $permission
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
    public function edit(Permission $permission)
    {
        return view('permission.edit', compact('permission'));
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
            'name' => ['required', 'string', 'max:255'],
            'guard_name' => ['required', 'string', 'max:255'],
        ];

        $data = [
            'name' => $request->get('name'),
            'guard_name' => $request->get('guard_name'),
        ];

        $request->validate($rules);

        $permission = Permission::find($id);
        $permission->update($data);

        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::find($id);
        $permission->delete();

        return response()->json([
            'status' => true,
            'data' => [
                'permission' => $permission
            ],
            'message' => "Permission deleted"
        ]);
    }
}
