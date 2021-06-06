<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Krucas\Settings\Facades\Settings;
use Modules\Core\Helper\SettingsHelper;
use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Settings\Http\Forms\CompanySettingsForm;

class CompanySettingsController extends Controller
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
        $companySettingsForm = $this->form(CompanySettingsForm::class, [
          'method' => 'POST',
          'url' => route('company_settings.store'),
          'id' => 'company_settings_form',
          'model' => [
            'company_name' => settings(SettingsHelper::S_COMPANY_NAME),
            'address' => settings(SettingsHelper::S_COMPANY_ADDRESS_),
            'city' => settings(SettingsHelper::S_COMPANY_CITY),
            'state' => settings(SettingsHelper::S_COMPANY_STATE),
            'post_code' => settings(SettingsHelper::S_COMPANY_POSTAL_CODE),
            'country' => settings(SettingsHelper::S_COMPANY_COUNTRY),
            'phone' => settings(SettingsHelper::S_COMPANY_PHONE),
            'website' => settings(SettingsHelper::S_COMPANY_WEBSITE),
            'vat_id' => settings(SettingsHelper::S_COMPANY_VAT_ID)
            ]
        ]);

        $title = 'core.settings.menu.company.form.title';
        $subtitle = 'core.settings.menu.company.form.subtitle';

       return view('settings::index',['user_settings_form' => $companySettingsForm, 'title' => $title, 'subtitle' => $subtitle]);

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
        $form = $this->form(CompanySettingsForm::class);

        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        settings([SettingsHelper::S_COMPANY_NAME => $request->company_name]);
        settings([SettingsHelper::S_COMPANY_ADDRESS_ => $request->address]);
        settings([SettingsHelper::S_COMPANY_CITY => $request->city]);
        settings([SettingsHelper::S_COMPANY_STATE => $request->state]);
        settings([SettingsHelper::S_COMPANY_POSTAL_CODE => $request->post_code]);
        settings([SettingsHelper::S_COMPANY_COUNTRY => $request->country]);
        settings([SettingsHelper::S_COMPANY_PHONE => $request->phone]);
        settings([SettingsHelper::S_COMPANY_WEBSITE => $request->website]);
        settings([SettingsHelper::S_COMPANY_VAT_ID => $request->vat_id]);

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
