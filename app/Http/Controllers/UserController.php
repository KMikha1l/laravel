<?php
namespace App\Http\Controllers;

use \App\User;
use \App\UserRole;
use \Illuminate\Http\Request;
use \Illuminate\Http\RedirectResponse;
use \Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        if ($request->user()->role_id == User::ROLE_ID_ADMIN) {
            return view('users.index', [
                'users' => User::get(),
            ]);
        } else {
            return view('users.index', [
                'users' => User::where('status', 1)->get(),
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('users.create', [
            'roles' => UserRole::get(),
            'statuses' => [
                'activated' => User::USER_STATUS_ACTIVATED,
                'deactivated' => User::USER_STATUS_DEACTIVATED,
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $user = new User;
        $request->password = bcrypt($request->password);
        $user::create($request->all());

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return View
     */
    public function edit(User $user): View
    {
        return view('users.edit', [
            'user' => $user,
            'roles' => UserRole::get(),
            'statuses' => [
                'activated' => User::USER_STATUS_ACTIVATED,
                'deactivated' => User::USER_STATUS_DEACTIVATED,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $user->update($request->all());

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return RedirectResponse
     */
    public function destroy(User $user, Request $request): RedirectResponse
    {
        if ($request->user()->role_id != User::ROLE_ID_ADMIN) {
            $user->status = User::USER_STATUS_DEACTIVATED;
            $user->update(['status', $user->status]);

            return redirect()->route('users.index');
        } else {
            $user->delete();

            return redirect()->route('users.index');
        }
    }
}
