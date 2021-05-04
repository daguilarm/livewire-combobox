<style>
    /* Loading color */
    :root {
        --background: rgba(129, 140, 248, 1);
    }
    /* Minify css */
    .loading-ellipsis{position:relative;width:80px;height:25px}.loading-ellipsis div{position:absolute;width:13px;height:13px;border-radius:50%;background:var(--background);animation-timing-function:cubic-bezier(0,1,1,0)}.loading-ellipsis div:nth-child(1){left:8px;animation:loading-ellipsis1 .6s infinite}.loading-ellipsis div:nth-child(2){left:8px;animation:loading-ellipsis2 .6s infinite}.loading-ellipsis div:nth-child(3){left:32px;animation:loading-ellipsis2 .6s infinite}.loading-ellipsis div:nth-child(4){left:56px;animation:loading-ellipsis3 .6s infinite}@keyframes loading-ellipsis1{0%{transform:scale(0)}100%{transform:scale(1)}}@keyframes loading-ellipsis3{0%{transform:scale(1)}100%{transform:scale(0)}}@keyframes loading-ellipsis2{0%{transform:translate(0,0)}100%{transform:translate(24px,0)}}
</style>

<div id="livewire-combobox-loading" class="flex relative mt-2" wire:loading>
    <label for="livewire-combobox-loading">&nbsp;</label>
    <div class="fixed">
        <div class="loading-ellipsis">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>