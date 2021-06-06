<?php

namespace Modules\Settings\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Krucas\Settings\Context;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Krucas\Settings\Facades\Settings;
use Modules\Core\Helper\SettingsHelper;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Settings\Http\Forms\UserSettingsForm;

class SettingsController extends Controller
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
        $user = Auth::user();

        //$key = "name";
        //$value = "ak75963@gmail.com";


        //settings([$key => $value]);
        //settings([$key => $value], new Context(['user' => 1]));

        //echo settings($key);

        //exit();
        //$userContext = new Context(['user' => $user->id]);
        
//Settings::context($userContext1)->set('key', 'value1');
        //settings();
        //Settings::context(new Context(['user' => $user->id]))->forget(SettingsHelper::S_USER_PHONE);
        $userSettingsForm = $this->form(UserSettingsForm::class, [
          'method' => 'POST',
          'url' => route('settings.store'),
          'id' => 'user_settings_form',
          'model' => [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => settings(SettingsHelper::S_USER_PHONE,null,new Context(['user' => $user->id])),
            'email_address' => $user->email
            ]
        ]);

        $title = 'core.settings.menu.account.form.title';
        $subtitle = 'core.settings.menu.account.form.subtitle';

        /*$companySettingsForm = $this->form(CompanySettingsForm::class, [
            'method' => 'POST',
            'url' => route('settings.company_settings'),
            'id' => 'company_settings_form',
            'model' => [
                'company_name' => Settings::get(SettingsHelper::S_COMPANY_NAME),
                'address' => Settings::get(SettingsHelper::S_COMPANY_ADDRESS_),
                'city' => Settings::get(SettingsHelper::S_COMPANY_CITY),
                'state' => Settings::get(SettingsHelper::S_COMPANY_STATE),
                'postal_code' => Settings::get(SettingsHelper::S_COMPANY_POSTAL_CODE),
                'country' => Settings::get(SettingsHelper::S_COMPANY_COUNTRY),
                'phone' => Settings::get(SettingsHelper::S_COMPANY_PHONE),
                'website' => Settings::get(SettingsHelper::S_COMPANY_WEBSITE),
                'vat_id' => Settings::get(SettingsHelper::S_COMPANY_VAT_ID)
            ]
        ]);*/

        return view('settings::index',['user_settings_form' => $userSettingsForm, 'title' => $title, 'subtitle' => $subtitle]);
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
        $form = $this->form(UserSettingsForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        //$file = $request->file('s_display_logo_upload')->store(public_path());

        //dd($file);

        $file = $form->getField('s_display_logo_upload');
        if ($file->getRawValue() != null) {
            $uploaded = $file->getRawValue();

            $logoName = 'photo.'.$uploaded->getClientOriginalExtension();

            //echo SettingsHelper::CONST_LOGO_UPLOAD_PATH;
            //echo SettingsHelper::CONST_LOGO_UPLOAD_PATH.$logoName;

            $uploadSuccess = $uploaded->move(SettingsHelper::CONST_LOGO_UPLOAD_PATH, $logoName);

            if ($uploadSuccess) {
                Settings::set(SettingsHelper::S_DISPLAY_LOGO_UPLOAD, SettingsHelper::CONST_LOGO_UPLOAD_PATH.$logoName);
            }
            
        }
        //dd($file);
        //exit();
        $user = Auth::user();

        $account = User::find($user->id);
        $account->first_name = $request->first_name;
        $account->last_name = $request->last_name;
        $account->email = $request->email_address;
        $account->save();

settings([SettingsHelper::S_USER_PHONE => $request->phone],new Context(['user' => $user->id]));

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
