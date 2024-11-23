<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'dentalclinic' => $request->user()->dentalclinic,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Handle the Dental Clinic update (logo and name)
        $dentalclinic = $request->user()->dentalclinic;  // Fetch the associated dental clinic

        // Check if the user is an admin based on the 'usertype' field
        if (Auth::user()->usertype === 'admin') {  // Check if the user's type is 'admin'

            // Update dental clinic name
            $dentalclinic->dentalclinicname = $request->dentalclinicname;

            // If logo is provided, handle the logo file update
            if ($request->hasFile('logo')) {
                // Delete old logo if it exists
                if ($dentalclinic->logo && file_exists(public_path('logos/' . $dentalclinic->logo))) {
                    unlink(public_path('logos/' . $dentalclinic->logo));
                }

                // Move new logo to the 'logos' folder and update clinic logo field
                $logoName = $request->file('logo')->getClientOriginalName();
                $request->file('logo')->move(public_path('logos'), $logoName);
                $dentalclinic->logo = $logoName;
            }

            // Save the updated clinic details
            $dentalclinic->save();
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
