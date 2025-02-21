@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Category Information</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('category.index') }}">
                            <div class="text-tiny">Categories</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">New Category</div></li>
                </ul>
            </div>
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Category Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Category name" name="name"
                               value="{{ old('name') }}" required>
                        @error('name')
                        <div class="text-tiny alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Category Slug <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Category Slug" name="slug"
                               value="{{ old('slug') }}" required>
                        @error('slug')
                        <div class="text-tiny alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset>
                        <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display: none;">
                                <div class="preview-container">
                                    <img src="#" alt="Preview" class="effect8">
                                    <div class="image-overlay">
                                        <button type="button" class="overlay-btn preview-btn" title="Preview">
                                            <i class="icon-eye"></i>
                                        </button>
                                        <button type="button" class="overlay-btn delete-btn" title="Delete">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon"><i class="icon-upload-cloud"></i></span>
                                    <span class="body-text">Drop your image here or <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*" required>
                                </label>
                            </div>
                        </div>
                        @error('image')
                        <div class="text-tiny alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div class="preview-modal" id="previewModal">
        <button class="close-modal">×</button>
        <img src="" alt="Full Preview">
    </div>
@endsection

@push('styles')
    <style>
        .upload-image {
            position: relative;
            width: 100%;
            max-width: 400px;
        }

        .upload-image .item {
            position: relative;
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .upload-image .item:hover {
            border-color: #4a90e2;
        }

        .upload-image .preview-container {
            position: relative;
            display: inline-block;
        }

        .preview-container img {
            max-width: 124px;
            border-radius: 8px;
            display: block;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            border-radius: 8px;
            display: none;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .preview-container:hover .image-overlay {
            display: flex;
        }

        .overlay-btn {
            background: white;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .overlay-btn:hover {
            background: #f0f0f0;
        }

        .preview-modal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .preview-modal.active {
            display: flex;
        }

        .preview-modal img {
            max-width: 90%;
            max-height: 90vh;
            border-radius: 8px;
        }

        .preview-modal .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            background: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .uploadfile {
            cursor: pointer;
            display: block;
            width: 100%;
            height: 100%;
            min-height: 124px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .uploadfile.highlight {
            border-color: #4a90e2;
            background-color: rgba(74, 144, 226, 0.1);
        }

        /* Hidden file input */
        .uploadfile input[type="file"] {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const myFile = document.getElementById('myFile');
            const imgPreview = document.getElementById('imgpreview');
            const uploadFile = document.getElementById('upload-file');
            const previewImg = imgPreview.querySelector('img');
            const previewModal = document.getElementById('previewModal');
            const modalImg = previewModal.querySelector('img');
            const closeModal = previewModal.querySelector('.close-modal');
            const previewBtn = imgPreview.querySelector('.preview-btn');
            const deleteBtn = imgPreview.querySelector('.delete-btn');

            // File Upload Handler
            myFile.addEventListener('change', function(e) {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        modalImg.src = e.target.result;
                        imgPreview.style.display = 'block';
                        uploadFile.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Delete Image Handler
            function deleteImage() {
                previewImg.src = '';
                modalImg.src = '';
                myFile.value = '';
                imgPreview.style.display = 'none';
                uploadFile.style.display = 'block';
                previewModal.classList.remove('active');
            }

            deleteBtn.addEventListener('click', deleteImage);

            // Preview Modal Handlers
            previewBtn.addEventListener('click', function() {
                previewModal.classList.add('active');
            });

            closeModal.addEventListener('click', function() {
                previewModal.classList.remove('active');
            });

            previewModal.addEventListener('click', function(e) {
                if (e.target === previewModal) {
                    previewModal.classList.remove('active');
                }
            });

            // Drag and Drop Handlers
            const dropZone = uploadFile.querySelector('.uploadfile');

            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                dropZone.classList.add('highlight');
            }

            function unhighlight(e) {
                dropZone.classList.remove('highlight');
            }

            dropZone.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const file = dt.files[0];
                myFile.files = dt.files;

                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        modalImg.src = e.target.result;
                        imgPreview.style.display = 'block';
                        uploadFile.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                }
            }

            // Slug generation from name
            document.querySelector('input[name="name"]').addEventListener('input', function() {
                const name = this.value;
                const slug = name.toLowerCase()
                    .replace(/ /g, '-')
                    .replace(/[^\w-]+/g, '');
                document.querySelector('input[name="slug"]').value = slug;
            });
        });
    </script>
@endpush
