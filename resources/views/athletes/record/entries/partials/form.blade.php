<div class="uk-margin-bottom">
    <label class="uk-form-label" for="title">Titel</label>
    <div class="uk-form-controls">
        <input class="uk-input" id="title" name="title" value="{{ old('title') }}">
    </div>
</div>

<div class="uk-margin-bottom">
    <label class="uk-form-label" for="content">Inhalt</label>
    <div class="uk-form-controls">
        <textarea class="uk-textarea" id="content" name="content" rows="10">{{ old('content') }}</textarea>
    </div>
</div>