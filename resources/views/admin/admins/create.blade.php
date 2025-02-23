@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Admin Information</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('brand.index') }}">
                            <div class="text-tiny">Admins</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Create New Admin</div></li>
                </ul>
            </div>
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.store') }}" method="POST" >
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Admin Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Admin name" name="name"
                               value="{{ old('name') }}" required>
                        @error('name')
                        <div class="text-tiny alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Admin Email <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="email" placeholder="Admin Email" name="email"
                               value="{{ old('email') }}" required>
                        @error('slug')
                        <div class="text-tiny alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Password<span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="password" placeholder="Password" name="password"
                               value="{{ old('password') }}" required>
                        @error('slug')
                        <div class="text-tiny alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>
                    <fieldset class="name">
                        <div class="body-title">Confirm Password<span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="password" placeholder="Confirm Password"
                               name="password_confirmation"
                               required>
                        @error('password_confirmation')
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

