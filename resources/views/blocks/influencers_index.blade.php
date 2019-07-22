<div class="col-md-12">
    @include('components.influencers_index')
    @include('components.paginator')
    @include('components.download_btn', ['action' => ['title' => 'Download List', 'path' => URL::route('influencers.download.list')]])
</div>