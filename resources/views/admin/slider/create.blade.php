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
                                <form action="{{ route('admin_slider_store') }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Photo</label>
                                        <div>
                                            <input type="file" name="photo">
                                        </div>

                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Heading *</label>
                                        <input type="text" class="form-control" name="heading"
                                            value="{{ old('heading') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Text *</label>
                                        <textarea type="text" class="form-control h_100" name="text" value="{{ old('text') }}">
                                        </textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Button Text</label>
                                        <input type="text" class="form-control" name="button_text"
                                            value="{{ old('button_text') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Button Link</label>
                                        <input type="text" class="form-control" name="button_link"
                                            value="{{ old('button_link') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"></label>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
