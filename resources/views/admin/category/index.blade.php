@extends('layouts.admin')
@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Categories</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Categories</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search here..." class="" name="name"
                                       tabindex="2" value="" aria-required="true" required="">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{route('category.create')}}"><i
                            class="icon-plus"></i>Add new</a>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                    @if(Session::has('success'))
                        <div class="alert alert-success">{{Session::get('success')}}</div>
                    @elseif(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Products</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($categories) == 0)
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 italic">No categories found</td>
                            </tr>
                        @endif
                        @foreach($categories as $category)
                        <tr>
                            <td>{{$category->id}}</td>
                            <td class="pname">
                                <div class="image">
                                    <img src="{{asset('uploads/categories/'.$category->image)}}" alt="{{$category->name}}" class="image">
                                </div>
                                <div class="name">
                                    <a href="#" class="body-title-2">{{$category->name}}</a>
                                </div>
                            </td>
                            <td>{{$category->slug}}</td>
                            <td><a href="#" target="_blank">2</a></td>
                            <td>
                                <div class="list-icon-function">
                                    <a href="{{route('category.edit',$category->id)}}">
                                        <div class="item edit">
                                            <i class="icon-edit-3"></i>
                                        </div>
                                    </a>
                                    <form action="{{route('category.destroy',$category->id)}}" method="POST">
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
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{$categories->links('pagination::bootstrap-5')}}
                </div>
            </div>
        </div>
    </div>
    <x-confirmation-script
        title="Delete Category"
        text="Once deleted, you will not be able to recover this category!">
    </x-confirmation-script>
@endsection

