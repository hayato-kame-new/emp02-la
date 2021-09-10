<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// 追加
use App\Models\User;

class UsersController extends Controller
{
    public function index() {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }
}
