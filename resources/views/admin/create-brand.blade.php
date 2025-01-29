@extends('layouts.admin')
@section('content')

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Brand Information</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('home.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li>
                        <a href="{{ route('admin.brands') }}">
                            <div class="text-tiny">Brands</div>
                        </a>
                    </li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">New Brand</div></li>
                </ul>
            </div>
            <div class="wg-box">
                <form class="form-new-product form-style-1" action="{{ route('admin.store-brand') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <fieldset class="name">
                        <div class="body-title">Brand Name <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Brand name" name="name"
                               value="{{ old('name') }}" required>
                        @error('name')
                        <div class="text-tiny alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="name">
                        <div class="body-title">Brand Slug <span class="tf-color-1">*</span></div>
                        <input class="flex-grow" type="text" placeholder="Brand Slug" name="slug"
                               value="{{ old('slug') }}" required>
                        @error('slug')
                        <div class="text-tiny alert alert-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset>
                        <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none">
                                <img src="#" class="effect8" alt="Preview" style="max-width: 124px;">
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

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // Image Preview
            $('#myFile').on("change", function(e) {
                const [file] = e.target.files;
                if (file) {
                    const preview = $("#imgpreview");
                    preview.find('img').attr('src', URL.createObjectURL(file));
                    preview.show();
                }
            });

            // Auto-generate slug from name
            $("input[name='name']").on("input", function() {
                const name = $(this).val();
                const slug = StringToSlug(name);
                $("input[name='slug']").val(slug);
            });
        });

        function StringToSlug(text) {
            return text.toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '');
        }
    </script>
@endpush
