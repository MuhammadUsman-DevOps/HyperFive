@extends('layouts.master')
@section('title', 'All Users')
@section('extra_styles')

    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection('extra_styles')

@section('main_content')
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Content-->
            <!--begin::Step 1-->
            <div class="card card-flush py-4 mb-5">
                <!--begin::Card header-->
                <div class="card-header">
                    <div class="card-title">
                        <h2>Users</h2>
                    </div>

                    <div class="card-toolbar">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" >
                            <!--begin::Add users-->
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New User</a>
                            <!--end::Add users-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-0">
                    <table id="kt_datatable_example_1" class="table table-striped table-row-bordered gy-5 gs-7">
                        <thead>
                        <tr class="fw-bolder fs-6 text-gray-800 px-7">
                            <th class="min-w-100px">Email Address</th>
                            <th class="min-w-100px text-end">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user["email"] }}</td>

                                <td>
                                    <div class="d-flex justify-content-end flex-shrink-0">

                                        <!-- Edit Button -->
                                        <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm editUserBtn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editUserModal"
                                                data-user-id="{{ $user['userId'] }}"
                                                data-email="{{ $user['email'] }}"
                                                data-tenant-id="{{ $tenantId }}">
            <span class="svg-icon svg-icon-3">
                <!-- SVG icon for edit -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor"></path>
                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor"></path>
                </svg>
            </span>
                                        </button>
                                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                                            <!--begin::Svg Icon | path: icons/duotune/general/gen027.svg-->
                                            <span class="svg-icon svg-icon-3">
																				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
																					<path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor"></path>
																					<path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor"></path>
																					<path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor"></path>
																				</svg>
																			</span>
                                            <!--end::Svg Icon-->
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Step 1-->
            <!--end::Content-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->


    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" action="{{ route('create_user') }}" method="POST" onsubmit="return validateForm()">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <input type="text" class="form-control d-none" id="tenantId" name="tenantId" value="{{ $tenantId }}" >
                        </div>
                        <div class="mb-3">
                            <label for="encryptedPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="encryptedPassword" name="encryptedPassword" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        </div>
                        <div class="alert alert-danger d-none" id="errorMessage"></div>
                        <button type="submit" class="btn btn-primary w-100">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editUserForm" action="{{ route('update_user') }}" method="POST" onsubmit="return validateUpdateForm()">
                        @csrf
                        <input type="hidden" id="editUserId" name="userId">
                        <input type="hidden" id="editTenantId" name="tenantId">

                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="editPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="editPassword" name="encryptedPassword">
                        </div>

                        <div class="mb-3">
                            <label for="editConfirmPassword" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="editConfirmPassword" name="confirmPassword">
                        </div>

                        <div class="alert alert-danger d-none" id="editErrorMessage"></div>
                        <button type="submit" class="btn btn-primary w-100">Update User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("extra_scripts")
    <script>
        function validateForm() {
            let password = document.getElementById('encryptedPassword').value;
            let confirmPassword = document.getElementById('confirmPassword').value;
            let errorMessage = document.getElementById('errorMessage');

            if (password !== confirmPassword) {
                errorMessage.textContent = 'Passwords do not match';
                errorMessage.classList.remove('d-none');
                return false;
            }
            return true;
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // When edit button is clicked, populate modal with user data
            document.querySelectorAll(".editUserBtn").forEach(button => {
                button.addEventListener("click", function () {
                    let userId = this.getAttribute("data-user-id");
                    let email = this.getAttribute("data-email");
                    let tenantId = this.getAttribute("data-tenant-id");

                    document.getElementById("editUserId").value = userId;
                    document.getElementById("editEmail").value = email;
                    document.getElementById("editTenantId").value = tenantId;
                });
            });
        });

        function validateUpdateForm() {
            let password = document.getElementById('editPassword').value;
            let confirmPassword = document.getElementById('editConfirmPassword').value;
            let errorMessage = document.getElementById('editErrorMessage');

            if (password && password !== confirmPassword) {
                errorMessage.textContent = 'Passwords do not match';
                errorMessage.classList.remove('d-none');
                return false;
            }
            return true;
        }
    </script>
@endsection
