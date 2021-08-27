@extends('admin.admin_master')

@section('admin')

<div class="py-12">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Slider</div>
                    <div class="card-body">
                        <form action=" {{route('add.slider')}} " method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Slider Title</label>
                                <input type="text" class="form-control" name="title">
                                @error('title')
                                <span class="text-danger"> {{$message}} </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slider Description</label>
                                <input type="text" class="form-control" name="description">
                                @error('description')
                                <span class="text-danger"> {{$message}} </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Slider Image</label>
                                <input type="file" class="form-control" name="image">
                                @error('image')
                                <span class="text-danger"> {{$message}} </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Add Slider</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection