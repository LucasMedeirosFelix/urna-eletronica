<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class VotingController extends Controller
{
    public function index()
    {
        $candidates = Candidate::orderBy('number')->get();

        return view('voting.index', compact('candidates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => [
                'required',
                Rule::in(['candidate', 'blank', 'null']),
            ],
            'candidate_id' => [
                'nullable',
                'required_if:type,candidate',
                'integer',
                'exists:candidates,id',
            ],
        ]);

        if ($data['type'] !== 'candidate') {
            $data['candidate_id'] = null;
        }

        DB::transaction(function () use ($data) {
            Vote::create([
                'candidate_id' => $data['candidate_id'] ?? null,
                'type' => $data['type'],
            ]);
        });

        return redirect()
            ->route('voting.index')
            ->with('success', 'Voto registrado com sucesso!');
    }

    public function results()
{
    $candidates = Candidate::withCount('votes')
        ->orderBy('number')
        ->get();

    $blankVotes = Vote::where('type', 'blank')->count();
    $nullVotes = Vote::where('type', 'null')->count();
    $totalVotes = Vote::count();

    return view('voting.results', compact(
        'candidates',
        'blankVotes',
        'nullVotes',
        'totalVotes'
    ));
}



}