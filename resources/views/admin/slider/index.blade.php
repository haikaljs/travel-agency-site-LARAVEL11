@extends('admin.layout.master')

@section('main_content')
    @include('admin.layout.nav')
    @include('admin.layout.sidebar')

    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Profile</h1>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="example1">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Photo</th>
                                                <th>Heading</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sliders as $slider)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <img src="{{ asset('uploads/' . $slider->photo) }}" alt=""
                                                            class="w_200">
                                                    </td>
                                                    <td>$40</td>
                                                    <td class="pt_10 pb_10">
                                                        <a href="" class="btn btn-primary"><i
                                                                class="fas fa-edit"></i></a>
                                                        <a href="" class="btn btn-danger"
                                                            onClick="return confirm('Are you sure?');"><i
                                                                class="fas fa-trash"></i></a>
                                                    </td>

                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
