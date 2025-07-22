<?php

namespace App\Http\Controllers;

use App\Models\User;  // Importar el modelo User
use Illuminate\Auth\Events\Registered;  // Opcional, si usas el evento Registered
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;  // Importar la fachada Hash
use Illuminate\Validation\Rules\Password;  // Importar la clase Password
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showFormRegistro()
    {
        if (Auth::check()) {
            // Verifica si el el usuario ya está autenticado
            return redirect()->route('/')->with('success', 'Tiene una sesión iniciada, ciérrela para crear una nueva.');
        }

        $datos = [
            'textos' => [
                'titulo' => 'Iniciar Sesión | Sonkei FC',
                'logo' => '/assets/imgs/logo_sonkei_v2.webp',
                'nombre' => 'Sonkei FC',
                'formulario' => [
                    'titulo' => 'Registro Sonkei FC ⚽️',
                    'instruccion' => 'Ingrese sus datos para registrarse en el sistema'
                ],
            ],
            'dev' => [
                'nombre' => 'Instituto Profesional San Sebastián',
                'url' => 'https://www.ipss.cl',
                'logo' => 'https://ipss.cl/wp-content/uploads/2025/04/cropped-LogoIPSS_sello50anos_webipss.png'
            ]
        ];
        
        return view('backoffice/users/registro', $datos);
    }

    public function guardarNuevo(Request $request)
    {
        // 1. revisar los datos que llegan del formulario
        // dd($request->all());

        // 2. Validación de los datos del formulario
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'lowercase', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'rut' => ['required', 'string', 'max:12', 'unique:' . User::class], // Add RUT validation rule
        ], $this->messages);
      
        // 3. Creación del nuevo usuario en la base de datos
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'rut' => $request->rut, // Save RUT to the database
        ]);

        // Opcional: Disparar el evento Registered si necesitas enviar correos de verificación, etc.
        // event(new Registered($user));

        // 4. Redirigir a la página de login con un mensaje de éxito
        return redirect()->route('user.form.show.login')->with('success', 'Usuario creado, debe iniciar sesión.');
    }

    public function showFormLogin()
    {
        $datos = [
            'textos' => [
                'titulo' => 'Iniciar Sesión | Sonkei FC',
                'logo' => '/assets/imgs/logo_sonkei_v2.webp',
                'nombre' => 'Sonkei FC',
                'formulario' => [
                    'titulo' => 'Bienvenido a Sonkei FC ⚽️',
                    'instruccion' => 'Ingrese Credenciales'
                ],
            ],
            'dev' => [
                'nombre' => 'Instituto Profesional San Sebastián',
                'url' => 'https://www.ipss.cl',
                'logo' => 'https://ipss.cl/wp-content/uploads/2025/04/cropped-LogoIPSS_sello50anos_webipss.png'
            ]
        ];

        if (Auth::check()) {
            // Si el usuario ya está autenticado, redirígelo a la página principal
            // o a su dashboard.
            return redirect()->route('/')->with('success', 'Tiene una sesión iniciada, ciérrela para iniciar una nueva.');
        }

        return view('backoffice/users/login', $datos);
    }

    public function login(Request $request)
    {
        // Paso 1: Ver qué llega en la solicitud del formulario
        // dd($request->all());

        $credentials = $request->validate([
            'username' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // dd($credentials);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            return redirect()->route('user.dashboard')->with('success', "Bienvenido {$user->name}, tiene una sesión iniciada exitosamente.");
        }

        return back()->withErrors([
            'username' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.form.show.login')->with('success', 'Sesión cerrada exitosamente.');
    }
    public function showProfile()
    {
        $user = Auth::user(); // Get the authenticated user
        return view('backoffice/users/profile', compact('user'));
    }
    public function showDashboard()
    {
        $user = Auth::user();
        return view('backoffice/users/dashboard', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:0'],
            'address' => ['nullable', 'string', 'max:255'],
            'commune' => ['nullable', 'string', 'max:255'],
            'phone_number_1' => ['nullable', 'string', 'max:20'],
            'phone_number_2' => ['nullable', 'string', 'max:20'],
            // Add validation rules for other profile fields
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user->update([
            'name' => $request->name,
            'age' => $request->age,
            'address' => $request->address,
            'commune' => $request->commune,
            'phone_number_1' => $request->phone_number_1,
            'phone_number_2' => $request->phone_number_2,
            // Update other profile fields
            
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
    function validarRUT($rut) {
        // Limpiar RUT (quitar puntos y guion)
        $rut = preg_replace('/[^0-9kK]/', '', $rut);
     
        // Si es muy corto, no es válido
        if (strlen($rut) < 2) return false;
     
        // Separar cuerpo y dígito verificador
        $cuerpo = substr($rut, 0, -1);
        $dv = strtoupper(substr($rut, -1));
     
        // Si el cuerpo no es numérico, no es válido
        if (!ctype_digit($cuerpo)) return false;
     
        // Calcular dígito verificador
        $suma = 0;
        $multiplo = 2;
        for ($i = strlen($cuerpo) - 1; $i >= 0; $i--) {
            $suma += $cuerpo[$i] * $multiplo;
            $multiplo = ($multiplo < 7) ? $multiplo + 1 : 2;
        }
     
        $resto = $suma % 11;
        $dvEsperado = 11 - $resto;
     
        if ($dvEsperado == 11) $dvEsperado = '0';
        elseif ($dvEsperado == 10) $dvEsperado = 'K';
        else $dvEsperado = (string)$dvEsperado;
     
        return $dv === $dvEsperado;
    }
}
