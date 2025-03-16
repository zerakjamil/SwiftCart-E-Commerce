@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Slides</h3>
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
                        <div class="text-tiny">Slider</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name" tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{ route('slide.create') }}"><i
                            class="icon-plus"></i>Add new</a>
                </div>
                <div class="wg-table table-all-user">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Tagline</th>
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Link</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if($slides->count() > 0)
                            @foreach($slides as $slide)
                                <tr>
                                    <td>{{$slide->id}}</td>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{asset('uploads/slides/'.$slide->image)}}" alt="{{$slide->title}}"
                                                 class="image">
                                        </div>
                                    </td>
                                    <td>{{$slide->tagline}}</td>
                                    <td>{{$slide->title}}</td>
                                    <td>{{$slide->subtitle}}</td>
                                    <td>{{$slide->link}}</td>
                                    <td>
                                        <div class="list-icon-function">
                                            <a href="{{route('slide.edit', $slide->id)}}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{route('slide.destroy', $slide->id)}}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <div class="item text-danger delete delete-confirmation">
                                                    <i class="icon-trash-2"></i>
                                                </div>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="icon-image text-muted" style="font-size: 3rem;"></i>
                                        <p class="mt-3">No slides found. Click "Add new" to create your first slide.</p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{$slides->links('pagination::bootstrap-5')}}
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-script
        title="Delete Slide"
        text="Once deleted, you will not be able to recover this Slide!">
    </x-confirmation-script>
@endsection
