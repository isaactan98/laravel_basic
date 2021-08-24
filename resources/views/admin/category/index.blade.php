<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{__('All Category')}}
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
                        <div class="card-header">All Category</div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">SL No</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Create At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($category as $cat)
                                <tr>
                                    <th scope="row"> {{$category->firstItem()+$loop->index}} </th>
                                    <td> {{$cat->category_name}} </th>
                                    <td> {{$cat->user->name}} </td>
                                    <td>
                                        @if ($cat->created_at!=NULL)
                                        {{$cat->created_at->diffForHumans()}}
                                        @else
                                        <span class="text-danger">No Date</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('category/edit/'.$cat->id)}}" class="btn btn-info">Edit</a>
                                        <a href="{{url('softdel/category/'.$cat->id)}}" class="btn btn-danger">Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$category->links()}}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Add Category</div>
                        <div class="card-body">
                            <form action=" {{route('store.category')}} " method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Category Name</label>
                                    <input type="text" class="form-control" name="category_name">
                                    @error('category_name')
                                    <span class="text-danger"> {{$message}} </span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--  -->
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Trash Category</div>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">SL No</th>
                                    <th scope="col">Category Name</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Create At</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trashCat as $trash)
                                <tr>
                                    <th scope="row"> {{$trashCat->firstItem()+$loop->index}} </th>
                                    <td> {{$trash->category_name}} </th>
                                    <td> {{$trash->user->name}} </td>
                                    <td>
                                        @if ($trash->created_at!=NULL)
                                        {{$trash->created_at->diffForHumans()}}
                                        @else
                                        <span class="text-danger">No Date</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{url('category/restore/'.$trash->id)}}" class="btn btn-info">Restore</a>
                                        <a href="{{url('category/delete/'.$trash->id)}}" class="btn btn-danger">P-Delete</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$trashCat->links()}}
                    </div>
                </div>
                <div class="col-md-4">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>