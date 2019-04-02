{extends file='page.tpl'}

{block name='left_column'}
  <div id="left-column" class="col-xs-12 col-sm-4 col-md-3">
    <div class="block-categories hidden-sm-down" id="search_filters">
      {widget name="factfinder" hook='asn'}
    </div>
  </div>
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
      {widget name="factfinder" hook='breadcrumb'}
      {widget name="factfinder" hook='campaign'}

      <div class="ff-navigation ff-navigation-top row products-selection">
        {widget name="factfinder" hook='products_per_page'}
        {widget name="factfinder" hook='sortbox'}
      </div>

      {widget name="factfinder" hook='record_list'}

      <div class="ff-navigation ff-navigation-bottom">
        {widget name="factfinder" hook='paging'}
      </div>
    </section>
  </section>
{/block}
