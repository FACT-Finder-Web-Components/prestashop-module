{strip}
<ff-communication {foreach key=$key item=$value from=$ff.communicationParams}
                    {$key nofilter}="{$value}"
                  {/foreach}
                  {if $customer.is_logged}user-id="{$customer.id}"{/if}
                  search-immediate="{$ff.search_immediate|default:'false'}"
                  sid="{$static_token|truncate:30:''}"
                  currency-code="{$currency.iso_code}"
                  currency-country-code="{$language.locale}" />
{/strip}

{literal}
<!-- Set FieldRoles -->
<script>
    document.addEventListener('ffReady', function () {
        factfinder.communication.fieldRoles = {"brand":"Manufacturer","campaignProductNumber":"ProductNumber","deeplink":"ProductUrl","description":"Description","displayProductNumber":"ProductNumber","ean":"EAN","imageUrl":"ImageUrl","masterArticleNumber":"MasterProductNumber","price":"Price","productName":"Name","trackingProductNumber":"ProductNumber"};

        factfinder.communication.FFCommunicationEventAggregator.addBeforeDispatchingCallback(function (event) {
            var redirectPath = '{/literal}{$ff.url.search}{literal}';
            if (event.type === 'search' && window.location.href.indexOf(redirectPath) < 0) {
                var params = factfinder.common.dictToParameterString(event);
                window.location = redirectPath + params;
            }
        });
    });
</script>
{/literal}
