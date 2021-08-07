@foreach(LaravelLocalization::getSupportedLocales() as $key => $locale)

    <div class="uk-margin-bottom">
        <label class="uk-form-label" for="{{ $key }}.starting_position">{{ trans('messages.starting_position.label') }}</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="{{ $key }}.starting_position" name="translation[{{ $key }}][starting_position]" value="{{ old('translation.'. $key .'.starting_position') }}">
        </div>
    </div>
    <div class="uk-margin-bottom">
        <label class="uk-form-label" for="{{ $key }}.execution">{{ trans('messages.execution.label') }}</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="{{ $key }}.execution" name="translation[{{ $key }}][execution]" value="{{ old('translation.'. $key .'.execution') }}">
        </div>
    </div>
    <div class="uk-margin-bottom">
        <label class="uk-form-label" for="{{ $key }}.hints">{{ trans('messages.hints.label') }}</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="{{ $key }}.hints" name="translation[{{ $key }}][hints]" value="{{ old('translation.'. $key .'.hints') }}">
        </div>
    </div>
    <div class="uk-margin-bottom">
        <label class="uk-form-label" for="{{ $key }}.difficulty">{{ trans('messages.difficulty.label') }}</label>
        <div class="uk-form-controls">
            <input class="uk-input" id="{{ $key }}.difficulty" name="translation[{{ $key }}][difficulty]" value="{{ old('translation.'. $key .'.difficulty') }}">
        </div>
    </div>
@endforeach