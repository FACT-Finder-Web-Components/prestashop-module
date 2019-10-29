{extends file='module:factfinder/views/templates/front/search.tpl'}

{block name='left_column'}
  <div id="left-column" class="col-xs-12 col-sm-4 col-md-3">
    {widget name="ps_categorytree" hook='displayLeftColumn'}
    <div class="block-categories hidden-sm-down" id="search_filters">
      {widget name='factfinder' hook='asn'}
    </div>
  </div>
{/block}

{block name='product_list_header'}
  {include file='catalog/_partials/category-header.tpl' listing=$listing category=$category}
{/block}
