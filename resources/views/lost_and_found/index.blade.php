<!DOCTYPE html>
<html lang="en">
@include('resident_components/header')
<body>
    <div class="container-fluid">
        <div class="row">
            @include('resident_components/sidebar')
            @include('resident_components/topbar')
            <main role="main" class="col-md-10 ml-sm-auto col-lg-10 px-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Lost and Found</h1>
                    <a href="{{ route('lost_and_found.create') }}" class="btn btn-theme mb-3">Report Lost Item</a>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <form action="{{ route('lost_and_found.search') }}" method="POST">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="category">Category</label>
                                    <select id="category" name="category_id" class="form-control">
                                        <option value="">Choose...</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="status">Filter by Status:</label>
                                    <select id="status" name="status" class="form-control">
                                        <option value="">All</option>
                                        <option value="Open">Open</option>
                                        <option value="Found">Found</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="keyword">Keyword</label>
                                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Enter keyword">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Enter location">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-theme">Search</button>
                        </form>
                        <hr>
                        <div class="list-group">
                            @foreach($lostItems as $lostItem)
                                <a href="{{ route('lost_and_found.show', $lostItem->id) }}" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ $lostItem->title }} 
                                            <span class="badge badge-{{ $lostItem->status == 'Open' ? 'primary' : 'success' }}">
                                                {{ $lostItem->status }}
                                            </span>
                                        </h5>
                                        <small>{{ $lostItem->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-1">{{ $lostItem->description }}</p>
                                    <small>Location: {{ $lostItem->location }}</small>
                                    
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    @include('resident_components/script')
</body>
</html>
