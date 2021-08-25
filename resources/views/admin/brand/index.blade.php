<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('All Brand')}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong> {{session('success')}} </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <div class="card-header">All Brand</div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">SL No</th>
                                    <th scope="col">Brand Name</th>
                                    <th scope="col">Brand Image</th>
                                    <th scope="col">Create At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brand as $brd)
                                <tr>
                                    <th scope="row"> {{$brand->firstItem()+$loop->index}} </th>
                                    <td> {{$brd->brand_name}} </th>
                                    <td><img src="{{asset($brd->brand_image)}}" style="height:40px; width:70px"></td>
                                    <td>
                                        @if ($brd->created_at!=NULL)
                                        {{$brd->created_at->diffForHumans()}}
                                        @else
                                        <span class="text-danger">No Date</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('brand/edit/'.$brd->id)}}" class="btn btn-info">Edit</a>
                                        <a href="{{url('brand/delete/'.$brd->id)}}" onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$brand->links()}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Add Brand</div>
                        <div class="card-body">
                            <form action=" {{route('store.brand')}} " method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Brand Name</label>
                                    <input type="text" class="form-control" name="brand_name">
                                    @error('brand_name')
                                    <span class="text-danger"> {{$message}} </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Brand Image</label>
                                    <input type="file" class="form-control" name="brand_image">
                                    @error('brand_file')
                                    <span class="text-danger"> {{$message}} </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Brand</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>