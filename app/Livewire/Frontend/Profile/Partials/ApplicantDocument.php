<?php

namespace App\Livewire\Frontend\Profile\Partials;

use App\Models\User;
use Livewire\Component;
use App\Models\Document;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use App\Models\VacancyDocument;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ApplicantDocument extends Component
{
    use WithFileUploads;
    public User $user;
    public $user_id;
    public $vacancy_document_id;
    public $applicantDocument;

    #[Computed(persist: true, seconds: 7200)]
    public function vacancyDocuments()
    {
        return VacancyDocument::all()
            ->where('is_active', true)
            ->pluck('name', 'id')
            ->toArray();
    }

    #[Computed(persist: true, seconds: 7200)]
    public function documents()
    {
        return Document::query()
            ->whereBelongsTo(Auth::user())
            ->get();
    }

    public function updateDocument()
    {
        try {
            $validated = $this->validate([
                'vacancy_document_id' => 'required|exists:vacancy_documents,id',
                'applicantDocument' => 'required|mimes:pdf|max:2048',
            ]);
            $vacancyDocument = VacancyDocument::find($validated['vacancy_document_id'])->name;
            // dd($vacancyDocument);
            $document = Auth::user()->documents()->create([
                'vacancy_document_id' => $validated['vacancy_document_id'],
            ]);

            $document->addMedia($validated['applicantDocument'])->toMediaCollection($vacancyDocument);

            unset($this->documents);
            $this->resetProperty();
            $this->dispatch('closeModal');
            $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil memperbarui dokument pendukung.', timeout: 3000);
        } catch (\Exception $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        } catch (ValidationException $e) {
            $this->dispatch('notification', type: 'error', title: 'Error!', message: $e->getMessage(), timeout: 3000);
        }
    }

    public function deleteDocument($id)
    {
        $document = Document::find($id);
        $document->clearMediaCollection();
        $document->delete();
        unset($this->documents);
        $this->dispatch('notification', type: 'success', title: 'Berhasil!', message: 'Berhasil menghapus dokumen.', timeout: 3000);
    }

    public function resetProperty()
    {
        $this->reset([
            'applicantDocument',
            'vacancy_document_id',
            'user_id'
        ]);
    }

    public function render()
    {
        return view('livewire.frontend.profile.partials.applicant-document');
    }
}
