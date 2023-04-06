<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    function __construct(protected CompanyRepository $company)
    {
    }


    public function index()
    {

        $companies = $this->company->pluck();
        $contacts = Contact::latest()->where(function ($query)
        {
            if ($companyId = request("company_id"))
            {
                $query->where("company_id", $companyId);
            }
        })->paginate(10);

        // doing pagination manually
//        $contactCollection = Contact::latest()->get();
//        $perPage = 10;
//        $currentPage = request()->query('page', 1);
//        $items = $contactCollection->slice(($currentPage * $perPage) - $perPage, $perPage);
//        $total = $contactCollection->count();
//        $contacts = new LengthAwarePaginator($items, $total, $perPage, $currentPage,[
//            'path' => request()->url(),
//            'query' => request()->query()
//        ]);

        return view('contacts.index',
            compact('contacts', 'companies'));
    }

    public function create()
    {
        $companies = $this->company->pluck();
        $contact = new Contact();
        return view('contacts.create', compact('companies', 'contact'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return view('contacts.show')->with('contact', $contact);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company_id' => 'required|exists:companies,id'
        ]);

        Contact::create($request->all());

        return redirect()->route("contacts.index")->with("message", 'Contact has been added successfully');
    }

    public function edit($id)
    {
        $companies = $this->company->pluck();
        $contact = Contact::findOrFail($id);

        return view('contacts.edit', compact('companies', 'contact'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable',
            'address' => 'nullable',
            'company_id' => 'required|exists:companies,id'
        ]);

        $contact = Contact::findOrFail($id);
        $contact->update($request->all());

        return redirect()->route("contacts.index")->with("message", 'Contact has been updated successfully');
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        // don't need to redirect since we know it is form the grid, and we can just call back
        // return redirect()->route("contacts.index")->with("message", 'Contact has been deleted successfully');
        return back()->with("message", 'Contact has been deleted successfully');
    }

}
