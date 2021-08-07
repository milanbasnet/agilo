@foreach(LaravelLocalization::getSupportedLocales() as $key => $locale)

    <div class="uk-margin-bottom">
        <p class="uk-form-label">{{ trans('messages.language.label') }}</p>
        <p class="ag-readonly-form-text">{{ $locale['native'] }}</p>
    </div>

    <div class="uk-margin-bottom">
        <label class="uk-form-label" for="{{ $key }}.title">{{ trans('messages.title.label') }}</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="{{ $key }}.title" name="translation[{{ $key }}][title]" value="{{ old('translation.'. $key .'.title') }}">
        </div>
    </div>
@endforeach