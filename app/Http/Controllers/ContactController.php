<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
       return view('contacts.index', [
            'contacts' => $request->user()->contacts()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|regex:/^[\pL\s]+$/u|max:30',
            'last_name' => 'nullable|regex:/^[\pL\s]+$/u|max:30',
            'phone' => 'required|digits:9',
            'email' => 'nullable|email:strict'
        ]);

        $request->user()->contacts()->create($validated);

        return redirect(route('contacts.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact): View
    {
        return view('contacts.edit', [
            'contact' =>$contact,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact): RedirectResponse
    {
        $validated = $request->validate([
            'first_name' => 'required|regex:/^[\pL\s]+$/u|max:30',
            'last_name' => 'nullable|regex:/^[\pL\s]+$/u|max:30',
            'phone' => 'required|digits:9',
            'email' => 'nullable|email:strict'
        ]);

        $contact->update($validated);

        return redirect(route('contacts.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect(route('contacts.index'));
    }

}
