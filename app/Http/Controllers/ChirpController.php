<?php

namespace App\Http\Controllers;

use App\Http\Requests\Chirps\StoreChirpRequest;
use App\Http\Requests\Chirps\UpdateChirpRequest;
use App\Models\Chirp;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChirpController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** @var Chirp[] $chirps */
        $chirps = Chirp::query()
            ->when($request->filled('search'), fn($initialQ)
            => $initialQ->where('message', 'like', '%' . $request->search . '%'))
            ->with([
                'user' => fn($q) => $q->withIsFollowed(),
                'topLevelComments',
            ])
            ->withCount('likes', 'comments')
            ->when(Auth::check(), function ($query) {
                $query->withExists([
                    'likes' => fn($q) => $q->where('user_id', Auth::id()),
                ]);
            })
            ->latest()
            ->take(50)
            ->get();

        // dd($chirps->map(fn($ch) => $ch->topLevelComments));

        return view('home', compact('chirps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreChirpRequest $request)
    {
        $validated = $request->validated();

        $request->user()->chirps()->create($validated);

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

        return view('chirps.edit', compact(['chirp']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateChirpRequest $request, Chirp $chirp)
    {
        $validated = $request->validated();

        $chirp->update($validated);

        return redirect('/')->with('success', 'Chirp Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return back()->with('success', 'Chirp Deleted!');
    }
}
