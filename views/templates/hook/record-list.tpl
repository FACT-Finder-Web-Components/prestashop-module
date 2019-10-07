<ff-record-list unresolved class="products row">
    <ff-record>
        <article class="product-miniature js-product-miniature" data-id-product="{literal}{{record.MagentoEntityId}}{/literal}" itemscope itemtype="http://schema.org/Product">
            <div class="thumbnail-container">
                <a data-anchor="{literal}{{record.ProductUrl}}{/literal}" data-redirect="{literal}{{record.ProductUrl}}{/literal}" data-redirect-target="_self" class="thumbnail product-thumbnail">
                    <img data-image data-image-onerror="{$urls.no_picture_image.medium.url}" alt="{literal}{{record.Name}}{/literal}"/>
                </a>

                <div class="product-description">
                    <h2 class="h3 product-title" itemprop="name">
                        <a data-anchor="{literal}{{record.ProductUrl}}{/literal}" data-redirect="{literal}{{record.ProductUrl}}{/literal}" data-redirect-target="_self">{literal}{{record.Name}}{/literal}</a>
                    </h2>

                    <div class="product-price-and-shipping">
                        <span class="sr-only">{l s='Price' d='Shop.Theme.Catalog'}</span>
                        <span itemprop="price" class="price">{literal}{{record.Price}}{/literal}</span>
                    </div>
                </div>

                <div class="highlighted-informations no-variants hidden-sm-down">
                    <a class="quick-view" href="#" data-link-action="quickview">
                        <i class="material-icons search">&#xE8B6;</i>
                        {l s='Quick view' d='Shop.Theme.Actions'}
                    </a>
                </div>
            </div>
        </article>
    </ff-record>
</ff-record-list>
