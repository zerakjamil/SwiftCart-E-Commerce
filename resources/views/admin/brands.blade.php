@extends('layouts.admin')
@section('content')

        <div class="main-content-inner">
            <div class="main-content-wrap">
                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                    <h3>Brands</h3>
                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                        <li>
                            <a href="{{route('home.index')}}">
                                <div class="text-tiny">Dashboard</div>
                            </a>
                        </li>
                        <li>
                            <i class="icon-chevron-right"></i>
                        </li>
                        <li>
                            <div class="text-tiny">Brands</div>
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
                        <a class="tf-button style-1 w208" href="{{route('admin.create-brand')}}"><i
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
                                @if(count($brands) == 0)
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 italic">No brands found</td>
                                    </tr>
                                @endif
                                @foreach($brands as $brand)
                                <tr>
                                    <td>{{$brand->id}}</td>
                                    <td class="pname">
                                        <div class="image">
                                            <img src="{{asset('uploads/brands')}}/{{$brand->image}}" alt="{{$brand->name}}" class="image">
                                        </div>
                                        <div class="name">
                                            <a href="#" class="body-title-2">{{$brand->name}}</a>
                                        </div>
                                    </td>
                                    <td>{{$brand->slug}}</td>
                                    <td><a href="#" target="_blank">0</a></td>
                                    <td>
                                        <div class="list-icon-function">
                                            <a href="{{route('admin.edit-brand', $brand->id)}}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{route('admin.delete-brand', $brand->id)}}" method="POST" id="delete-form-{{ $brand->id }}" style="cursor: pointer;">
                                                @csrf
                                                @method('DELETE')
                                                <div class="item text-danger delete" onclick="event.preventDefault();getElementById('delete-form-{{ $brand->id }}').submit();">
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
                        <div class="divider"></div>
                        <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                            {{$brands->links('pagination::bootstrap-5')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
