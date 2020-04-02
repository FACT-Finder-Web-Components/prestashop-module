{extends file='page.tpl'}

{block name='left_column'}
  {if $ff.features.asn}
    <div id="left-column" class="col-xs-12 col-sm-4 col-md-3">
      <div class="block-categories hidden-sm-down" id="search_filters">
        {widget name='factfinder' hook='asn'}
      </div>
    </div>
  {/if}
{/block}

{block name='content'}
  <section id="main">
    {block name='product_list_header'}
      <div id="js-product-list-header">
        <div class="card card-block">
          <h1 class="h1">{l s='Search Results' mod='factfinder'}</h1>
        </div>
      </div>
    {/block}

    <section id="products">
      {if $ff.features.breadcrumbs}{widget name='factfinder' hook='breadcrumbs'}{/if}
      {if $ff.features.campaigns}{widget name='factfinder' hook='campaigns'}{/if}

      <div class="ff-navigation ff-navigation-top row products-selection">
        {if $ff.features.products_per_page}{widget name='factfinder' hook='products-per-page'}{/if}
        {if $ff.features.sorting}{widget name='factfinder' hook='sortbox'}{/if}
      </div>

      {widget name='factfinder' hook='record-list'}

      {if $ff.features.paging}
        <div class="ff-navigation ff-navigation-bottom">
          {widget name='factfinder' hook='paging'}
        </div>
      {/if}
    </section>
  </section>
{/block}
