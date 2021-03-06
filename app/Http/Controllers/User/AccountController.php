<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Repositories\AccountRepository;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateAccountRequest;

class AccountController extends Controller
{
    public function __construct(private AccountRepository $accountRepository)
    {
    }

    public function edit() : View
    {
        return view('admin.account', ['title' => 'Mon compte', 'user' => Auth::user()]);
    }

    public function update(UpdateAccountRequest $request) : RedirectResponse
    {
        /** @var array $validated */
        $validated = $request->validated();
        
        /** @var User $user */
        $user = Auth::user();

        $this->accountRepository->updateAccount($validated, $user);

        return redirect(route('account.edit'));
    }
}
