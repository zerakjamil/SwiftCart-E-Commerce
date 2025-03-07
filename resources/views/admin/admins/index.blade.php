@extends('layouts.admin')
@section('content')

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Admins</h3>
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
                <div class="flex items-center justify-between gap10 flex-wrap mb-4">
                    <div class="wg-filter flex-grow">
                        <form class="form-search">
                            <fieldset class="name">
                                <input type="text" placeholder="Search by name or email..." class="form-control" name="name"
                                       tabindex="2" value="{{ request()->name ?? '' }}">
                            </fieldset>
                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <a class="tf-button style-1 w208" href="{{route('admin.create')}}">
                        <i class="icon-plus"></i>Add new admin
                    </a>
                </div>

                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{Session::get('success')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @elseif(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{Session::get('error')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <table class="table table-hover admin-table">
                            <thead>
                            <tr>
                                <th class="sortable" data-sort="name">
                                    <div class="d-flex align-items-center gap-2">
                                        Name <i class="icon-chevron-down fs-6"></i>
                                    </div>
                                </th>
                                <th class="sortable" data-sort="email">
                                    <div class="d-flex align-items-center gap-2">
                                        Email <i class="icon-chevron-down fs-6"></i>
                                    </div>
                                </th>
                                <th>Role</th>
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($admins) == 0)
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="icon-users text-muted" style="font-size: 2.5rem;"></i>
                                            <p class="mt-3 text-muted">No admin accounts found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @foreach($admins as $admin)
                                <tr>
                                    <td class="name">
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="avatar-wrapper">
                                                <span class="avatar" style="background-color: {{ '#' . substr(md5($admin->name), 0, 6) }}">
                                                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <p class="body-title-2 mb-0">{{$admin->name}}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="icon-mail text-muted"></i>
                                            <span>{{$admin->email}}</span>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach($admin->roles as $role)
                                            <span class="role-badge role-{{ strtolower($role->name) }}">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{route('admin.edit', $admin->id)}}" class="action-btn edit" data-bs-toggle="tooltip" title="Edit admin">
                                                <i class="icon-edit-3"></i>
                                            </a>
                                            <form action="{{route('admin.destroy', $admin->id)}}" method="POST" id="delete-form-{{ $admin->id }}" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="action-btn delete delete-confirmation" data-id="{{ $admin->id }}" data-bs-toggle="tooltip" title="Delete admin">
                                                    <i class="icon-trash-2"></i>
                                                </button>
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
            </div>        </div>
    </div>

    <x-confirmation-script
            title="Delete Admin"
        text="Once deleted, you will not be able to recover this record!">
    </x-confirmation-script>
@endsection

@push('styles')
    <style>
    /* Add this to your CSS */
    .admin-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .admin-table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        padding: 1rem;
        font-weight: 600;
        color: #344054;
    }

    .admin-table tbody tr {
        transition: all 0.2s ease;
    }

    .admin-table tbody tr:hover {
        background-color: rgba(35, 119, 252, 0.05);
    }

    .admin-table td {
        padding: 1rem;
        vertical-align: middle;
    }

    .sortable {
        cursor: pointer;
    }

    .avatar-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 16px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        height: 24px;
        padding: 0 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .role-admin {
        background-color: rgba(35, 119, 252, 0.1);
        color: #2377FC;
    }

    .role-manager {
        background-color: rgba(7, 132, 7, 0.1);
        color: #078407;
    }

    .role-user {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: transparent;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .action-btn.edit:hover {
        color: #2377FC;
    }

    .action-btn.delete:hover {
        color: #dc3545;
    }

    @media (max-width: 768px) {
        .admin-table {
            border-radius: 0;
        }

        .avatar {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
    }
    </style>
 @endpush

@push('scripts')
<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Sorting functionality
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const sort = this.dataset.sort;
            const currentUrl = new URL(window.location);

            if (currentUrl.searchParams.get('sort') === sort) {
                if (currentUrl.searchParams.get('direction') === 'asc') {
                    currentUrl.searchParams.set('direction', 'desc');
                } else {
                    currentUrl.searchParams.set('direction', 'asc');
                }
            } else {
                currentUrl.searchParams.set('sort', sort);
                currentUrl.searchParams.set('direction', 'asc');
            }

            window.location = currentUrl.toString();
        });
    });
</script>
@endpush
