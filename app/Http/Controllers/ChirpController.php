<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Auth;
use Illuminate\Http\Request;

// use Illuminate\Support\Facades\Gate;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = Chirp::with('user') // eager-load user to prevent N+1 queries
        ->latest() // can omit query(), orders by
        ->take(50) // not the best way
        ->get(); // end query

        return view('home', ['chirps' => $chirps]);
    }

    /**
     * Show the form for creating a new resource.
     * Won't need because form would be on the same page
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * If validation fails:
     * It automatically redirects back
     * It flashes error messages into session
     * Your controller code NEVER runs further
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'message' => 'required|string|max:255|min:5',
        ], [
            'message.required' => 'Please write something to chirp!',
            'message.max' => 'Chirps must be 255 characters or less.',
        ]);

        // Create the chirp (no user for now - we'll add auth later)
        // Chirp::create([
        //     'message' => $validated['message'],
        //     'user_id' => null, // We'll add authentication in lesson 11
        // ]);

        // global auth helper function
        // auth()->user()->chirps()->create($validated); // annoying red line at user()
        Auth::user()->chirps()->create($validated);

        // Redirect back to the feed
        return redirect('/')->with('success', 'Your chirp has been posted!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);

        return view('chirps.edit', compact('chirp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        // Authorize
        // can be explicit with:
        // if ($request->user()->cannot('update', $chirp)) {
        //     abort(403);
        // }
        // or
        $this->authorize('update', $chirp);

        // Same thing as create - validate and update
        // Validate the request
        $validated = $request->validate([
            'message' => 'required|string|max:255|min:5',
        ], [
            'message.required' => 'Please write something to chirp!',
            'message.max' => 'Chirps must be 255 characters or less.',
        ]);

        $chirp->update($validated);

        // Redirect back to the feed
        return redirect('/')->with('success', 'Your chirp has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        // Add authorization check with ChirpPolicy
        // Laravel takes the type of $chirp and finds the associated policy and calls the delete method
        // Have to explicitly add use AuthorizesRequests; to base controller to use authorize()
        // $this->authorize('delete', $chirp);
        // or use Gate checks:
        // Gate::authorize('delete', $chirp);
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return redirect('/')->with('success', 'Your chirp has been deleted!');
    }
}
