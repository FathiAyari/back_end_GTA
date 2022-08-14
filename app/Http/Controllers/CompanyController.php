<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\StockHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Console\Output\ConsoleOutput;

class CompanyController extends Controller
{
  public  function getCompanies()
  {
      $companies = Company::orderBy('created_at', 'desc')->get();
      return response()->json($companies,200);
  }

    public function addCompany(Request $request)
    {
        $company = new Company();
        $company->name = $request->name;
        $company->adresse = $request->adresse;
        $destination="public/images/companies";
        $image=$request->file('image');
        $imageName=$image->getClientOriginalName();

        $company->url = $imageName;
        $company->title = $request->title;
        $company->save();
        StockHistory::create([

            'type'=>"create",
            'body'=>"$request->name has been created at ".Carbon::now()->toDateTimeString()."\nLocation :  $request->adresse",
        ]);
        return response()->json($company, 200);
    }



    public function deleteCompany($id)
    {
        $company = Company::find($id);
        $company->delete();
        StockHistory::create([

            'type'=>"delete",
            'body'=>"$company->name has been deleted at ".Carbon::now()->toDateTimeString(),
        ]);
        return response()->json($company, 200);
    }
}
