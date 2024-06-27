@if (session('sukseshapus'))
    <div class="alert {{ session('sukseshapus') ? 'alert-sukseshapus' : 'alert-danger' }} alert-dismissible fade show"
        role="alert"
        style="{{ session('sukseshapus') ? 'background-color: #d4edda; color: #155724; border-color: #c3e6cb;' : 'background-color: #f8d7da; color: #721c24; border-color: #f5c6cb;' }}">
        <div>{{ session('sukseshapus') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script>
        setTimeout(function() {
            $('.alert').alert('close');
        }, 6000);
    </script>
@endif
