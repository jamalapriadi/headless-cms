<?php

namespace App\Livewire\Dashboard\Media;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

use Flux\Flux;

class MediaList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedDate = null;
    public $perPage = 12;
    public $selectedMedia = null; // Untuk menampilkan detail media
    public $showDeleteModal = false;
    public $mediaToDelete = null;
    public $showImageUpload = false;

    protected $queryString = ['search' => ['except' => '']];

    protected $listeners = [
        'file-uploaded' => 'handleFileUpload',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showDetails($mediaId)
    {
        $this->selectedMedia = Media::find($mediaId);
        Flux::modal('modal-detail-gallery')->show();
    }

    public function closeDetails()
    {
        $this->selectedMedia = null;
    }

    public function confirmDelete($mediaId)
    {
        $this->mediaToDelete = Media::find($mediaId);
        $this->showDeleteModal = true;

        // Flux::modal('modal-detail-gallery')->close();
        Flux::modal('modal-delete-media')->show();
    }

    public function deleteMedia()
    {
        if ($this->mediaToDelete) {
            // Hapus file fisik dari storage
            $filePath = 'public/' . $this->mediaToDelete->path . '/' . $this->mediaToDelete->file_name;
            if (Storage::exists($filePath)) {
                Storage::delete($filePath);
            }

            // Hapus entri dari database
            $this->mediaToDelete->delete();

            session()->flash('message', 'Media deleted successfully.');
            
            $this->closeDeleteModal();
            $this->selectedMedia = null;
            $this->reset('selectedMedia'); // Tutup detail jika media yang dihapus sedang dibuka

            Flux::modal('modal-detail-gallery')->close();
            Flux::modal('modal-delete-media')->close();
        }
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->mediaToDelete = null;
    }

    public function render()
    {
        $query = Media::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('file_name', 'like', '%' . $this->search . '%')
                  ->orWhere('mime_type', 'like', '%' . $this->search . '%');
        }

        if ($this->selectedDate) {
            // Expected format: 'YYYY-MM'
            [$year, $month] = explode('-', $this->selectedDate);
            $query->whereYear('created_at', $year)
                  ->whereMonth('created_at', $month);
        }

        // Hanya tampilkan media milik user yang sedang login
        $query->where('user_id', auth()->id());

        $mediaItems = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        $allDates = Media::selectRaw('YEAR(created_at) as year, DATE_FORMAT(created_at,"%m") as month, DATE_FORMAT(created_at, "%b") as month_short')
            ->distinct()
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->get();

        return view('livewire.dashboard.media.media-list', [
            'mediaItems' => $mediaItems,
            'allDates'=>$allDates
        ]);
    }

    public function addMediaFile(){
        $this->showImageUpload = true;
    }

    public function cancelMediaFile(){
        $this->showImageUpload = false;
    }

    public function handleFileUpload(){
        $this->cancelMediaFile();

        session()->flash('message', 'Media uploaded successfully.');
    }
}
