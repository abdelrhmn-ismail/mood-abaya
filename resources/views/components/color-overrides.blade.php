@php
    $colorMap = [
        'color_brand_black'     => ['--brand-black', '--brand-black-rgb'],
        'color_brand_teal'      => ['--brand-teal', '--brand-teal-rgb'],
        'color_brand_teal_dark' => ['--brand-teal-dark', '--brand-teal-dark-rgb'],
        'color_brand_white'     => ['--brand-white', '--brand-white-rgb'],
        'color_brand_gold'      => ['--brand-gold', '--brand-gold-rgb'],
        'color_brand_gold_dark' => ['--brand-gold-dark', '--brand-gold-dark-rgb'],
    ];
    $overrides = [];
    foreach ($colorMap as $settingKey => [$hexVar, $rgbVar]) {
        $v = \App\Models\Setting::get($settingKey, '');
        if ($v !== '' && preg_match('/^#?([a-fA-F0-9]{6})$/', $v, $m)) {
            $hex = '#' . $m[1];
            $r = hexdec(substr($m[1], 0, 2));
            $g = hexdec(substr($m[1], 2, 2));
            $b = hexdec(substr($m[1], 4, 2));
            $overrides[] = "{$hexVar}:{$hex}";
            $overrides[] = "{$rgbVar}:{$r} {$g} {$b}";
        }
    }
@endphp
@if(count($overrides))
<style>:root{ {!! implode(';', $overrides) !!} }</style>
@endif
