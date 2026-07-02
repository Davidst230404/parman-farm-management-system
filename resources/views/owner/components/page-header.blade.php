<div class="{{ $class ?? 'dash-welcome' }}">
    <div class="{{ $titleWrapClass ?? '' }}">
        <h2 class="{{ isset($titleWrapClass) ? '' : 'dash-welcome__title' }}">{!! $title !!}</h2>
        <p class="{{ isset($titleWrapClass) ? '' : 'dash-welcome__sub' }}">{!! $subtitle !!}</p>
    </div>
    @if(isset($actions))
        <div class="{{ $actionsClass ?? 'dash-welcome__actions' }}">
            {!! $actions !!}
        </div>
    @endif
</div>
