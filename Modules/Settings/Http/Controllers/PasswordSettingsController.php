<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Settings\Http\Forms\PasswordSettingsForm;

class PasswordSettingsController extends Controller
{   
    use FormBuilderTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $passwordSettingsForm = $this->form(PasswordSettingsForm::class, [
          'method' => 'POST',
          'url' => route('password_settings.store'),
          'id' => 'password_settings_form'
        ]);

        $title = 'core.settings.menu.security.form.title';
        $subtitle = 'core.settings.menu.security.form.subtitle';

        return view('settings::index',['user_settings_form' => $passwordSettingsForm, 'title' => $title, 'subtitle' => $subtitle]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('settings::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $form = $this->form(PasswordSettingsForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }
        $user = Auth::user();

        $account = User::find($user->id);
        $account->password = Hash::make($request->password);
        $account->save();

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('settings::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('settings::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
