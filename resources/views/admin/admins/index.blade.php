@extends('layouts.admin')
@section('content')

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Brands</h3>
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
                        <div class="text-tiny">Admins</div>
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
                    <a class="tf-button style-1 w208" href="{{route('admin.create')}}"><i
                            class="icon-plus"></i>Add new admin</a>
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($admins) == 0)
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 italic">No Admins found</td>
                                </tr>
                            @endif
                            @foreach($admins as $admin)
                                <tr>
                                    <td class="name d-flex align-items-center  gap10">
                                            <span class="avatar bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                                            </span>
                                            <a href="#" class="body-title-2">{{$admin->name}}</a>
                                    </td>
                                    <td>{{$admin->email}}</td>
                                    <td><a href="#" target="_blank">{{ $admin->roles->pluck('name')->implode(', ') }}</a></td>
                                    <td>
                                        <div class="list-icon-function">
                                            <a href="{{route('admin.edit', $admin->id)}}">
                                                <div class="item edit">
                                                    <i class="icon-edit-3"></i>
                                                </div>
                                            </a>
                                            <form action="{{route('admin.destroy', $admin->id)}}" method="POST" id="delete-form-{{ $admin->id }}" style="cursor: pointer;">
                                                @csrf
                                                @method('DELETE')
                                                <div class="item text-danger delete delete-confirmation" >
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
                        {{$admins->links('pagination::bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-script
            title="Delete Admin"
        text="Once deleted, you will not be able to recover this record!">
    </x-confirmation-script>
@endsection


