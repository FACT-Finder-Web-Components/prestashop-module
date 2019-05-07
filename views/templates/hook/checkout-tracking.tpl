<ff-checkout-tracking>
  {foreach from=$order.products item=$p}
    <ff-checkout-tracking-item record-id="{$p.product_id}{if $p.product_attribute_id}-{$p.product_attribute_id}{/if}" count="{$p.quantity}"></ff-checkout-tracking-item>
  {/foreach}
</ff-checkout-tracking>
