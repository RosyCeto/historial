<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request; // Asegúrate de importar esta clase

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }
    
 


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
{
    return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => $data['role'], // Agrega esta línea para asignar el rol
    ]);
}


    // Agrega este método para manejar la redirección después del registro
    protected function registered(Request $request, User $user)
{
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'doctor':
            return redirect()->route('doctor.dashboard');
        case 'nurse':
            return redirect()->route('nurse.dashboard');
        case 'lab_tech':
            return redirect()->route('lab.tech.dashboard');
        default:
            return redirect('/home');
    }
}

}

