<?php

namespace App\Http\Controllers;


use App\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RoleController extends Controller
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

        $query = Role::where('name', 'LIKE', '%' . $term . '%')
            ->orWhere('guard_name', 'LIKE', '%' . $term . '%')
            ->skip($offset)
            ->take($resultCount);

        $data['results'] = $query->get([DB::raw('name as text'), 'Roles.*']);

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
        $sort = $request->filled('sort') ? $request->get('sort') : 'id';
        $order = $request->filled('order') ? $request->get('order') : 'ASC';

        $roles = Role::with(['permissions'])->where('name', 'LIKE', '%' . $request->get('search') . '%')
            ->orWhere('guard_name', 'LIKE', '%' . $request->get('search') . '%');

        $data['total'] = $roles->count();

        $roles->skip($offset)->limit($limit)->orderBy($sort, $order);

        $data['rows'] = $roles->get();

        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return $request->all();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'guard_name' => ['required'],
        ]);



        $role = Role::create([
            'name' => $request->get('name'),
            'guard_name' => $request->get('guard_name'),
        ]);

        if ($request->filled('permission_ids')) {

            RolePermission::where('role_id', $role->id)->delete();

            foreach ($request->get('permission_ids') as $permission_id) {
                RolePermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id
                ]);
            }
        }

        return redirect()->route('role.index')->with('success', 'Role created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);

        if ($role) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => [
                    'role' => $role
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
    public function edit(Role $role)
    {
        return view('role.edit', compact('role'));
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

        $role = Role::find($id);
        $role->update($data);

        if ($request->filled('permission_ids')) {

            RolePermission::where('role_id', $role->id)->delete();

            foreach ($request->get('permission_ids') as $permission_id) {
                RolePermission::create([
                    'role_id' => $role->id,
                    'permission_id' => $permission_id
                ]);
            }
        }

        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();

        return response()->json([
            'status' => true,
            'data' => [
                'role' => $role
            ],
            'message' => "Role deleted"
        ]);
    }
}
