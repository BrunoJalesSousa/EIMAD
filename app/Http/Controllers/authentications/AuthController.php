<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
  public function showRegistrationForm()
  {
    return view('eimad.auth.register-form');
  }
  public function showLoginForm()
  {
    return view('auth.login');
  }
  public function register(Request $request)
  {
    // Create and save the new user
    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    $user->save();

    // Log in the new user
    Auth::login($user);

    // Redirect the user after registration
    return redirect('/video');
  }
  public function registerAccount(Request $request)
  {

    $validator = validator()->make($request->all(), [
      'name' => 'required|string|min:3|max:25',
      'email' => 'required|email',
      'password' => 'required|min:5',
    ]);

    if (User::where('email', $request->email)->exists()){
      $validator->errors()->add('email', 'email');
      return back()
        ->withErrors($validator)
        ->with('title', 'Sem sucesso...')
        ->with('message', 'Não foi possivel criar o utilizador')
        ->with('style', 'warning');
    }

    if ($request->password != $request->repeatPassword) {
      $validator->errors()->add('repeatPassword', 'repeatPassword');
      return back()
        ->withErrors($validator)
        ->with('title', 'Sem sucesso...')
        ->with('message', 'Não foi possivel criar o utilizador')
        ->with('style', 'warning');
    }
    if ($validator->fails()) {
      return back()
        ->withErrors($validator)
        ->with('title', 'Sem sucesso...')
        ->with('message', 'Não foi possivel criar o utilizador')
        ->with('style', 'warning');
    }

    $other = User::where('user', $request->name);
    if (sizeof($other) > 0) {
      $validator->errors()->add('name', 'name');
      return back()
        ->withErrors($validator)
        ->with('title', 'Sem sucesso...')
        ->with('message', 'Não foi possivel criar o utilizador')
        ->with('style', 'warning');
    }


    $user = User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
    ]);

    $user->save();

    $users = User::all();

    // Redirect the user after registration
    return view('eimad.accounts.accounts', compact('users'))
      ->with('title', 'Sucesso!')
      ->with('message', 'Utilizador adicionado com sucesso')
      ->with('style', 'success');
  }

  public function login(Request $request)
  {
    $user = User::where('email', $request->email)->first();

    if (!$user) {
      return redirect()->back()->withErrors(['email' => 'Invalid login credentials']);
    }

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
      Auth::loginUsingId($user->id);
      return redirect()->intended('/accounts');
    }

    return redirect()->back()->withErrors(['password' => 'Invalid email or password.']);

  }

  public function logout(Request $request)
  {
    Auth::logout();

    // Redirect to the home page after logout
    return redirect('/login');
  }
}
