<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Media as File;
use Illuminate\Support\Facades\Storage;

class FileUpload extends Component
{
    use WithFileUploads;

    public $file; 
    public $files = [];
    public $multiple = false;
    public $label = 'Select File';
    public $preview = true;
    public $rules = ['required', 'mimes:jpg,jpeg,png,pdf', 'max:2048']; 
    public $modelName; 
    public $uploadedFile = null;
    public $showImage = false;

    /**
     * Mount the component with initial properties.
     *
     * @param bool $multiple Whether multiple files can be uploaded.
     * @param string $label The label for the file input.
     * @param bool $preview Whether to show image preview.
     * @param array $rules Validation rules for the file.
     * @param string $modelName The name of the property in the parent component to bind to.
     */
    public function mount(
        $multiple = false,
        $label = 'Select File',
        $preview = true,
        $rules = ['required', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        $modelName = '' // Default to empty string
    ) {
        $this->multiple = $multiple;
        $this->label = $label;
        $this->preview = $preview;
        $this->rules = $rules;
        $this->modelName = $modelName;

        // Inisialisasi properti files jika multiple upload diaktifkan
        if ($this->multiple && !is_array($this->files)) {
            $this->files = [];
        }
    }

    /**
     * Updated hook for 'file' property (single upload).
     *
     * @param mixed $value The uploaded file instance.
     */
    public function updatedFile($value)
    {
        $this->validateOnly('file');
        // Emit event ke parent component dengan file yang sudah divalidasi

        $folder = date('Y/m');

        $pecah_ex = explode("/",$this->file->getMimeType());
        $fileName = time().'.'.$this->file->getClientOriginalExtension();


        $filePath = $this->file->storeAs($folder, $fileName, 'public');

        $fileModel = File::create([
            'file_name' => $this->file->getClientOriginalName(),
            'mime_type' => $this->file->getClientMimeType(),
            'path' => $filePath,
            'size' => $this->file->getSize(),
            'user_id' => auth()->user()->id
        ]);

        $this->showImage = true;
        $this->uploadedFile = $fileModel;

        $this->dispatch('file-uploaded', ['file' => $fileModel, 'model' => $this->modelName]);
    }

    /**
     * Updated hook for 'files' property (multiple upload).
     *
     * @param mixed $value The array of uploaded file instances.
     */
    public function updatedFiles($value)
    {
        $this->validateOnly('files');
        // Emit event ke parent component dengan array file yang sudah divalidasi
        $this->dispatch('files-uploaded', ['files' => $this->files, 'model' => $this->modelName]);
    }

    /**
     * Get the validation rules for the 'file' or 'files' property.
     *
     * @return array
     */
    protected function rules()
    {
        // Sesuaikan aturan validasi berdasarkan apakah single atau multiple upload
        if ($this->multiple) {
            return ['files.*' => $this->rules];
        }
        return ['file' => $this->rules];
    }

    public function triggerFileUpload()
    {
        // Dispatch a browser event with the name 'open-avatar-chooser'
        $this->dispatch('open-file-dialog');
    }

    public function removeFile($fileId)
    {
        $file = File::find($fileId);

        if ($file) {
            // Delete file from storage
            Storage::disk('public')->delete($file->path);
            // Delete file record from database
            $file->delete();

            // If multiple, remove from files array
            if ($this->multiple) {
                $this->files = array_filter($this->files, function ($f) use ($fileId) {
                    return $f->id !== $fileId;
                });
            } else {
                $this->file = null;
            }

            $this->showImage = false;
            $this->uploadedFile = null;
            $this->dispatch('file-removed', ['fileId' => $fileId, 'model' => $this->modelName]);
        }
    }

    public function render()
    {
        return view('livewire.file-upload');
    }
}
