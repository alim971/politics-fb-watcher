<div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">
    <div class="form-group">
        <label for="politicianId"
               class="control-label">Politician</label>
        <select name="politicianId" id="politicianId" class="form-control" wire:model="selectedPolitician">
            <option value="">--</option>
            @foreach($politicians as $politician)
                <option value="{{ $politician->id }}">{{  $politician->fullName() }}</option>
            @endforeach
        </select>
    </div>
    @if($selectedPolitician)
    <div class="form-group">
        <label for="postId"
               class="control-label">Post</label>
        <select name="postId" id="postId" class="form-control" wire:model="selectedPost" style="max-width: 100%">
            <option value="">--</option>
            @php
                $table = new App\Models\Post;
                $table->setTable($politicians->find($selectedPolitician)->nick());
                $posts = $table->get()->sortByDesc('date');
            @endphp
            @foreach($posts as $post)
                <option value="{{ $post->id }}"  >{{ $post->firstWords(15) }}</option>
            @endforeach
        </select>
    </div>
    @endif
    @if(!is_null($text))
        <div class="mt-6 text-gray-500">
            {!! $text !!}
        </div>
    @endif
</div>
