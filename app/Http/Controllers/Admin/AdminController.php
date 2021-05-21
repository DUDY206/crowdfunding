<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegAdminRequest;
use App\Http\Requests\UploadImageRequest;
use App\Models\Admin;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Mockery\Exception;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        if (request()->user()->can('manage-admin.index')) {
            return response()->json(Admin::orderByDesc('id')->paginate(10));
        }

        return response([
            'status' => false,
            'message' => trans('auth.guard_message'),
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(RegAdminRequest $request)
    {
        if (request()->user()->can('manage-admin.store')) {
            DB::beginTransaction();

            try {
                $request->validated();

                $admin = Admin::create(
                    $request->all([
                        'user_name','full_name','email','phone_number'
                    ]) + [
                        'password' => Hash::make($request->get('password')),
                        'avatar' => Helper::saveImage(null, $request->file('avatar'), 'admin/avata')
                ]);
                DB::commit();

                return response()->json([
                    $admin->fresh()
                ]);
            } catch (Exception $exception) {
                DB::rollBack();

                return response()->json([
                    'error' =>  $exception
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return response([
            'status' => false,
            'message' => trans('auth.guard_message'),
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id)
    {
        if (request()->user()->can('manage-admin.show')) {
            $admin = Admin::findOrFail($id);
            $admin = $admin->load([
                'role' => function ($query) {
                    $query->with('permissions')->get();
                }
            ]);

            return response()->json($admin);
        }

        return response([
            'status' => false,
            'message' => trans('auth.guard_message'),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(RegAdminRequest $request, $id)
    {
        if (request()->user()->can('manage-admin.update')) {
            DB::beginTransaction();

            try {
                $data = $request->all();
                $admin = Admin::findOrFail($id);

                if ($data['password'] == null) {
                    $data['password'] = $admin->password;
                } else {
                    $data['password'] = bcrypt($data['password']);
                }

                $data['avatar'] = Helper::saveImage($admin->avatar, $request->file('avatar'), 'admin/avata');
                $admin->update($data);
                $admin->save();
                DB::commit();

                return response()->json([
                    $admin->fresh()
                ]);
            } catch (Exception $exception) {
                DB::rollBack();

                return response()->json([
                    'error' =>  $exception
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return response([
            'status' => false,
            'message' => trans('auth.guard_message'),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        if (request()->user()->can('manage-admin.destroy')) {
            $admin = Admin::findOrFail($id);

            return response()->json([
                'success' => $admin->delete()
            ]);
        }

        return response([
            'status' => false,
            'message' => trans('auth.guard_message'),
        ], 200);
    }

    public function updateImage(UploadImageRequest $request, $id)
    {
        if (request()->user()->can('manage-admin.upload-image')) {
            DB::beginTransaction();

            try {
                $data = $request->all();
                $admin = Admin::findOrFail($id);
                $data['avatar'] = Helper::saveImage($admin->avatar, $request->file('avatar'), 'admin/avata');

                $admin->update($data);
                $admin->save();
                DB::commit();

                return response()->json([
                    $admin->fresh()
                ]);
            } catch (Exception $exception) {
                DB::rollBack();

                return response()->json([
                    'error' =>  $exception
                ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        return response([
            'status' => false,
            'message' => trans('auth.guard_message'),
        ], 200);
    }
}
