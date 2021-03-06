@extends('layouts.admin')

@section('title')
    <span>All Blog Post</span> <a class="btn btn-success" href="{{ url()->current() }}/create">Add blog post</a>
@endsection

@section('content')
    <div class="flash-message">
      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
          @if(Session::has('alert-' . $msg))

          <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
          
          @endif
      @endforeach
    </div>
    
    <div class="container">
      <table id="blog_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Title</th>
            <th>Author Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($blogs as $blog)
            <tr>
              <td>{{ $blog->title }}</td>
              <td>{{ $blog->author }}</td>
              <td style="text-align: center;">
                <a style="margin:1px" class="btn btn-danger" href="{{ url()->current() }}/delete/{{ $blog->id }}" onclick="return confirm('Are you sure you would like to delete this blog post. This process cannot be reversed.')">Delete</a>
                <a style="margin:1px" class="btn btn-warning" href="{{ url()->current() }}/edit/{{ $blog->id }}">Edit</a>                     
              </td>
            </tr>
          @endforeach
        </tbody>
    </table>
    </div>

@endsection

@section('js')
    
<script>
    $(document).ready(function() {
        $('#blog_table').DataTable();
    } );
</script>

@endsection