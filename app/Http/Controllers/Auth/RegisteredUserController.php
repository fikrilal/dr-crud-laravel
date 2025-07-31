<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();
        
        try {
            // Generate unique customer code
            $kdPelanggan = $this->generateCustomerCode();
            
            // Create customer record first
            $customer = Customer::create([
                'kd_pelanggan' => $kdPelanggan,
                'nm_pelanggan' => $request->name,
                'email' => $request->email,
                'alamat' => '', // Can be filled later
                'kota' => '', // Can be filled later
                'telpon' => '', // Can be filled later
                'status' => 'active',
            ]);

            // Create user record with customer code reference
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'user_type' => 'customer',
                'kd_pelanggan' => $kdPelanggan,
                'is_active' => true,
            ]);

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            return redirect(RouteServiceProvider::HOME);
            
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Generate unique customer code
     */
    private function generateCustomerCode(): string
    {
        do {
            $code = 'CUST' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while(Customer::where('kd_pelanggan', $code)->exists());
        
        return $code;
    }
}
