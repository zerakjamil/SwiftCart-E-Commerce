@extends('layouts.admin')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Edit Product</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.index') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{ route('product.index') }}">
                            <div class="text-tiny">Products</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Edit Product</div>
                    </li>
                </ul>
            </div>

            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{ route('product.store') }}">
                @csrf
                <div class="wg-box">
                    <!-- Product name -->
                    <fieldset class="name">
                        <div class="body-title mb-10">Product Name <span class="tf-color-1">*</span></div>
                        <input type="text" placeholder="Enter product name" name="name" value="{{ $product->name }}" required>
                        <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                        @error('name')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <!-- Slug -->
                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input type="text" placeholder="Enter product slug" name="slug" value="{{ $product->slug }}" required>
                        <div class="text-tiny">Do not exceed 100 characters when entering the slug.</div>
                        @error('slug')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <div class="gap22 cols">
                        <!-- Dynamic Category Select -->
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="category_id" required>
                                    <option value="">Choose category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{  $category->id == $product->category_id ? 'selected' : ''}}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>

                        <!-- Dynamic Brand Select -->
                        <fieldset class="brand">
                            <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="brand_id" required>
                                    <option value="">Choose Brand</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ $brand->id == $product->brand_id ? 'selected' : ''}}>
                                            {{ $brand->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('brand_id')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                    </div>

                    <!-- Short Description -->
                    <fieldset class="shortdescription">
                        <div class="body-title mb-10">Short Description <span class="tf-color-1">*</span></div>
                        <textarea class="ht-150" name="short_description" placeholder="Short Description" required>{{ $product->short_description }}</textarea>
                        <div class="text-tiny">Do not exceed 100 characters when entering the description.</div>
                        @error('short_description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <!-- Description -->
                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                        <textarea name="description" placeholder="Description" required>{{ $product->description }}</textarea>
                        <div class="text-tiny">Provide a detailed product description.</div>
                        @error('description')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>
                </div>

                <div class="wg-box">
                    <!-- Main Image Upload -->
                    <fieldset>
                        <div class="body-title">Upload Image <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display: {{$product->image ? '' : 'none'}}; position: relative;">
                                <img src="{{ $product->image ? asset('uploads/products/'.$product->image) : '' }}" class="effect8" alt="Image preview" style="cursor: pointer;">
                                <button type="button" id="removeImagePreview" style="position: absolute; top: 5px; right: 5px; background-color: #dc3545; border: none; color: #fff; padding: 2px 5px; font-size: 12px; border-radius: 3px;">
                                    <i class="icon-trash"></i>
                                </button>
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon"><i class="icon-upload-cloud"></i></span>
                                    <span class="body-text">Drop your image here or click to browse</span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                        @error('image')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>
                    <!-- Gallery Images Upload -->
                    <fieldset>
                        <div class="body-title mb-10">Upload Gallery Images</div>
                        <div class="upload-image mb-16">
                            <!-- Container for gallery image previews -->
                            <div id="gallery-preview" class="gallery-preview"></div>
                            <!-- File input container -->
                            <div id="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon"><i class="icon-upload-cloud"></i></span>
                                    <span class="text-tiny">Drop your images here or click to browse</span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                </label>
                            </div>
                        </div>
                        @error('images')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </fieldset>
                    <div class="cols gap22">
                        <!-- Regular Price -->
                        <fieldset class="name">
                            <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                            <input type="text" placeholder="Enter regular price" name="regular_price" value="{{ $product->regular_price }}" required>
                            @error('regular_price')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>

                        <!-- Sale Price -->
                        <fieldset class="name">
                            <div class="body-title mb-10">Sale Price <span class="tf-color-1">*</span></div>
                            <input type="text" placeholder="Enter sale price" name="sale_price" value="{{ $product->sale_price}}" required>
                            @error('sale_price')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <!-- SKU -->
                        <fieldset class="name">
                            <div class="body-title mb-10">SKU <span class="tf-color-1">*</span></div>
                            <input type="text" placeholder="Enter SKU" name="SKU" value="{{ $product->SKU }}" required>
                            @error('SKU')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>

                        <!-- Quantity -->
                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                            <input type="number" placeholder="Enter quantity" name="quantity" value="{{ $product->quantity }}" required>
                            @error('quantity')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                    </div>

                    <div class="cols gap22">
                        <!-- Stock Status -->
                        <fieldset class="name">
                            <div class="body-title mb-10">Stock</div>
                            <div class="select mb-10">
                                <select name="stock_status">
                                    <option value="instock" {{ $product->stock_status == 'instock' ? 'selected' : '' }}>In Stock</option>
                                    <option value="outofstock" {{ $product->stock_status == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                                </select>
                            </div>
                            @error('stock_status')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>

                        <!-- Featured -->
                        <fieldset class="name">
                            <div class="body-title mb-10">Featured</div>
                            <div class="select mb-10">
                                <select name="featured">
                                    <option value="0" {{ $product->featured == '0' ? 'selected' : '' }}>No</option>
                                    <option value="1" {{ $product->featured == '1' ? 'selected' : '' }}>Yes</option>
                                </select>
                            </div>
                            @error('featured')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </fieldset>
                    </div>

                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Edit Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#myFile').change(function (e) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#imgpreview').show();
                    $('#imgpreview img').attr('src', e.target.result);
                    $('#upload-file').hide();
                };
                reader.readAsDataURL(this.files[0]);
            });

            $('#imgpreview img').on('click', function () {
                if (!document.fullscreenElement) {
                    $(this).parent()[0].requestFullscreen().catch(err => {
                        console.error("Error attempting to enable full-screen mode:", err);
                    });
                } else {
                    document.exitFullscreen();
                }
            });

            $('#removeImagePreview').click(function () {
                $('#imgpreview').hide();
                $('#imgpreview img').attr('src', '');
                $('#upload-file').show();
                $('#myFile').val('');
            });

            let galleryFiles = [];

            function renderGallery() {
                $('#gallery-preview').empty();
                if (galleryFiles.length > 0) {
                    $('#galUpload').hide();
                } else {
                    $('#galUpload').show();
                }

                galleryFiles.forEach((file, index) => {
                    let reader = new FileReader();
                    reader.onload = function(e) {
                        let previewHtml = `
          <div class="gallery-item" data-index="${index}" style="position: relative; display: inline-block; margin: 5px;">
            <img src="${e.target.result}" alt="Gallery Preview" style="cursor: pointer; width: 100px; height: auto;">
            <button type="button" class="remove-gallery" style="position: absolute; top: 5px; right: 5px;
              background-color: #dc3545; border: none; color: #fff; padding: 2px 5px; font-size: 12px; border-radius: 3px;">
              <i class="icon-trash"></i>
            </button>
          </div>
        `;
                        $('#gallery-preview').append(previewHtml);
                    }
                    reader.readAsDataURL(file);
                });
            }

            $('#gFile').on('change', function(e) {
                let files = e.target.files;
                for (let i = 0; i < files.length; i++){
                    galleryFiles.push(files[i]);
                }
                renderGallery();
                $(this).val('');
            });

            $('#gallery-preview').on('click', '.remove-gallery', function() {
                let index = $(this).parent('.gallery-item').data('index');
                galleryFiles.splice(index, 1);
                renderGallery();
            });
        });
    </script>
@endpush
