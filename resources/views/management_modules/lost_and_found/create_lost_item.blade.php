<!DOCTYPE html>
<html lang="en">
@include('management_components/header')
<body>
    <div class="container-fluid">
        @include('management_components/sidebar')
        @include('management_components/topbar')
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <h1 class="h2">Report a Lost Item</h1>
            <form method="POST" action="{{ route('lost_and_found.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="">Select a Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
                <div class="form-group">
                    <label for="contact_info">Contact Info</label>
                    <input type="text" class="form-control" id="contact_info" name="contact_info" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </main>
    </div>
    @include('management_components/script')
</body>
</html>
