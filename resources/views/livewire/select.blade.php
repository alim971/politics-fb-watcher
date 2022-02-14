<div>
    <div class="form-group">
        <label for="politicianId"
               class="control-label">Politician</label>
        <select name="politicianId" id="politicianId" class="form-control" wire:click="changeEvent($event.target.value)">
            <option value="" selected>--</option>
            @foreach($politicians as $politician)
                <option value="{{ $politician->id }}" {{ $politicianId && $politician->id == $politicianId ? 'selected' : '' }}>{{  $politician->fullName() }}</option>
            @endforeach
        </select>
    </div>
    @if($politicianId)
    <div class="form-group">
        <label for="politicianId"
               class="control-label">Politician</label>
        <select name="politicianId" id="politicianId" class="form-control">
            <option value=""selected>--</option>
            @foreach($posts as $posts)
                <option value="{{ $post->id }}" {{ $postId && $post->id == $postId ? 'selected' : '' }} >{{ $post->firstWords(15) }}</option>
            @endforeach
        </select>
    </div>
    @endif
</div>
