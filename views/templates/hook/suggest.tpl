<ff-suggest id="ffSuggest" layout="block" unresolved>
  <section id="searchContainer" class="searchTermContainer">
    <div data-container="searchTerm">
      <p class="containerCaption">{l s='Search suggestions' mod='factfinder'}</p>
      <ff-suggest-item class="ff-suggest-element" type="searchTerm">
        <span class="ff-search-term">{literal}{{{name}}}{/literal}</span>
      </ff-suggest-item>
    </div>

    <div data-container="category">
      <p class="containerCaption">{l s='Category suggestions' mod='factfinder'}</p>
      <ff-suggest-item class="ff-suggest-element" type="category">
        <span class="ff-category">{literal}{{{name}}}{/literal}</span>
      </ff-suggest-item>
    </div>

    <div data-container="brand">
      <p class="containerCaption">{l s='Brands' mod='factfinder'}</p>
      <ff-suggest-item class="ff-suggest-element" type="brand">
        <span class="ff-brand">{literal}{{{name}}}{/literal}</span>
      </ff-suggest-item>
    </div>
  </section>

  <section id="productContainer" class="productsContainer">
    <div data-container="productName">
      <p class="containerCaption">{l s='Suggested products' mod='factfinder'}</p>
      <div>
        <ff-suggest-item class="ff-suggest-element ff-suggest-product" type="productName">
          <div class="container-image">
            <img class="img-fluid" data-image="{literal}{{image}}{/literal}" />
          </div>
          <div class="product-info">
            <div class="product-name">{literal}{{{name}}}{/literal}</div>
            <div class="product-brand">{literal}{{{attributes.Brand}}}{/literal}</div>
            <div class="product-availability">
              {literal}{{#attributes.Availability}}{/literal}{l s='Available' mod='factfinder'}{literal}{{/attributes.Availability}}{/literal}
              {literal}{{^attributes.Availability}}{/literal}{l s='Out of stock' mod='factfinder'}{literal}{{/attributes.Availability}}{/literal}
            </div>
            <div class="product-price">{literal}{{attributes.Price}}{/literal}</div>
          </div>
        </ff-suggest-item>
      </div>
    </div>
  </section>
</ff-suggest>
