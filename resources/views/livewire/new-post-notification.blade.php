<div class="flex items-center">
    @if(isset($del))
    @auth
        <form action="{{ $del }}" class="inline" method="post">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger deleteConfirm" type="submit"><i class="fa fa-trash"></i></button>
        </form>
    @endauth
    @endif
    <a href="{{ $route }}" class="text-indigo-600 hover:text-indigo-900">
        <div>
            Zobraziť
            <svg viewBox="0 0 20 20" style="display:inline" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </div>
    </a>
    @if($isNew)
        <div class="flex-shrink-0 notification-new shadow">
            <div class="notification-text">Nový</div>
        </div>
    @endif
</div>
