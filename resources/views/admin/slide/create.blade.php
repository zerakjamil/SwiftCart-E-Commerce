@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Slide</h3>
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
                        <div class="text-tiny">New Slide</div>
                    </li>
                </ul>
            </div>
            <div class="wg-box">
                 @if(Session::has('success'))
                    <div class="alert alert-success">{{Session::get('success')}}</div>
                  @elseif(Session::has('error'))
                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                  @endif
                <form class="form-new-product form-style-1" method="POST" action="{{ route('slide.store') }}" enctype="multipart/form-data">
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Tagline <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Tagline" name="tagline" tabindex="0" value="{{old('tagline')}}" aria-required="true" required="">
                    </fieldset>
                    @error('tagline') <span class="text text-danger">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title">Title <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Title" name="title" tabindex="0" value="{{old('title')}}" aria-required="true" required="">
                    </fieldset>
                    @error('title') <span class="text text-danger">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title">Subtitle <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Subtitle" name="subtitle" tabindex="0" value="{{old('subtitle')}}" aria-required="true" required="">
                    </fieldset>
                    @error('subtitle') <span class="text text-danger">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title">Link <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Link" name="link" tabindex="0" value="{{old('link')}}" aria-required="true" required="">
                    </fieldset>
                    @error('link') <span class="text text-danger">{{$message}}</span> @enderror

                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="image-preview mt-3" id="imagePreviewContainer" style="display: none;">
                                <img id="imagePreview" src="#" alt="Image Preview" style="max-width: 500px; max-height: 400px; object-fit: contain; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
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
                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </fieldset>
                    @error('status') <span class="text text-danger">{{$message}}</span> @enderror
                    <div class="bot">
                        <div></div>
                        <button class="tf-button w208" type="submit">Save</button>
                    </div>
                </form>
            </div>
            <!-- /new-category -->
        </div>
        <!-- /main-content-wrap -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image preview functionality
            const fileInput = document.getElementById('myFile');
            const imagePreview = document.getElementById('imagePreview');
            const previewContainer = document.getElementById('imagePreviewContainer');

            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        previewContainer.style.display = 'block';
                    };

                    reader.readAsDataURL(this.files[0]);
                } else {
                    previewContainer.style.display = 'none';
                }
            });
        });
    </script>
@endsection
