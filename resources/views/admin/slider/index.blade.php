@extends('admin.admin_master')

@section('admin')

<div class="py-12">
    <div class="container">
        <div class="row">
            <div>
                <div>
                    <h2>Home Slider</h2>
                </div>
                <div>
                    <a href="{{route('store.slider')}}">
                        <button class="btn btn-info">Add Slider</button>
                    </a>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> {{session('success')}} </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="card-header">All Slider</div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">SL No</th>
                                <th scope="col">Slider Title</th>
                                <th scope="col">Slider Desc</th>
                                <th scope="col">Slider Image</th>
                                <th scope="col">Create At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($slider as $sld)
                            <tr>
                                <th scope="row"> {{$slider->firstItem()+$loop->index}} </th>
                                <td> {{$sld->title}} </th>
                                <td> {{$sld->description}} </th>
                                <td><img src="{{asset($sld->image)}}" style="height:40px; width:70px"></td>
                                <td>
                                    @if ($sld->created_at!=NULL)
                                    {{$sld->created_at->diffForHumans()}}
                                    @else
                                    <span class="text-danger">No Date</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{url('slider/edit/'.$sld->id)}}" class="btn btn-info">Edit</a>
                                    <a href="{{url('slider/delete/'.$sld->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$slider->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection