{strip}
<ff-communication {foreach key=$key item=$value from=$ff.communicationParams}
                    {if $key == 'add-params'}add-params="{$value},{$ff.add_params}"{else}{$key nofilter}="{$value}"{/if}
                  {/foreach}
                  {if $customer.is_logged}user-id="{$customer.id}"{/if}
                  only-search-params="true"
                  search-immediate="{$ff.search_immediate|default:'false'}"
                  sid="{$static_token|truncate:30:''}"
                  currency-code="{$currency.iso_code}"
                  currency-country-code="{$language.locale}"></ff-communication>
{/strip}

{literal}
<!-- Set FieldRoles -->
<script>
    document.addEventListener('ffReady', function () {
        factfinder.communication.fieldRoles = {/literal}{$ff.field_roles|@json_encode nofilter}{literal};

        factfinder.communication.FFCommunicationEventAggregator.addBeforeDispatchingCallback(function (event) {
            var redirectPath = '{/literal}{$ff.url.search}{literal}';
            if (event.type === 'search' && !event.__immediate) {
                delete event.type;
                window.location = redirectPath + factfinder.common.dictToParameterString(event);
            }
        });
    });
</script>
{/literal}
