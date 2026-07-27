<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Passenger;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        $selectedRole = $request->query('role', 'passenger');

        return view('auth.login', compact('selectedRole'));
    }

    public function showAdminLogin()
    {
        return view('auth.login', ['selectedRole' => 'admin']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => ['required', 'regex:/^(?:0|94|\+94)?7[0-9]{8}$/'],
            'password' => 'required|confirmed|min:6',
            'role' => 'required|in:passenger,driver'
        ];

        if ($request->role === 'passenger') {
            $rules['extra_info'] = ['required', 'regex:/^([0-9]{9}[vVxX]|[0-9]{12})$/'];
        } elseif ($request->role === 'driver') {
            $rules['extra_info'] = ['required', 'regex:/^[a-zA-Z][0-9]{7}$/'];
        }

        $messages = [
            'phone.regex' => 'The phone number must be a valid Sri Lankan mobile number starting with 07 (e.g., 0771234567).',
            'extra_info.required' => $request->role === 'driver' ? 'The license number field is required.' : 'The NIC number field is required.',
            'extra_info.regex' => $request->role === 'driver' 
                ? 'The license number must start with a letter followed by 7 digits (e.g., B1234567).' 
                : 'The NIC number must be a valid Sri Lankan NIC (e.g., 123456789V or 199912345678).',
        ];

        $request->validate($rules, $messages);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        if ($request->role == 'passenger') {
            Passenger::create([
                'user_id' => $user->id,
                'nic' => $request->extra_info
            ]);
        }

        if ($request->role == 'driver') {
            Driver::create([
                'user_id' => $user->id,
                'license_no' => $request->extra_info
            ]);
        }

        return redirect('/login')
            ->with('success', 'Registration Successful');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:passenger,driver,admin',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {

            $user = Auth::user();

            if ($user->role !== $request->role) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withInput($request->only('email', 'role'))
                    ->with('error', 'Please select the correct login type for this account.');
            }

            if ($user->role == 'admin') {
                return redirect('/admin/dashboard');
            }

            if ($user->role == 'driver') {
                return redirect('/driver/dashboard');
            }

            return redirect()->intended('/passenger/dashboard');
        }

        return back()->with('error', 'Invalid Credentials');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/login');
    }
}
