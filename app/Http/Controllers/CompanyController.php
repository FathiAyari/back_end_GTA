<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\History;
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
        $company->phone_number = $request->phone_number;
        $company->tax_id = $request->tax_id;
        $destination="public/images/companies";
        $image=$request->file('image');

        $imageName=$image->getClientOriginalName();
        $image->storeAs($destination,$imageName);
        $company->url = $imageName;

        $company->save();
        History::create([

            'type'=>"create",
            'body'=>"The company $request->name has been created at ".Carbon::now()->toDateTimeString()."\nLocation :  $request->adresse",
        ]);
        return response()->json($company, 200);
    }



    public function deleteCompany($id)
    {
        $company = Company::find($id);
        $company->delete();
        History::create([

            'type'=>"delete",
            'body'=>"The company $company->name has been deleted at ".Carbon::now()->toDateTimeString(),
        ]);
        return response()->json($company, 200);
    }



    public  function  updateCompany(Request  $request,$id){
      $company=Company::find($id);
      $company->name=$request->name;
      $company->phone_number=$request->phone_number;
      $company->tax_id=$request->tax_id;
      $company->adresse=$request->adresse;
        if ($request->hasFile('image')) {

            $destination="public/images/companies";
            $image=$request->file('image');

            $imageName=$image->getClientOriginalName();
            $image->storeAs($destination,$imageName);
            $company->url = $imageName;
        }

      $company->save();

      return response()->json($company,200);
    }
}
