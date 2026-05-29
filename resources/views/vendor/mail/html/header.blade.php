@props(['url'])
@php($branding = \App\Support\Branding::toArray())
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ $branding['logo'] }}" class="logo" alt="{{ $branding['name'] }}">
</a>
</td>
</tr>
