<?php

namespace App\Services\Api\User;


use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthService extends BaseService
{


    /**
     * @param array|Collection $data
     * @return array
     */
    public function register(array|Collection $data): array
    {
        $user = new User();

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $user->save();
        $user->remember_token = $user->createToken($data['email'])->plainTextToken;
        $user->save();

        return $this->success(200, [
            'user' => new UserResource($user),
        ]);
    }

    /**
     * @param array|Collection $data
     * @return array
     */
    public function login(array|Collection $data): array
    {
        $user = User::where('email', $data['email'])->first();
        if ($user && Hash::check($data['password'], $user->password)) {
            $user->remember_token = $user->createToken($data['email'])->plainTextToken;
            $user->save();

            return $this->success(200, [
                'user' => new UserResource($user),
            ]);
        } else {
            return $this->failed(400, ['error' => __('auth.failed')]);
        }
    }

    public function logout(): array
    {
        $user = auth('api')->user();

        if ($user instanceof \App\Models\User) {
            $user->tokens()->delete();
            return $this->success(200, ['message' => 'Logged out successfully']);
        }
        return $this->failed(400, ['error' => 'Unauthorized']);
    }

}
