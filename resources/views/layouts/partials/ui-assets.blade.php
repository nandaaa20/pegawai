{{-- Portfolio builds are committed to public/ui so both admin and guest
     screens load their actual Tailwind CSS even when npm run dev is stopped.
     Fall back to standard Vite only when the compiled build is absent. --}}
@php
    $uiManifestFile = public_path('ui/manifest.json');
    $uiManifest = is_file($uiManifestFile)
        ? json_decode(file_get_contents($uiManifestFile), true)
        : null;
    $uiCss = is_array($uiManifest) ? ($uiManifest['resources/css/app.css']['file'] ?? null) : null;
    $uiJs = is_array($uiManifest) ? ($uiManifest['resources/js/app.js']['file'] ?? null) : null;
    $uiBuildReady = $uiCss && $uiJs
        && is_file(public_path('ui/'.$uiCss))
        && is_file(public_path('ui/'.$uiJs));
@endphp
@if($uiBuildReady)
    <link rel="stylesheet" href="{{ asset('ui/'.$uiCss) }}">
    <script type="module" src="{{ asset('ui/'.$uiJs) }}"></script>
@else
    @vite(['resources/css/app.css', 'resources/js/app.js'])
@endif
