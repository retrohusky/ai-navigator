<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function login(): Response
    {
        return Inertia::render('Auth::Login');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth::Register');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RegisterRequest $request)
    {
        DB::beginTransaction();
        try {
            $collection = collect($request->validated());

            $password = $collection->get('password');
            $password = $this->hashPassword($password);
            $collection->put('password', $password);
            $user = User::create($collection->all());
            event( new Registered( $user ) );
        } catch ( \Exception $exception ) {
            Log::error('Error during the user creation.', [
                'code' => $exception->getCode(),
                'message' => $exception->getMessage()
            ]);
            DB::rollBack();
        }

        DB::commit();

        return redirect()->back();
    }

    private function hashPassword(string $get) : string
    {
        return bcrypt($get);
    }
}
