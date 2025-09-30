<div class="container mt-5">
    <div class="mb-4">
        <h1 class="display-4">{{ __('Create Product') }}</h1>
        <p class="lead mb-4">{{ __('Form to create a product') }}</p>
        <hr>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success mb-4">
            {{ session('message') }}
        </div>
    @endif

    <a href="{{ route('products.index') }}" class="btn btn-danger mb-3">Back</a>

    <form wire:submit.prevent="submit" enctype="multipart/form-data" autocomplete="off" class="mt-2">
        <div class="row">
            <div class="col-md-6">
                <div class="bg-light p-3 rounded mb-4">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input wire:model.defer="name" type="text" id="name" class="form-control @error('name') is-invalid @enderror" autocomplete="off" />
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea wire:model.defer="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror"></textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="shortdescription" class="form-label">Short Description</label>
                            <textarea wire:model.defer="shortdescription" id="shortdescription" rows="1" class="form-control @error('shortdescription') is-invalid @enderror"></textarea>
                            @error('shortdescription') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">Price</label>
                            <input wire:model.defer="price" type="number" step="0.01" min="0" id="price" class="form-control @error('price') is-invalid @enderror" />
                            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="category_id" class="form-label">Category</label>
                            <select wire:model.defer="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="bg-light p-3 rounded mb-4">
                    <div class="mb-3">
                        <label for="image" class="form-label">Product Image</label>
                        <input type="file" wire:model="image" id="image" accept="image/*" class="form-control @error('image') is-invalid @enderror" />
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        @if ($image)
                            <div class="mt-2 position-relative d-inline-block">
                                <img src="{{ $image->temporaryUrl() }}" alt="Main Image Preview" class="img-thumbnail" style="max-width: 150px;">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 translate-middle" style="z-index:2; border-radius:50%;" wire:click="removeImage" title="Remove Image">&times;</button>
                            </div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select wire:model.defer="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="">-- Select Status --</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="bg-light p-3 rounded mb-4"id="gallery-drop-area"style="border: 2px dashed #ced4da; position: relative;"
                    ondragover="event.preventDefault(); this.style.borderColor='#007bff';"
                    ondragleave="event.preventDefault(); this.style.borderColor='#ced4da';"
                    ondrop="handleGalleryDrop(event)">
                    
                    <label for="gallery" class="form-label">Product Gallery Images</label>
                    <input 
                        type="file" 
                        wire:model="gallery_temp" 
                        id="gallery" 
                        accept="image/*" 
                        multiple 
                        class="form-control @error('gallery_temp.*') is-invalid @enderror" 
                        style="background: transparent;"
                    />
                    <div class="text-muted small mt-2 mb-2">
                        Drag &amp; drop images here or click to select.
                    </div>
                    @error('gallery_temp.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    <div class="mt-2">
                        @if (is_array($gallery_temp) && count($gallery_temp))
                            @foreach ($gallery_temp as $index => $galleryImage)
                                <div class="position-relative d-inline-block" style="width: 90px; height: 90px;">
                                    <img src="{{ $galleryImage->temporaryUrl() }}" alt="Gallery Preview" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                    <button type="button"
                                        class="btn btn-danger btn-sm position-absolute"
                                        style="top: 2px; right: 2px; z-index: 2; border-radius: 50%; width: 24px; height: 24px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                        onclick="removeGalleryImageFromTemp({{ $index }})"
                                        title="Remove Image">
                                        <span aria-hidden="true" style="font-size: 16px; line-height: 1;">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
<script>
   function handleGalleryDrop(event) {
           event.preventDefault();
       event.currentTarget.style.borderColor = '#ced4da';
       let files = event.dataTransfer.files;
       if (files.length) {
               let input = document.getElementById('gallery');
           let dt = new DataTransfer();
           for (let i = 0; i < input.files.length; i++) {
                   dt.items.add(input.files[i]);

           }
           for (let i = 0; i < files.length; i++) {
                   dt.items.add(files[i]);

           }
           input.files = dt.files;
           input.dispatchEvent(new Event('change', { bubbles: true }));
       }
     }
   function removeGalleryImageFromTemp(index) {
           let previews = document.querySelectorAll('#gallery-drop-area .position-relative.d-inline-block');
       if (previews[index]) {
               previews[index].remove();

       }
       let input = document.getElementById('gallery');
       if (input && input.files.length) {
               let dt = new DataTransfer();
           for (let i = 0; i < input.files.length; i++) {
                   if (i !== index) {
                       dt.items.add(input.files[i]);

               }
           }
           input.files = dt.files;
           input.dispatchEvent(new Event('change', { bubbles: true }));
       }
   }
/script>