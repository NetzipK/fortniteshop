<div class="row grid" id="products" style="display: flex; justify-content: center; flex-wrap:wrap;">     
    @foreach($articles as $article)
      @component('shop.components.article-grid-item')
        @slot('article', $article)
      @endcomponent
    @endforeach
</div>