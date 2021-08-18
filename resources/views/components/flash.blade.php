@props(['type' => 'success', 'message'] )
<p
    x-data="{show: true}"
    x-show="show"
    x-init="setTimeout(() => show = false, 4000)"
    class="fixed bottom-3 right-3 bg-blue-300 p-5 rounded"
>{{ $message }}</p>
