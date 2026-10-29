<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class CandidateAdminController extends Controller
{
    public function index()
    {
        $candidates = Candidate::orderBy('number')->get();

        return view('admin.images', compact('candidates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:10', 'unique:candidates,number'],
            'party' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $data['image'] = $request->file('image')
            ->store('candidates', 'public');

        Candidate::create($data);

        return redirect()
            ->route('admin.images')
            ->with('success', 'Nova opção cadastrada com sucesso!');
    }

    public function updateImage(Request $request, Candidate $candidate)
    {
        $data = $request->validate([
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $candidate->update([
            'image' => $request->file('image')
                ->store('candidates', 'public'),
        ]);

        return redirect()
            ->route('admin.images')
            ->with('success', 'Imagem atualizada com sucesso!');
    }

    public function destroy(Candidate $candidate)
{
    // Não permite excluir opções que já receberam votos.
    if ($candidate->votes()->exists()) {
        return redirect()
            ->route('admin.images')
            ->with('error', 'Esta opção já recebeu votos e não pode ser excluída.');
    }

    // Remove o arquivo da imagem, se existir.
    if ($candidate->image) {
        Storage::disk('public')->delete($candidate->image);
    }

    $candidate->delete();

    return redirect()
        ->route('admin.images')
        ->with('success', 'Opção excluída com sucesso!');
}
}