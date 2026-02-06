<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

use App\Base\Constants\Roles;
use App\Http\Controllers\CrudController;

use App\Models\User;

class UserController extends CrudController
{
    protected $entity = User::class;

    public function me() { return response()->json(auth()->user()); }

    public function validateForCreate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required|exists:roles,id',
            'state_id' => 'required_if:role_id,' . Roles::STATE_AGENT . '|exclude_unless:role_id,' . Roles::STATE_AGENT . '|exists:states,id',
            'password' => 'required|confirmed',
        ]);
    }

    public function validateForUpdate(Request $request)
    {
        $request->validate([
            'name' => 'string',
            'email' => 'string|email',
            'role_id' => 'exists:roles,id',
            'state_id' => 'exclude_unless:role_id,' . Roles::STATE_AGENT . '|exists:states,id',
            'password' => 'confirmed',
        ]);
    }

    public function fill(Request $request, $user)
    {
        parent::fill($request, $user);

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if (null == $user->email_verified_at) {
            $user->email_verified_at = now();
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function beginQuery(Request $request)
    {
        $query = parent::beginQuery($request);

        if ($request->has('role_id') && $request['role_id'] > 0) {
            $query->whereHas('roles', function ($query) use ($request) {
                $query->where('id', $request['role_id']);
            });
        }

        return $query->with(['roles', 'states']);
    }

    public function search($query, $search)
    {
        return User::where(function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%');
            $query->orWhere('email', 'like', '%' . $search . '%');
        })->get();
    }

    /**
     * Dispara após o salvamento de um model
     *
     * @param \App\Models\User $user
     */
    public function afterModelSaved(Request $request, $user)
    {
        if ($request->has('role_id') && $request['role_id'] > 0) {
            $user->roles()->sync([$request['role_id']]);
        }
        if ($request->has('state_id') && $request['state_id'] > 0) {
            $user->states()->sync([$request['state_id']]);
        }
    }
}
