<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
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

        $query = User::where('name', 'LIKE', '%' . $term . '%')
            ->orWhere('email', 'LIKE', '%' . $term . '%')
            ->skip($offset)
            ->take($resultCount);

        $data['results'] = $query->get([DB::raw('CONCAT(name, " - ", email) as text'), 'users.*']);

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

        $query = User::query();
        $query->with(['roles']);
        $query->select(['users.*']);
        $query->where(function ($query) use ($search) {
            $query->orWhere('users.name', 'LIKE', '%' . $search . '%');
            $query->orWhere('users.email', 'LIKE', '%' . $search . '%');
        });


        $data['total'] = $query->count();

        $query->skip($offset)->limit($limit)->orderBy($sort, $order);

        $data['rows'] = $query->get();

        return $data;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = [
            // 'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role_id' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'pegawai_id' => null,
            'password' => Hash::make($request->get('password')),
        ];

        if ($request->get('role_id') == 2) {
            $rules['pegawai_id'] = ['required'];
            $data['pegawai_id'] = $request->get('pegawai_id');
        }

        $request->validate($rules);
        $user = User::create($data);

        $role = Role::find($request->get('role_id'));
        $user->syncRoles([$role]);

        return redirect()->route('user.index')->with('success', 'User created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => [
                    'user' => $user
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
    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'role_id' => ['required'],
        ];

        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'pegawai_id' => null,
        ];

        if ($request->get('role_id') == 2) {
            $rules['pegawai_id'] = ['required'];
            $data['pegawai_id'] = $request->get('pegawai_id');
        }

        if ($request->filled('password')) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
            $data['password'] = Hash::make($request->get('password'));
        }

        $request->validate($rules);

        $user = User::find($id);
        $user->update($data);

        $role = Role::find($request->get('role_id'));

        $user->syncRoles([$role]);

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $user
            ],
            'message' => "User deleted"
        ]);
    }
}
