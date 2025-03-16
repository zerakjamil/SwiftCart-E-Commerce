@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Slide</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('admin.dashboard')}}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('slide.index') }}">
                            <div class="text-tiny">Slide</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit Slide</div>
                    </li>
                </ul>
            </div>
            <div class="wg-box">
                @if(Session::has('success'))
                    <div class="alert alert-success mb-4">{{Session::get('success')}}</div>
                @elseif(Session::has('error'))
                    <div class="alert alert-danger mb-4">{{Session::get('error')}}</div>
                @endif

                <form class="form-new-product form-style-1" method="POST" action="{{ route('slide.update', $slide->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <fieldset class="name">
                        <div class="body-title">Tagline <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Tagline" name="tagline" tabindex="0" value="{{$slide->tagline}}" aria-required="true" required="">
                    </fieldset>
                    @error('tagline') <span class="text text-danger">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title">Title <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Title" name="title" tabindex="0" value="{{$slide->title}}" aria-required="true" required="">
                    </fieldset>
                    @error('title') <span class="text text-danger">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title">Subtitle <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Subtitle" name="subtitle" tabindex="0" value="{{$slide->subtitle}}" aria-required="true" required="">
                    </fieldset>
                    @error('subtitle') <span class="text text-danger">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title">Link <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Link" name="link" tabindex="0" value="{{$slide->link}}" aria-required="true" required="">
                    </fieldset>
                    @error('link') <span class="text text-danger">{{$message}}</span> @enderror

                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">

                            <!-- Current Image Preview -->
                            <div class="current-image-preview mt-4">
                                <h4 class="text-sm font-medium mb-2">Current Image:</h4>
                                <div class="image-container" style="border-radius: 16px; padding: 10px; display: inline-block;">
                                    @if($slide->image)
                                        <img src="{{ asset('uploads/slides/' . $slide->image) }}" alt="Current Slide Image"
                                             style="max-width: 500px; max-height: 400px; object-fit: contain;">
                                    @else
                                        <p class="text-muted">No image available</p>
                                    @endif
                                </div>
                            </div>

                            <!-- New Image Preview -->
                            <div class="new-image-preview mt-3" id="imagePreviewContainer" style="display: none;">
                                <h4 class="text-sm font-medium mb-2">New Image Preview:</h4>
                                <div class="image-container" style="border: 1px solid #e0e0e0; border-radius: 8px; padding: 10px; display: inline-block;">
                                    <img id="imagePreview" src="#" alt="New Image Preview"
                                         style="max-width: 450px; max-height: 300px; object-fit: contain;">
                                </div>
                            </div>
                            <div class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span
                                            class="tf-color">click to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error('image') <span class="text text-danger">{{$message}}</span> @enderror

                    <fieldset class="category">
                        <div class="body-title">Status</div>
                        <div class="select flex-grow">
                            <select class="" name="status">
                                <option selected disabled>Select</option>
                                <option value="1" @if($slide->status === 1) selected @endif>Active</option>
                                <option value="0" @if($slide->status === 0) selected @endif>Inactive</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('status') <span class="text text-danger">{{$message}}</span> @enderror

                    <div class="bot">
                        <a href="{{ route('slide.index') }}" class="tf-button btn bg-danger border-0">Cancel</a>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
            <!-- /new-category -->
        </div>
        <!-- /main-content-wrap -->
    </div>

    <script>
        // Image preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('myFile');
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.addEventListener('load', function() {
                        previewImage.setAttribute('src', this.result);
                        previewContainer.style.display = 'block';
                    });

                    reader.readAsDataURL(file);
                } else {
                    previewContainer.style.display = 'none';
                }
            });
        });
    </script>
@endsection
