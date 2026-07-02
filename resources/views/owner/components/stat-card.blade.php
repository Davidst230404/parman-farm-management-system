<div class="{{ $cardClass ?? ('stat-card stat-card--' . ($theme ?? 'dark')) }}">
    <img src="{{ asset(str_replace('resources/', '', $icon)) }}" alt="{{ $label }}" class="{{ $iconClass ?? 'stat-card__icon' }}">
    <div class="{{ $contentClass ?? 'stat-card__content' }}">
        <div class="{{ $valueClass ?? 'stat-card__value' }}" @if(isset($valueId)) id="{{ $valueId }}" @endif @if(isset($valueStyle)) style="{{ $valueStyle }}" @endif>{!! $value !!}</div>
        <div class="{{ $labelClass ?? 'stat-card__label' }}">{{ $label }}</div>
        <div class="{{ $subClass ?? 'stat-card__sub' }}" @if(isset($subStyle)) style="{{ $subStyle }}" @endif>{!! $sub !!}</div>
    </div>
</div>
