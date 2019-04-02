<ff-suggest layout="block" unresolved>
  <section id="searchContainer" class="searchTermContainer">
    <div data-container="searchTerm">
      <p class="containerCaption">{l s='Search suggestions' mod='factfinder'}</p>
      <ff-suggest-item type="searchTerm">
        <span>{literal}{{{name}}}{/literal}</span>
      </ff-suggest-item>
    </div>

    <div data-container="category">
      <p class="containerCaption">{l s='Category suggestions' mod='factfinder'}</p>
      <ff-suggest-item type="category">
        <span>{literal}{{{name}}}{/literal}</span>
      </ff-suggest-item>
    </div>

    <div data-container="brand">
      <p class="containerCaption">{l s='Brands' mod='factfinder'}</p>
      <ff-suggest-item type="brand">
        <span>{literal}{{{name}}}{/literal}</span>
      </ff-suggest-item>
    </div>
  </section>

  <section id="productContainer" class="productsContainer">
    <div data-container="productName">
      <p class="containerCaption">{l s='Suggested products' mod='factfinder'}</p>
      <div>
        <ff-suggest-item type="productName">
          <a href="{literal}{{attributes.deeplink}}{/literal}" data-redirect="{literal}{{attributes.deeplink}}{/literal}" data-redirect-target="_blank">
            <img data-image="{literal}{{{suggestions.image}}{/literal}}" />
            <div class="product-center">
              <div class="product-name">{literal}{{{name}}}{/literal}</div>
              <div>{l s='Shipping' mod='factfinder'}</div>
              <div>{l s='Rating' mod='factfinder'} </div>
            </div>
            <div class="product-right">
              <div class="product-price">{literal}{{attributes.Price}}{/literal}</div>
              <div class="product-availabilitytext">{literal}{{attributes.availabilitytext}}{/literal}</div>
            </div>
          </a>
        </ff-suggest-item>
      </div>
    </div>
  </section>
</ff-suggest>
