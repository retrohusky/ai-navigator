<?php

namespace Modules\Auth\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Auth\Entities\User;
use Modules\Auth\Http\Requests\LoginRequest;
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
     * @return RedirectResponse
     */
    public function store(RegisterRequest $request): RedirectResponse
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

        return redirect()->route('root');
    }

    public function authenticate( LoginRequest $request )
    {
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {

            /**
             * @var User $user
             */
            $user = Auth::user();

            if ( $user->hasVerifiedEmail() ) {
                Auth::login($user);
                return redirect()->route('root');
            }

            return redirect()->back()->withErrors(['email_verify' => 'Please verify your email address first.']);

        };
        return redirect()->back()->withErrors(['no_match' => 'These credentials do not match our records.']);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('root');
    }

    private function hashPassword(string $get) : string
    {
        return bcrypt($get);
    }
}
