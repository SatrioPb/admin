<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
    @include ('template.head')

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        @include ('template.sidebar')
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('template.navbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            User</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$userCount}}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DataTables Example -->
                    <div class="card shadow-lg mb-4">
                        <div class="card-header py-2 bg-primary text-white">
                            <h6 class="m-0 font-weight-bold">User Data</h6>
                        </div>

                        <div class="card-body">
                            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                                <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                        class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                            </div>
                            <!-- Filter Dropdown -->
                            <form method="GET" action="{{ route('user.filter') }}">
                                <div class="form-row align-items-end">
                                    <!-- Filter by Province -->
                                    <div class="form-group col-md-4 mb-3">
                                        <label for="province_filter">Select Province:</label>
                                        <select class="form-control" id="province_filter" name="province_id">
                                            <option value="">All Provinces</option>
                                            @foreach($provinces as $province)
                                            <option value="{{ $province->id }}"
                                                {{ request('province_id') == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filter by City -->
                                    <div class="form-group col-md-4 mb-3">
                                        <label for="city_filter">Select City:</label>
                                        <select class="form-control" id="city_filter" name="city_id">
                                            <option value="">All Cities</option>
                                            @foreach($cities as $city)
                                            <option value="{{ $city->id }}"
                                                {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Filter by Start Date -->
                                    <div class="form-group col-md-4 mb-3">
                                        <label for="start_date">Start Date:</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                                    </div>

                                    <!-- Filter by End Date -->
                                    <div class="form-group col-md-4 mb-3">
                                        <label for="end_date">End Date:</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                                    </div>

                                    <!-- Filter Button -->
                                    <div class="form-group col-md-2 mb-3">
                                        <button type="submit" class="btn btn-primary btn-block">Apply Filters</button>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->profile ? $user->profile->contact : '-' }}</td>
                                            <td>
                                                <a href="{{ route('user.view', $user->id) }}" class="btn btn-primary btn-sm" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Edit"><i class="fa fa-pen"></i></a>
                                                <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    <!-- Bootstrap Tooltip Script -->
                    <script>
                        $(function() {
                            $('[data-toggle="tooltip"]').tooltip();
                        });
                    </script>


                </div>



            </div>
            <!-- Footer -->
            @include ('template.footer')
            <!-- End of Footer -->
        </div>





        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="login.html">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript-->
        @include ('template.script')

</body>

</html>